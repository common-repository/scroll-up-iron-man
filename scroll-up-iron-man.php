<?php
/*
	Plugin Name: Scroll Up Iron Man
	Description: Animated scroll up button in the form of an Marvel Iron Man.
	Version: 1.0
	Author: Somonator
	Author URI: mailto:somonator@gmail.com
*/

/*  
	Copyright 2016  Alexsandr  (email: somonator@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class IR_Scroll_Up {
	function __construct() {
		add_action('wp_footer', array($this, 'init_html'));
		add_action('wp_enqueue_scripts', array($this, 'add_scripts'));
		add_action('admin_menu', array($this, 'admin_page'));
		add_action('admin_init', array($this, 'plugin_settings'));
		add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_settind_url'));
	}
	
	function init_html() {
		$class = get_option('irsu_sprite') ? : 'up';
		
		$html = '<div class="IR-Scroll-Up irsu-' . $class . '" style="display: none;">';
		$html .= '<div class="sptite-animate irsu-' . $class . '"></div>';
		$html .= '<div class="scroll-button"></div>';
		$html .= '</div>';
		
		echo $html;
	}
	
	function add_scripts() {
		wp_enqueue_style('irsu-styles', plugin_dir_url(__FILE__) . 'add/irsu-styles.css');
		wp_enqueue_script('irsu-scripts', plugin_dir_url(__FILE__) . 'add/irsu-scripts.js', array('jquery'));
	}
	
	function admin_page() {
		add_options_page('IM Scroll Up', 'Iron Man Scroll Up', 'manage_options', 'irsu', array($this, 'options_page_html'));
	}
	
	function options_page_html() {
		echo '<div class="wrap">';
		echo '<h2>Iron Man Scroll Up</h2>';
		echo '<form action="options.php" method="POST">';
		settings_fields('irsu');
		do_settings_sections('irsu');
		submit_button();
		echo '</form>';
		echo '</div>';	
	}
	
	function plugin_settings() {
		register_setting('irsu', 'irsu_sprite', array($this, 'sanitize_callback'));
		add_settings_section('irsu', 'Button options', '', 'irsu'); 
		add_settings_field('primer_field1', 'Button Skin', array($this, 'select'), 'irsu', 'irsu');
	}
	
	function select() {
		$val = get_option('irsu_sprite');
		
		echo '<select name="irsu_sprite">';
		echo '<optgroup label="Iron Man">';
		echo '<option value="up" ' . selected($val, 'up', 1) . '>MCU Mark XL «Shotgun»</option>';
		echo '<option value="up2" ' . selected($val, 'up2', 1) . '>Comics Iron Man from Live of Captain Marvel Vol. 2</option>';
		echo '</optgroup>';
		echo '<optgroup label="Other">';
		echo '<option value="up3" ' . selected($val, 'up3', 1) . '>Blue rocket</option>';
		echo '</optgroup>';
		echo '</select>';
	}
	
	function sanitize_callback($options){ 
		return $options;
	}
	
	function add_settind_url($links) {
		$links[] = '<a href="' . admin_url('options-general.php?page=irsu') . '">' . 'Settings</a>';
		
		return $links;
	}
}

new IR_Scroll_Up();
?>