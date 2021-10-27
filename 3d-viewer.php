<?php

/*
 * Plugin Name: 3D Viewer
 * Plugin URI:  https://bplugins.com/
 * Description: Easily display interactive 3D models on the web. Supported File type .glb, .gltf
 * Version: 1.0.6
 * Author: bPlugins LLC
 * Author URI: http://bplugins.com
 * License: GPLv3
 * Text Domain:  model-viewer
 * Domain Path:  /languages
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( function_exists( 'bp3dv_fs' ) ) {
    bp3dv_fs()->set_basename( false, __FILE__ );
} else {
    
    if ( !function_exists( 'bp3dv_fs' ) ) {
        // Create a helper function for easy SDK access.
        function bp3dv_fs()
        {
            global  $bp3dv_fs ;
            
            if ( !isset( $bp3dv_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $bp3dv_fs = fs_dynamic_init( array(
                    'id'             => '8795',
                    'slug'           => '3d-viewer',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_5e6ce3f226c86e3b975b59ed84d6a',
                    'is_premium'     => false,
                    'premium_suffix' => 'Pro',
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'trial'          => array(
                    'days'               => 7,
                    'is_require_payment' => false,
                ),
                    'menu'           => array(
                    'slug'       => 'edit.php?post_type=bp3d-model-viewer',
                    'first-path' => 'edit.php?post_type=bp3d-model-viewer&page=bp3d-support',
                ),
                    'is_live'        => true,
                ) );
            }
            
            return $bp3dv_fs;
        }
        
        // Init Freemius.
        bp3dv_fs();
        // Signal that SDK was initiated.
        do_action( 'bp3dv_fs_loaded' );
    }
    
    /*Some Set-up*/
    define( 'BP3D_VIEWER_PLUGIN_DIR', WP_PLUGIN_URL . '/' . plugin_basename( dirname( __FILE__ ) ) . '/' );
    define( 'BP3D_VIEWER_PLUGIN_VERSION', '1.0.6' );
    // load text domain
    function bp3dviewer_load_textdomain()
    {
        load_plugin_textdomain( 'model-viewer', false, dirname( __FILE__ ) . "/languages" );
    }
    
    add_action( "plugins_loaded", 'bp3dviewer_load_textdomain' );
    // External files Inclusion
    require_once 'inc/mimes/enable-mime-type.php';
    require_once 'inc/csf/csf-config.php';
    require_once 'admin/ads/submenu.php';
    // Shortcode and Freemius Conditional Files
    // free version code
    
    if ( bp3dv_fs()->is_free_plan() ) {
        include "public/shortcode/shortcode.php";
        require_once 'inc/metabox-options-free.php';
    }
    
    // Custom post-type
    function bp_3d_viewer()
    {
        $labels = array(
            'name'           => __( '3D Viewer', 'model-viewer' ),
            'menu_name'      => __( '3D Viewer', 'model-viewer' ),
            'name_admin_bar' => __( '3D Viewer', 'model-viewer' ),
            'add_new'        => __( 'Add New', 'model-viewer' ),
            'add_new_item'   => __( 'Add New ', 'model-viewer' ),
            'new_item'       => __( 'New 3D Viewer ', 'model-viewer' ),
            'edit_item'      => __( 'Edit 3D Viewer ', 'model-viewer' ),
            'view_item'      => __( 'View 3D Viewer ', 'model-viewer' ),
            'all_items'      => __( 'All 3D Viewers', 'model-viewer' ),
            'not_found'      => __( 'Sorry, we couldn\'t find the Feed you are looking for.' ),
        );
        $args = array(
            'labels'          => $labels,
            'description'     => __( '3D Viewer Options.', 'model-viewer' ),
            'public'          => false,
            'show_ui'         => true,
            'show_in_menu'    => true,
            'menu_icon'       => 'dashicons-format-image',
            'query_var'       => true,
            'rewrite'         => array(
            'slug' => 'model-viewer',
        ),
            'capability_type' => 'post',
            'has_archive'     => false,
            'hierarchical'    => false,
            'menu_position'   => 20,
            'supports'        => array( 'title' ),
        );
        register_post_type( 'bp3d-model-viewer', $args );
    }
    
    add_action( 'init', 'bp_3d_viewer' );
    // Additional admin style
    function bp3d_admin_style()
    {
        wp_register_style( 'bp3d-custom-style', plugin_dir_url( __FILE__ ) . 'public/css/custom-style.css' );
        wp_enqueue_style( 'bp3d-custom-style' );
    }
    
    add_action( 'admin_enqueue_scripts', 'bp3d_admin_style' );
    //
    /*-------------------------------------------------------------------------------*/
    /*   Additional Features
        /*-------------------------------------------------------------------------------*/
    // Hide & Disabled View, Quick Edit and Preview Button
    function bp3d_remove_row_actions( $idtions )
    {
        global  $post ;
        
        if ( $post->post_type == 'bp3d-model-viewer' ) {
            unset( $idtions['view'] );
            unset( $idtions['inline hide-if-no-js'] );
        }
        
        return $idtions;
    }
    
    if ( is_admin() ) {
        add_filter(
            'post_row_actions',
            'bp3d_remove_row_actions',
            10,
            2
        );
    }
    // HIDE everything in PUBLISH metabox except Move to Trash & PUBLISH button
    function bp3d_hide_publishing_actions()
    {
        $my_post_type = 'bp3d-model-viewer';
        global  $post ;
        if ( $post->post_type == $my_post_type ) {
            echo  '
                <style type="text/css">
                    #misc-publishing-actions,
                    #minor-publishing-actions{
                        display:none;
                    }
                </style>
            ' ;
        }
    }
    
    add_action( 'admin_head-post.php', 'bp3d_hide_publishing_actions' );
    add_action( 'admin_head-post-new.php', 'bp3d_hide_publishing_actions' );
    /*-------------------------------------------------------------------------------*/
    // Remove post update massage and link
    /*-------------------------------------------------------------------------------*/
    function bp3d_updated_messages( $messages )
    {
        $messages['bp3d-model-viewer'][1] = __( 'Shortcode updated ', 'model-viewer' );
        return $messages;
    }
    
    add_filter( 'post_updated_messages', 'bp3d_updated_messages' );
    /*-------------------------------------------------------------------------------*/
    /* Change publish button to save.
       /*-------------------------------------------------------------------------------*/
    add_filter(
        'gettext',
        'bp3d_change_publish_button',
        10,
        2
    );
    function bp3d_change_publish_button( $translation, $text )
    {
        if ( 'bp3d-model-viewer' == get_post_type() ) {
            if ( $text == 'Publish' ) {
                return 'Save';
            }
        }
        return $translation;
    }
    
    /*-------------------------------------------------------------------------------*/
    /* Footer Review Request .
       /*-------------------------------------------------------------------------------*/
    add_filter( 'admin_footer_text', 'bp3d_admin_footer' );
    function bp3d_admin_footer( $text )
    {
        
        if ( 'bp3d-model-viewer' == get_post_type() ) {
            $url = 'https://wordpress.org/plugins/3d-viewer/reviews/?filter=5#new-post';
            $text = sprintf( __( 'If you like <strong> 3D Viewer </strong> please leave us a <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. Your Review is very important to us as it helps us to grow more. ', 'model-viewer' ), $url );
        }
        
        return $text;
    }
    
    /*-------------------------------------------------------------------------------*/
    /* Shortcode Generator area  .
       /*-------------------------------------------------------------------------------*/
    add_action( 'edit_form_after_title', 'bp3d_shortcode_area' );
    function bp3d_shortcode_area()
    {
        global  $post ;
        
        if ( $post->post_type == 'bp3d-model-viewer' ) {
            ?>
            <div class="shortcode_gen">
                <label for="bp3d_shortcode"><?php 
            esc_html_e( 'Copy this shortcode and paste it into your post, page, or text widget content', 'model-viewer' );
            ?>:</label>
    
                <span>
                    <input type="text" id="bp3d_shortcode" onfocus="this.select();" readonly="readonly" value="[3d_viewer id=<?php 
            echo  $post->ID ;
            ?>]" />
                </span>
    
            </div>
    <?php 
        }
    
    }
    
    // After activation redirect
    register_activation_hook( __FILE__, 'bp3d_plugin_activate' );
    add_action( 'admin_init', 'bp3d_plugin_redirect' );
    function bp3d_plugin_activate()
    {
        add_option( 'bp3d_plugin_do_activation_redirect', true );
    }
    
    function bp3d_plugin_redirect()
    {
        
        if ( get_option( 'bp3d_plugin_do_activation_redirect', false ) ) {
            delete_option( 'bp3d_plugin_do_activation_redirect' );
            //wp_redirect('edit.php?post_type=bp3d-model-viewer&page=bp3d-support');
        }
    
    }

}
