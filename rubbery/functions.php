<?php	

function init(){
    wp_enqueue_script( 'script', get_template_directory_uri() . '/assets/js/main.js', array (), 1.1, true);
}

add_action('wp_enqueue_scripts', 'init');