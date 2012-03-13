[Acclimate](https://github.com/ryanve/acclimate) is a simple adapter for writing WordPress plugins/frameworks that can load from the plugins dir, the [mu-plugins](http://codex.wordpress.org/Must_Use_Plugins) dir, or a parent theme dir. It normalizes directory paths and textdomain loading. Use Acclimate when you want the flexibility to be able to ship a theme that relies on a custom plugin or framework without the need to for users of the theme to install the dependencies as plugins **and** at the same time you still want to be able to give advanced devs the ability to write themes based on the dependencies as plugins and not have to worry about including those files repeatedly in all their themes. This makes maintainability much easier because devs can simply maintain the plugin rather than having to update each theme every time there's an update to a dependency.

## Usage

In your main plugin file (e.g. myplugin.php) instantiate the class like this:

```php

$paths = new Acclimate(__FILE__);
```

This returns an object with the following properties:

```php

$paths->dir        # dir path for the directory that myplugin.php is in
$paths->uri        # URI path for the directory that myplugin.php is in
$paths->texdomain  # defaults to the string 'myplugin'
```

You can use the properties to define constants or static vars for your paths:

```php

define('MYPLUGIN_DIR', $paths->dir);           # includes trailing slash
define('MYPLUGIN_URI', $paths->uri);           # includes trailing slash
define('MYPLUGIN_PHP', $paths->dir . 'php/');  # path to php subfolder
define('MYPLUGIN_CSS', $paths->uri . 'css/');  # URI for css subfolder
```

The object also has a normalized textdomain loading method. Depending on the location it uses either [load_plugin_textdomain()](http://codex.wordpress.org/Function_Reference/load_plugin_textdomain), [load_muplugin_textdomain()](http://codex.wordpress.org/WPMU_Functions/load_muplugin_textdomain), or [load_theme_textdomain()](http://codex.wordpress.org/Function_Reference/load_theme_textdomain). Its parameter is the relative path to your translations folder from the myplugin dir. If your translations files are in folder called 'languages' then you can load them like this:

```php

$paths->load_relative_textdomain('languages');
```

## License

### [Acclimate](https://github.com/ryanve/acclimate) is available under the [MIT license](http://en.wikipedia.org/wiki/MIT_License)

Copyright (C) 2012 by [Ryan Van Etten](https://github.com/ryanve)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.