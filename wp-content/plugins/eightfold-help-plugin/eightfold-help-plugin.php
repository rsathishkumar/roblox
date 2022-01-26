<?php
/*
Plugin Name: Eightfold Help
Plugin URI:
Description: Talentnetwork Help page.
Version: 1.0
Author:
Author URI:
License: GPL2
*/


// Our custom post type function
function create_posttype() {

    //register taxonomy for custom post tags
    register_taxonomy(
        'help-tag', //taxonomy
        'help', //post-type
        array(
            'hierarchical'  => false,
            'label'         => __( 'Help page tag','taxonomy general name'),
            'singular_name' => __( 'Help page tag', 'taxonomy general name' ),
            'rewrite'       => true,
            'query_var'     => true,
            'show_ui' => true,
            'update_count_callback' => '_update_post_term_count',
        ));


    //register custom posts type
    $snippet_pt_args = array(
        'labels' => array(
            'name' => 'Help Page',
            'singular_name' => 'Help Page',
        ),
        'taxonomies' => array('category', 'help-tag'),
        'public' => true,
        'menu_icon'   => 'dashicons-groups',
        'show_ui' => true,
        'rewrite' => array('slug'  => 'help',
            'with_front'     =>false,
            'menu_position'     => null),
        'label'     => 'Help Page'
    );

    register_post_type( 'help', $snippet_pt_args);

    // get param from eightfold\
    if ( isset($_GET['token']) && $_GET['token'] ) {
        $token = wp_strip_all_tags($_GET['token']);
        try {

            $headers = array (
                'Content-Type:application/json',
            );
            $headers[] = 'Authorization:Basic ZHZ1YmpjY2t2d3JxZWttdmF0cnRkZWthcWp4dGF6cXA6';

            $ch = curl_init();
            if ($ch === false) {
                throw new Exception('failed to initialize');
            }
            curl_setopt($ch, CURLOPT_URL,"https://stage.eightfold-gov.ai/verify_user_token?token=".$token);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result=curl_exec ($ch);
            curl_close ($ch);
            setcookie('wordpress_eightfold_user', "", 100, '/');
            if (!empty($result)) {
                $results = json_decode($result);
                if (isset($results->email)) {
                    $email = $results->email;
                    setcookie('wordpress_eightfold_user', $email, strtotime('+1 day'), '/');
                }
            }
        } catch(Exception $e) {
            error_log("API token error");
        }
    }
}
// Hooking up our function to plugin setup
add_action( 'init', 'create_posttype' );

add_filter( 'elementor/widget/render_content', function( $content, $widget ) {
    if ( 'theme-archive-title' === $widget->get_name() ) {
        $search_term = $_GET['s'];
        global $wpdb;

        $result_doc_id_arr = [];
        if($search_term != ""){
            // get result count on basis of search text
            $search_term_arr = explode(" ",$search_term);
            foreach($search_term_arr as $value){
                $doc_id_arr = get_search_result_doc_id($value);
                $result_doc_id_arr = array_unique(array_merge($result_doc_id_arr, $doc_id_arr), SORT_REGULAR);

            }
            $count = count($result_doc_id_arr);

            $title = $count." result(s) found for '$search_term' ";
            $title_content = "<h1 class='elementor-heading-title elementor-size-default'>$title</h1>";
            $content =  $title_content;

        }
        else{
            // get result count on basis of blanck text
            $sql = "SELECT count(*) as count FROM wp_posts WHERE post_type = 'help' ";
            $result = $wpdb->get_results($sql);
            $count = 0;
            if($result){
                foreach( $result as $results ) {
                    $count = $results->count;
                }
            }
            $content = do_shortcode($content);

        }

    }
    else if ('heading' === $widget->get_name()) {
        $content = do_shortcode($content);
    }

    return $content;
}, 10, 2 );

function get_search_result_doc_id($search_term){
    $search_term = trim($search_term);
    $doc_id_arr = [];
    global $wpdb;

    $category = (isset($_GET['category']))?$_GET['category']:'';
    $where = '';
    $condition = '';
    if ($category) {
        $where = 'join wp_term_relationships as wt on wt.object_id = wp_posts.ID join wp_terms tt on tt.term_id = wt.term_taxonomy_id';
        $condition = "and tt.slug = '$category'";
    }

    $sql = "SELECT DISTINCT(wp_relevanssi.doc) as doc_id FROM wp_posts join wp_relevanssi on wp_relevanssi.doc = wp_posts.ID $where where wp_posts.post_type = 'help' and wp_relevanssi.term like '%" . $search_term . "%' $condition";

    $result = $wpdb->get_results($sql);
    if($result){
        foreach( $result as $results ) {
            $doc_id_arr[] = $results->doc_id;
        }
    }
    return $doc_id_arr;

}

function help_previous_page_title_link() {
    $postid = isset($_GET['post_id']) ? $_GET['post_id'] : '';
    $link = '';
    if ($postid) {
        $post = get_post($postid);
        $url = get_permalink($post->ID);
        $link = '<a href="' . $url . '" class="previous_page_title_link" title="' . $post->post_title . '">' . $post->post_title . '</a>';
    }

    return $link;
}
// register shortcode
add_shortcode('help_previous_page_title_link', 'help_previous_page_title_link');

add_shortcode( 'return_post_id', '_shortcode_return_post_id' );

function _shortcode_return_post_id() {
    return get_the_ID();
}

// hook function to filter by post category
add_action( 'elementor/query/post_category_filter', function( $query ) {
    // Here we set the query to fetch posts with
    // post type of 'custom-post-type1' and 'custom-post-type2'
    // $query->set( 'post_type', [ 'custom-post-type1', 'custom-post-type2' ] );
    $queried_object = get_queried_object();
    $cat = isset($_GET['category']) ? $_GET['category'] : '';
    $tag = isset($_GET['tag']) ? $_GET['tag'] : '';

    $tax_query = array('relation' => 'AND');
    if (isset($cat))
    {
        $id = get_term_by('slug', $cat, 'category');
        $tax_query[] =  array(
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => $id->term_id
        );
    }
    if (isset($tag) && !empty($tag))
    {
        $id = get_term_by('slug', $tag, 'help-tag');
        $tax_query[] =  array(
            'taxonomy' => 'help-tag',
            'field' => 'term_id',
            'terms' => $id->term_id
        );
    }
    $query->set( 'tax_query', $tax_query );
} );

add_filter( 'shortcode_atts_wpcf7', 'custom_shortcode_atts_wpcf7_filter', 10, 3 );
function custom_shortcode_atts_wpcf7_filter( $out, $pairs, $atts ) {
    $your_email = 'user-email';
    $cookieValue = $_COOKIE['eightfold_user'];
    if ( isset( $cookieValue ) ) {
        $out[$your_email] = $atts[$your_email] = $cookieValue;
    }
    return $out;
}

add_filter( 'the_title', 'do_shortcode', 10, 2 );

add_filter( 'single_post_title', 'do_shortcode' );

add_filter( 'wpseo_title', 'do_shortcode' );

add_filter( 'category_name', 'do_shortcode' );

add_action("wpcf7_before_send_mail", "wpcf7_alter_subject");

function wpcf7_alter_subject($WPCF7_ContactForm)
{

    //Get current form
    $wpcf7      = WPCF7_ContactForm::get_current();

    // get current SUBMISSION instance
    $submission = WPCF7_Submission::get_instance();

    $template = WPCF7_ContactForm::get_template();

    // Ok go forward
    if ($submission) {

        // get submission data
        $data = $submission->get_posted_data();

        // nothing's here... do nothing...
        if (empty($data))
            return;

        $message = $data['question'];

        $short_message = substr($message, 0, 50);
        $mail         = $wpcf7->prop('mail');

        $exchange_name = do_shortcode('[sc name="exchange_name"]');

        // Find/replace the "[your-name]" tag as defined in your CF7 email body
        // and add changes name
        $mail['subject'] = str_replace('[support]', '[support]', $mail['subject']);
        $mail['subject'] = str_replace('[exchange_name]', '['.$exchange_name.']', $mail['subject']);
        $mail['subject'] = str_replace('[question]', $short_message, $mail['subject']);

        // Save the email body
        $wpcf7->set_properties(array(
            "mail" => $mail
        ));

        // return current cf7 instance
        return $wpcf7;
    }
}

/* Elementor Pro Search forced products only */
add_action( 'elementor_pro/search_form/after_input', function( $form ) {
    $term_id = '';
    if (isset($_GET['category'])) {
        $term_id = $_GET['category'];
    }
    else {
        $category = get_the_category();
        if ($category) {
            $term_id = $category[0]->slug;
        }
    }
    if ($term_id) {
        echo "<input type='hidden' name='category' value='$term_id' />";
    }
}, 10, 1 );

add_filter( 'relevanssi_hits_filter', 'rlv_gather_categories', 99 );
function rlv_gather_categories( $hits ) {
    $category = (isset($_GET['category']))?$_GET['category']:'';
    if ($category) {
        $i = 0;
        foreach ( $hits[0] as $hit ) {
            $terms = get_the_terms( $hit->ID, 'category' );
            if ( is_array( $terms ) ) {
                foreach ( $terms as $term ) {
                    if ( $term->slug != $category ) {
                        unset($hits[0][$i]);
                    }
                }
            }
            $i++;
        }
    }
    return $hits;
}