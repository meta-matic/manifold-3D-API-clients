<?php
/**
 * @package WP_Manifold
 * @version 1.6
 */
/*
Plugin Name: WP Manifold
Plugin URI: https://wordpress.org/plugins/wp-manifold/
Description: A plugin to interact with the Manifold 3D API.
Author: Pushkar Paranjpe
Version: 1.0
Author URI: http://manifold.metamatic.us/
Text Domain: wp-manifold
*/


function ManifoldShortcode() {
	$loading_img_src = plugins_url('css/images/loading@2x.gif', __FILE__ );

	return '<table border="1px">
			<tr>
			<td>
			<table width="100%"><tr><td width="50%"><h3>Upload</h3></td><td><img id="loader_upload" src="'. $loading_img_src .'" width="20px" height="20px"></td></tr></table>
			</td>
			<td>
			<table width="100%"><tr><td width="50%"><h3>Compute</h3></td><td><img id="loader_compute" src="'. $loading_img_src .'" width="20px" height="20px"></td></tr></table>
			</td>
			<td>
			<h3>Result</h3>
			</td>
			</tr>
			<tr>
			<td width="30%">
				<form id="uploadForm">
				<table>
				<tr><td>
				<input name="datafile" type="file" />
				</td>
				</tr>
				<tr><td>
				<input name="api_key" type="hidden" value="' . get_option('manifold_api_key') . '" />
				</td><td>
				<input type="submit" value="Submit" />
				</td></tr>
				</table>
				</form>
			</td>
			<td>
				<table width="100%">
				<tr>
				<td><label>Task ID:</label></td>
				<td width="60%"><span id="taskID"></span></td>
				</tr>
				</table>
			</td>
			<td width="40%">
				<span id="result">No result</span>
				<script id="entry-template" type="text/x-handlebars-template">
				  <div class="entry"><em>Volume:</em> {{ volume.value }} {{ volume.UOM }}</div>
				  <div class="entry"><em>Bounding box:</em> {{ bbox.value.length }}, {{ bbox.value.width }}, {{ bbox.value.height }}, {{ bbox.UOM }}</div>
				  <div class="entry"><em>Facets:</em> {{ facet_count.value }}</div>
				  <div class="entry"><em>Build time:</em> {{ time.value.min }} - {{ time.value.max }} {{ time.UOM }}</div>
				  <div class="entry"><em>Image:</em> <img src="{{ root_url }}{{ image.value }}"></div>
				</script>
				<div id="entry-rendered"></div>
			</td>
			</tr>
			</table>';
}
add_shortcode('manifold', 'ManifoldShortcode');


function Manifold_widget_enqueue_script() {   
    wp_enqueue_script( 'handlebars', plugin_dir_url( __FILE__ ) . 'js/handlebars-v4.0.5.js', array('jquery'), '1.0', true );
    wp_enqueue_script( 'script', plugin_dir_url( __FILE__ ) . 'js/script.js', array('jquery'), '1.0', true );
}
add_action('wp_enqueue_scripts', 'Manifold_widget_enqueue_script');


// Settings
function manifold_register_settings() {
   add_option( 'manifold_api_key', 'Enter API Key');
   register_setting( 'manifold_options_group', 'manifold_api_key', 'manifold_callback' );
}
add_action( 'admin_init', 'manifold_register_settings' );

function manifold_register_options_page() {
  add_options_page('Manifold Settings', 'Manifold 3D API', 'manage_options', 'manifold', 'manifold_options_page');
}
add_action('admin_menu', 'manifold_register_options_page');



// Settings

function manifold_options_page()

{

?>
		<div>
		<?php screen_icon(); ?>
		<h2>Manifold 3D API</h2>
		<form method="post" action="options.php">
		<?php settings_fields( 'manifold_options_group' ); ?>

		<h3>Settings</h3>
		<p>Set your API key.</p>
		<table>
		<tr valign="top">
		<th scope="row"><label for="manifold_api_key">API Key</label></th>
		<td><input type="text" id="manifold_api_key" name="manifold_api_key" value="<?php echo get_option('manifold_api_key'); ?>" /></td>
		</tr>
		</table>
		<?php  submit_button(); ?>
		</form>
		</div>
<?php
}
?>
