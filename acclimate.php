<?php
/** 
 * Acclimate    An adapter for writing WordPress plugins/frameworks that can load
 *              from the plugins dir, the mu-plugins dir, or a parent theme dir.
 *
 * @author      Ryan Van Etten (c) 2012
 * @link        github.com/ryanve/acclimate
 * @license     MIT
 * @version     1.0.0
 *
 * @example     $paths = new Acclimate(__FILE__);  # called from myplugin.php
 *              $myplugin_dir = $paths->dir;  # dir path for the directory that myplugin.php is in
 *              $myplugin_uri = $paths->uri;  # URI path for the directory that myplugin.php is in
 *              $paths->load_relative_textdomain('lang');  # normalized textdomain loader
 */

if ( !class_exists('Acclimate')) {
class Acclimate
{
  
	function __construct( $file )
	{
		// Determine the location that $file has been loaded from:
		
		$location = dirname($file) . '/';           // full path for directory that $file is in
		$basename = basename(dirname($file)) . '/'; // name of directory that $file is in
		
		// It should match one of these:
		
		$case_parent_theme = path_join(get_template_directory(), $basename); #wp
		$case_plugins      = path_join(WP_PLUGIN_DIR, $basename);                    #wp
		$case_mu_plugins   = is_dir(WPMU_PLUGIN_DIR) ? path_join(WPMU_PLUGIN_DIR, $basename) : 0;
		
		// Run check to determine which one:
		
		$this->in_parent_theme = (bool) ($case_parent_theme === $location);
		$this->in_plugins = (bool) ($case_plugins === $location);
		$this->in_mu_plugins = (bool) ($case_mu_plugins === $location);
		
		// Then define uri/dir props accordingly:
		
		if ( $this->in_parent_theme )
		{
			$dir = $case_parent_theme;
			$uri = get_template_directory_uri(); #wp // base only at this step
		}
		
		elseif ( $this->in_plugins )
		{
			$dir = $case_plugins;                    // plugin_dir_path(__FILE__)
			$uri = plugins_url();                #wp // base only at this step
		}
		
		elseif ( $this->in_mu_plugins )
		{
			$dir = $case_mu_plugins;
			$uri = WPMU_PLUGIN_URL;              #wp // base only at this step
		}
		
		else 
		{
			trigger_error('class ' . get_class($this) . ' instantiated from invalid location.', E_USER_ERROR);
		}

		// Complete the URI (using the same technique as R5::uri_join, but it didn't seem worth inheriting R5
		// for 1 use of 1 method, and this way this class can easily be dropped into another project:
		
		$uri = rtrim($uri, '/') . '/' . ltrim($basename, '/');
		
		// Define props
		
		$this->dir = $dir;             // includes trailing slash
		$this->uri = $uri;             // includes trailing slash
		$this->textdomain = $basename; // default (reset if needed)
		
		return $this; // object instance
	}

	/**
	 * load_relative_textdomain()      Normalized textdomain loading based on $file location.
	 * 
	 * 
	 */
	 
	function load_relative_textdomain( $rel_path = '' )
	{
		empty($rel_path) or $rel_path = trim($rel_path, '/') . '/';
		
		if ( $this->in_plugins )
		{
			return load_plugin_textdomain($this->textdomain, false, dirname($this->dir) . $rel_path); #wp
		}
		
		if ( $this->in_parent_theme )
		{
			return load_theme_textdomain($this->textdomain, trailingslashit(get_template_directory()) . $rel_path); #wp
		}
		
		return load_muplugin_textdomain($this->textdomain, dirname($this->dir) . $rel_path);  #wp
	}
	
}//class
}//if

// End of file.