# Modular WordPress Plugin Boilerplate

Contributors: benhoverter
Tags: wordpress, plugins, boilerplate
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This is a revision of the WordPress Plugin Boilerplate, intended to improve separation of concerns.

This is the full project.  If you're looking for just the plugin code without the gulpfile, package.json, etc., you want:
https://github.com/benhoverter/modular-wordpress-plugin-boilerplate_PLUGIN

== Description ==

The WordPress Plugin Boilerplate project groups all public and admin functions into single classes, and offers very rudimentary
view/controller separation.  It also fails to take advantage of folder namespaces to reduce verbosity.  This is just an attempt to build it into something more cleanly and clearly divided while creating more modular extensibility.

This boilerplate keeps the admin/public division, but adds the WeDevs Settings API to separate admin functionality on posts and pages from the snarl of the WP Settings API.  Within each of the public and admin divisions there are "elements" intended to be copied, renamed, and built to provide one specific function.  Each element has its own .scss, .js, and view folders and files.  Standard elements and AJAX-based element templates are provided, along with placeholder action hooks.

Because each element has its own .scss and .js, this boilerplate assumes the use of a transpiler like Babel for translation, concatenation, and minification.  Transpilation should target the /dist folder and its /public and /admin children.  I haven't added separate /js and /css folders within those, as I feel the separation is already sufficient.  I have added a sample gulpfile.js in the project root to get you started.

I have ignored the WordPress naming convention for class files, instead opting for the short and clear convention of capitalized filenames for class files.  If you're devoted to the WordPress standard, do what ye will.
