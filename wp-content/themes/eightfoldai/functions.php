<?php

add_action( 'wp_enqueue_scripts', 'eightfold_enqueue_styles' , 99);
function eightfold_enqueue_styles() {
  wp_enqueue_style( 'eightfold-style', get_stylesheet_uri(),
    array(  ),
    wp_get_theme()->get('Version') // this only works if you have Version in the style header
  );
}
