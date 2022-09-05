<?php

function init()
{
    wp_enqueue_script('script', get_template_directory_uri() . '/assets/js/main.js', array(), 1.1, true);

    wp_add_inline_script('script', 'const ENDPOINT = ' . json_encode(array(
        'url' =>  get_template_directory_uri() . '/api/index.php',
    )), 'before');
}

add_action('wp_enqueue_scripts', 'init');
