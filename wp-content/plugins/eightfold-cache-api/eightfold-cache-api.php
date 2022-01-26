<?php
/**
 * Plugin Name:       Eightfold Cache Api response
 * Plugin URI:
 * Description:       Create a custom table to cache api and response in WordPress
 * Version:           1.0
 * Requires at least: 5.0
 * Text Domain:       eightfold-cache--api-plugin
 */

// # our databse table version
global $ar_db_version;
$ar_db_version = '1.0';


/**
 * create a database table
 */
function ar_customtable_install()
{
    global $wpdb;
    global $ar_db_version;

    // # we use the same table prefix in wp-config.php
    $table_name = $wpdb->prefix . 'tbl_cache_jobs_api';



    // # we set the default character set and collation for the table to avoid the "?" conversion.
    $charset_collate = $wpdb->get_charset_collate();

    // # we add the SQL statement for creating a database table
    // The SQl statement must follow the rules of dbDelta function
    $sql = "CREATE TABLE $table_name (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          expire_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
          job_api_url varchar(1000) NOT NULL,
          job_api_response longtext NOT NULL,
          created_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
          PRIMARY KEY  (id)
        ) $charset_collate;";

    // # To use the dbDelta class, we have to load this file, as it is not loaded by default
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // # call the dbDelta class
    dbDelta($sql);



    // # insert our database table version into the wp_options table via add_option function
    add_option('ar_db_version', $ar_db_version);
}

/**
 * create a database table
 */
function ar_customtable_uninstall()
{
    global $wpdb;
    global $ar_db_version;

    // # we use the same table prefix in wp-config.php
    $table_name = $wpdb->prefix . 'tbl_cache_jobs_api';

    // # we set the default character set and collation for the table to avoid the "?" conversion.
    $charset_collate = $wpdb->get_charset_collate();

    // # we add the SQL statement for deleting a database table
    // The SQl statement must follow the rules of dbDelta function
    $sql = "DROP TABLE IF EXISTS $table_name";

    // # To use the dbDelta class, we have to load this file, as it is not loaded by default
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    // # call the dbDelta class
    //dbDelta($sql);
    $wpdb->query($sql);

    // # delete our database table version into the wp_options table via add_option function
    delete_option('ar_db_version', $ar_db_version);
}


register_activation_hook( __FILE__, 'ar_customtable_install' );

register_deactivation_hook( __FILE__, 'ar_customtable_uninstall' );
