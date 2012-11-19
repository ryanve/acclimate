<?php
/** 
 * Acclimate    An adapter for writing WordPress plugins/frameworks that can load
 *              from the plugins dir, the mu-plugins dir, or a parent theme dir.
 *
 * @author      Ryan Van Etten (c) 2012
 * @link        github.com/ryanve/acclimate
 * @license     MIT
 * @version     1.1.2
 *
 * @example     $paths = acclimate(__FILE__); # called from myplugin.php
 *              $myplugin_dir = $paths->dir;  # dir path for the directory that myplugin.php is in
 *              $myplugin_uri = $paths->uri;  # URI path for the directory that myplugin.php is in
 *              $paths->load_relative_textdomain('lang');  # normalized textdomain loader
 */

# prevent errors if acclimate.php is loaded multiple times, but let
# "cannot redeclare" errors happen if it looks like a name conflict:
if ( !function_exists('acclimate') || !class_exists('Acclimate')) { #wrap

    /**
     * Global function for instantiating the Acclimate class.
     * @param     string      $file    is the file location to base acclimation on.
     * @return    object               is an Acclimate instance.
     */
    function acclimate( $file = null )
    {
        if ( is_string($file) || null === $file )
            return new Acclimate( $file );
        
        if ( $file instanceof Acclimate )
            return $file;

        trigger_error(__FUNCTION__ . ' parameter 1 expects string.', E_USER_ERROR);
    }

    class Acclimate 
    {
        function __construct( $file = null )
        {
            if ( null === $file )
                return $this;

            // Determine the location that $file has been loaded from:

            $location = dirname($file) . '/';           // full path for directory that $file is in
            $basename = basename(dirname($file)) . '/'; // name of directory that $file is in
            
            // It should match one of these:
            
            $case_parent_theme = path_join(get_template_directory(), $basename); #wp
            $case_plugins      = path_join(WP_PLUGIN_DIR, $basename);            #wp
            $case_mu_plugins   = is_dir(WPMU_PLUGIN_DIR) ? path_join(WPMU_PLUGIN_DIR, $basename) : 0;
            
            // Determine location and add boolean props:

            $this->in_parent_theme = $location === $case_parent_theme;
            $this->in_plugins = $location === $case_plugins;
            $this->in_mu_plugins = $location === $case_mu_plugins;
            
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

            // Join the URI parts:
            
            $uri = trailingslashit($uri) . ltrim($basename, '/'); #wp
            
            // Set object props:

            $this->dir = $dir;             // includes trailing slash
            $this->uri = $uri;             // includes trailing slash
            $this->textdomain = $basename; // default (reset if needed)

            return $this; // instance
        }

        /**
         * load_relative_textdomain()      Normalized textdomain loading based on $file location.
         *
         * @param   string    $path        is the **relative** path
         */

        function load_relative_textdomain( $path = '' )
        {
            empty($path) or $path = trim($path, '/') . '/';

            if ( $this->in_plugins )
            {
                $path = dirname($this->dir) . $path; // build full path
                return load_plugin_textdomain($this->textdomain, false, $path); #wp
            }

            if ( $this->in_parent_theme )
            {
                $path = trailingslashit(get_template_directory()) . $path; #wp
                return load_theme_textdomain( $this->textdomain, $path );      #wp
            }

            $path = dirname($this->dir) . $path; // build full path
            return load_muplugin_textdomain($this->textdomain, $path);  #wp
        }

    }#class
}#wrap

// End of file.