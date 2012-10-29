<?php
/*
Plugin Name: Mankutimmana Kagga
Plugin URI: http://www.prasannasp.net/wordpress-plugins/mankutimmana-kagga/
Description: This plugin creates a widget which shows a random poem from Mankutimmana Kagga, written by Sri D.V.Gundappa. You can add this widget to any widgetized areas, such as sidebars.
Author: Prasanna SP
Version: 1.1
Author URI: http://www.prasannasp.net/
*/

/*  This file is part of Mankutimmana Kagga plugin, developed by Prasanna SP (email: prasanna@prasannasp.net)

    Mankutimmana Kagga is written by Dr. D.V.Gundappa. Most of the poems used in this plugin are taken from http://wordsofwisdom.in/mankutimmanakagga/

    Mankutimmana Kagga is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Mankutimmana Kagga is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Mankutimmana Kagga plugin. If not, see <http://www.gnu.org/licenses/>.
*/

function dvg_kaggas() {
	$kaggafile = plugins_url( 'kagga.txt' , __FILE__ );
	$lines = file("$kaggafile"); 

	// Randomly choose a kagga
	return wptexturize( $lines[ mt_rand( 0, count( $lines ) - 1 ) ] );
}

function show_kagga() {
	$kagga = dvg_kaggas();
	
	echo "<p id='kagga' class='kagga'>$kagga</p>";
}


class Mankutimmana_Kagga_Widget extends WP_Widget {
			
	function __construct() {
    	$widget_ops = array(
			'classname'   => 'mankutimmana_kagga_widget', 
			'description' => __('Show a random Kagga from D.V.G\'s Mankutimmana Kagga. ಮಾನ್ಯ ಡಿ.ವಿ.ಗುಂಡಪ್ಪನವರ ಮಂಕುತಿಮ್ಮನ ಕಗ್ಗದಿಂದ ಯಾವುದಾದರೊಂದು ಕಗ್ಗವನ್ನು ತೋರಿಸಿ.')
		);
    	parent::__construct('manku-timmana-kagga', __('Mankutimmana Kagga'), $widget_ops);
	}
	
	function widget($args, $instance) {
           
			extract( $args );
		
			$title = apply_filters( 'widget_title', empty($instance['title']) ? 'ಮಂಕುತಿಮ್ಮನ ಕಗ್ಗ' : $instance['title'], $instance, $this->id_base);	
			
			
			echo $before_widget;
			
			
			// Widget title
			
			echo $before_title;
			
			echo $instance["title"];
			
			echo $after_title;
			
			
			// Call show_kagga function
			
    			show_kagga();

		echo $after_widget;

	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
	     
        		return $instance;
	}
	
	
	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : 'ಮಂಕುತಿಮ್ಮನ ಕಗ್ಗ';
		
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
             
<?php
	}
}

function mtk_register_widgets() {
	register_widget( 'Mankutimmana_Kagga_Widget' );
}

add_action( 'widgets_init', 'mtk_register_widgets' );

// Donate link on manage plugin page
function mtk_pluginspage_links( $links, $file ) {

$plugin = plugin_basename(__FILE__);

// create links
if ( $file == $plugin ) {
return array_merge(
$links,
array( '<a href="http://www.prasannasp.net/donate/" target="_blank" title="Donate for this plugin via PayPal">Donate</a>',
'<a href="http://www.prasannasp.net/wordpress-plugins/" target="_blank" title="View more plugins from the developer">More Plugins</a>',
'<a href="http://twitter.com/prasannasp" target="_blank" title="Follow me on twitter!">twitter!</a>'
 )
);
			}
return $links;

	}
add_filter( 'plugin_row_meta', 'mtk_pluginspage_links', 10, 2 );
?>
