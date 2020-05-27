<?php

    // Clean up the <head>
    /*
    function removeHeadLinks() {
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
    }

    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');*/

    function clean_head() {
        //category feeds
        remove_action( 'wp_head', 'feed_links_extra', 3 );

        //post and comments feed
        remove_action( 'wp_head', 'feed_links', 2 );

        //only required if you are looking to blog using an external tool
        remove_action( 'wp_head', 'rsd_link');

        //something to do with windows live writer
        remove_action( 'wp_head', 'wlwmanifest_link');

        //next previous post links
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

        //generator tag
        remove_action( 'wp_head', 'wp_generator');

        //short links like ?p=124
        remove_action( 'wp_head', 'wp_shortlink_wp_head');

        // disable emojis
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
    }

    clean_head();

    /*
    // Add RSS links to <head> section
        add_theme_support('automatic-feed-links');
        function remove_comments_rss( $for_comments ) {
            return;
        }
        add_filter('post_comments_feed_link','remove_comments_rss');
    */

    add_theme_support( 'html5',
                array(
                    'search-form',
                    'caption'
                    //'comment-list',
                    //'comment-form',
                    //'gallery',
                    )
                );


    /*
     * Post Thumbnails
     * ========================================================================================================
     */
    // Adds support to theme thumbnails
    if (function_exists('add_theme_support')) {
        add_theme_support('post-thumbnails');
    }

    /*
    * Login logo
    * ========================================================================================================
    */
    function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/wp-login.png);
            width: 250px;
            height: 60px;
            background-size: auto;
        }
    </style>
    <?php }
    add_action( 'login_enqueue_scripts', 'my_login_logo' );

    function my_login_logo_url() {
        return home_url();
    }
    add_filter( 'login_headerurl', 'my_login_logo_url' );

 ?>
