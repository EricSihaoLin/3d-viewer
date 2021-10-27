<?php

//Lets register our shortcode
function bp3dviewer_cpt_content_func( $atts ){
	extract( shortcode_atts( array(
		'id' => '',
	), $atts ) ); ob_start(); ?>	
 
<?php 

// Options Data
$modeview_3d = get_post_meta( $id, '_bp3dimages_', true );

if( isset($modeview_3d) && is_array($modeview_3d) ) :

$model_src  = null;
$model_poster  = null;
$model_width = null;
$model_height = null;

if( is_array($modeview_3d['bp_3d_src']) && !empty($modeview_3d['bp_3d_src']['url'] )){
    $model_src  = $modeview_3d['bp_3d_src']['url'] ?? 'i-do-not-exist.glb';
}
if( is_array($modeview_3d['bp_3d_width']) && !empty($modeview_3d['bp_3d_width']['width'] )){
    $model_width = $modeview_3d['bp_3d_width']['width'].$modeview_3d['bp_3d_width']['unit'];
}
if( is_array($modeview_3d['bp_3d_height']) && !empty($modeview_3d['bp_3d_height']['height'] )){
    $model_height = $modeview_3d['bp_3d_height']['height'].$modeview_3d['bp_3d_height']['unit'];
}
$poster_image   = isset($modeview_3d['bp_3d_poster']['url']) ? $modeview_3d['bp_3d_poster']['url']: '';

$camera_control = $modeview_3d['bp_camera_control'] == 1 ? 'camera-controls' : '';
$alt            = !empty($modeview_3d['bp_3d_src']['url']) ? $modeview_3d['bp_3d_src']['title'] : '';
$auto_rotate    = $modeview_3d['bp_3d_rotate'] == 1 ? 'auto-rotate' : '';
$zooming_3d     = $modeview_3d['bp_3d_zooming'] == 1 ? '' : 'disable-zoom';
$loading_type   = isset ($modeview_3d['bp_3d_loading']) ? $modeview_3d['bp_3d_loading'] : '';
// Preload
$model_preload = $modeview_3d['bp_3d_preloader'] === '1' ? 'reveal=interaction' : '';
?>


<!-- 3D Model html -->
<model-viewer class="model" <?php echo esc_attr($model_preload); ?> poster="<?php echo esc_url($poster_image); ?>" src="<?php echo esc_url($model_src); ?>" alt="<?php echo esc_attr($alt); ?>" <?php echo esc_attr($camera_control); ?> <?php echo esc_attr($zooming_3d); ?> loading="<?php  echo esc_attr($loading_type); ?>" <?php echo esc_attr($auto_rotate); ?> >


</model-viewer>


<!-- Model Viewer Style -->
<style>
.model {
    width:<?php echo esc_attr($model_width); ?>;
    height:<?php echo esc_attr($model_height); ?>;
}
model-viewer.model {
    --poster-color: transparent;
}
</style>
<?php endif; ?>

<?php  
// Scripts
echo wp_get_script_tag(
    array(
        'src'  =>BP3D_VIEWER_PLUGIN_DIR.'public/js/model-viewer.min.js',
        'type' => 'module',
    )
); 

$output = ob_get_clean(); return $output; 
}
add_shortcode('3d_viewer','bp3dviewer_cpt_content_func');