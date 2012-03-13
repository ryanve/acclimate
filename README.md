[Acclimate](https://github.com/ryanve/acclimate) is a simple adapter for writing WordPress plugins/frameworks that can load from the plugins dir, the mu-plugins dir, or a parent theme dir. This is useful when you want the ability to ship a theme that relies on a custom plugin or framework without the need to for users of the theme to install the dependencies as plugins. At the same time it gives advanced devs the ability to write themes based on the dependencies as plugins and not have to worry about including those files repeatedly in all their themes, making maintainability much easier as devs can simply maintain the plugin rather than having to update each theme every time there's an update to a dependency.

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