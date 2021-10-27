<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.


//
// Metabox of the PAGE
// Set a unique slug-like ID
//
$prefix = '_bp3dimages_';

//
// Create a metabox
//
CSF::createMetabox( $prefix, array(
  'title'        => '3D Viewer Settings',
  'post_type'    => 'bp3d-model-viewer',
  'show_restore' => true,
) );


//
// section: 3D Model Viewer Pro
//

CSF::createSection( $prefix, array(
  'fields' => array(

    // 3D Model Options
    array(
      'id'       => 'bp_3d_model_type',
      'type'     => 'button_set',
      'title'    => esc_html__('Model Type.', 'bp-showcase'),
      'subtitle' => esc_html__('Choose Model Type', 'bp-showcase'),
      'desc'     => esc_html__('Select Model Type, Default- Simple.', 'modelViewer'),
      'multiple' => false,
      'options'  => array(
        'msimple'  => 'simple',
        'mcycle'   => 'Cycle',
      ),
      'default'  => array('msimple')
    ),

    array(
      'id'           => 'bp_3d_src',
      'type'         => 'media',
      'button_title' => esc_html__('Upload Source', 'modelViewer'),
      'title'        => esc_html__('3D Source', 'modelViewer'),
      'subtitle'     => esc_html__('Choose 3D Model', 'modelViewer'),
      'desc'         => esc_html__('Upload or Select 3d object files. Supported file type: glb, glTF', 'modelViewer'),
      'dependency' => array( 'bp_3d_model_type', '==', 'msimple' ),
    ),
    array(
      'id'     => 'bp_3d_models',
      'type'   => 'repeater',
      'title'        => esc_html__('3D Cycle Models', 'modelViewer'),
      'subtitle'     => esc_html__('Cycling between 3D Models', 'modelViewer'),
      'button_title' => esc_html__('Add New Model', 'modelViewer'),
      'desc'         => esc_html__('Use Multiple Model in a row.', 'modelViewer'),
      'class'    => 'svp-readonly',
      'fields' => array(
        array(
          'id'    => 'model_src',
          'type'  => 'media',
          'title' =>  esc_html__('Model Source', 'modelViewer'),
          'desc'  => esc_html__('Upload or Select 3d object files. Supported file type: glb, glTF', 'modelViewer'),
        ),
    
      ),
      'dependency' => array( 'bp_3d_model_type', '==', 'mcycle' ),
    ),
    array(
      'id'           => 'bp_model_anim_du',
      'type'         => 'text',
      'title'        => esc_html__('Cycle Animation Duration', 'modelViewer'),
      'subtitle'     => esc_html__('Animation Duration Time at Seconds : 1000ms = 1sec', 'modelViewer'),
      'desc'         => esc_html__('Input Model Animation Duration Time (default: \'5\') Seconds', 'modelViewer'),
      'class'    => 'svp-readonly',
      'default'   => 5000,
      'dependency' => array( 'bp_3d_model_type', '==', 'mcycle' ),
    ),
    // Poster Options
    array(
      'id'       => 'bp_3d_poster_type',
      'type'     => 'button_set',
      'title'    => esc_html__('Poster Type.', 'bp-showcase'),
      'subtitle' => esc_html__('Choose Poster Type', 'bp-showcase'),
      'desc'     => esc_html__('Select Poster Type, Default- Simple.', 'modelViewer'),
      'class'    => 'svp-readonly',
      'multiple' => false,
      'options'  => array(
        'simple'  => 'simple',
        'cycle'   => 'Cycle',
      ),
      'default'  => array('simple'),
    ),
    array(
      'id'           => 'bp_3d_poster',
      'type'         => 'media',
      'button_title' => esc_html__('Upload Poster', 'modelViewer'),
      'title'        => esc_html__('3D Poster Image', 'modelViewer'),
      'subtitle'     => esc_html__('Display a poster until loaded', 'modelViewer'),
      'desc'         => esc_html__('Upload or Select 3d Poster Image.  if you don\'t want to use just leave it empty', 'modelViewer'),
      'class'    => 'svp-readonly',
      'dependency' => array( 'bp_3d_poster_type', '==', 'simple' ),
    ),
    array(
      'id'     => 'bp_3d_posters',
      'type'   => 'repeater',
      'title'        => esc_html__('Poster Images', 'modelViewer'),
      'subtitle'     => esc_html__('Cycling between posters', 'modelViewer'),
      'button_title' => esc_html__('Add New Poster Images', 'modelViewer'),
      'desc'         => esc_html__('Use multiple images for poster image.if you don\'t want to use just leave it empty', 'modelViewer'),
      'fields' => array(
        array(
          'id'    => 'poster_img',
          'type'  => 'upload',
          'title' => 'Poster Image'
        ),
    
      ),
      'dependency' => array( 'bp_3d_poster_type', '==', 'cycle' ),
      'class'    => 'svp-readonly',
    ),
    array(
      'id'           => 'bp_3d_width',
      'type'         => 'dimensions',
      'title'        => esc_html__('Width', 'modelViewer'),
      'desc'         => esc_html__('3D Viewer Width', 'modelViewer'),
      'default'  => array(
        'width'  => '100',
        'unit'   => '%',
      ),
      'height'   => false,
    ),
    array(
      'id'           => 'bp_3d_height',
      'type'         => 'dimensions',
      'title'        => esc_html__('Height', 'modelViewer'),
      'desc'         => esc_html__('3D Viewer height', 'modelViewer'),
      'units'        => ['px', 'em', 'pt'],
      'default'  => array(
        'height' => '320',
        'unit'   => 'px',
      ),
      'width'   => false,
    ),
    array(
      'id'       => 'bp_camera_control',
      'type'     => 'switcher',
      'title'    => esc_html__('Moving Controls', 'modelViewer'),
      'desc'     => esc_html__('Use The Moving controls to enable user interaction', 'modelViewer'),
      'text_on'  => 'Yes',
      'text_off' => 'No',
      'default' => true,

    ),
    array(
      'id'        => 'bp_3d_zooming',
      'type'      => 'switcher',
      'title'     => 'Enable Zoom',
      'subtitle'  => esc_html__('Enable or Disable Zooming Behaviour', 'modelViewer'),
      'desc'      => esc_html__('If you wish to disable zooming behaviour please choose Yes.', 'modelViewer'),
      'text_on'   => 'Yes',
      'text_off'  => 'NO',
      'text_width'  => 60,
      'default'   => true,
    ),
    array(
      'id'        => 'bp_3d_progressbar',
      'type'      => 'switcher',
      'title'     => 'Progressbar',
      'subtitle'  => esc_html__('Enable or Disable Progressbar', 'modelViewer'),
      'desc'      => esc_html__('If you wish to disable Progressbar please choose No.', 'modelViewer'),
      'text_on'   => 'Yes',
      'text_off'  => 'NO',
      'text_width'  => 60,
      'default'   => true,
      'class'    => 'svp-readonly',
    ),
    array(
      'id'        => 'bp_3d_preloader',
      'type'      => 'switcher',
      'title'     => 'Preload',
      'subtitle'  => esc_html__('Preload with poster and show model on interaction', 'modelViewer'),
      'desc'      => esc_html__('Choose "Yes" if you want to use preload with poster image.', 'modelViewer'),
      'text_on'   => 'Yes',
      'text_off'  => 'NO',
      'text_width'  => 60,
      'class'    => 'svp-readonly',
      'default'   => false,
    ),
    array(
      'id'         => 'bp_3d_loading',
      'type'       => 'radio',
      'title'      => esc_html__('Loading Type', 'modelViewer'),
      'subtitle'   => esc_html('Choose Loading type, default:  \'Auto\' ', 'modelViewer'),
      'options'    => array(
        'auto'  => 'Auto',
        'lazy'  => 'Lazy',
        'eager' => 'Eager',
      ),
      'default'    => 'auto',
    ),
    array(
      'id'       => 'bp_3d_rotate',
      'type'     => 'switcher',
      'title'    => esc_html__('Auto Rotate', 'modelViewer'),
      'subtitle' => esc_html__('Enable or Disable Auto Rotation', 'modelViewer'),
      'desc'     => esc_html('Enables the auto-rotation of the model.', 'modelViewer'),
      'text_on'  => 'Yes',
      'text_off' => 'No',
      'class'    => 'svp-readonly',
      'default'  => true,
    ),
    
  ) // End fields


) );


/**
 * Register and enqueue a custom stylesheet in the WordPress admin.
 */
function bp3dviewer_readonly() {
  wp_register_style( 'bp3d-readonly', plugin_dir_url( __FILE__ ) . '../public/css/readonly.css', false, '1.0' );
  echo wp_enqueue_style( 'bp3d-readonly' );
}
add_action( 'admin_enqueue_scripts', 'bp3dviewer_readonly' );



function bp3dviewer_exclude_fields_before_save( $data ) {

  $exclude = array(
  'bp_model_anim_du',
  'bp_camera_control',
  'bp_3d_rotate',
  );
  
  foreach ( $exclude as $id ) {
  unset( $data[$id] );
  }
  
  return $data;
  
  }
  add_filter( 'csf_sc__save', 'bp3dviewer_exclude_fields_before_save', 10, 1 );