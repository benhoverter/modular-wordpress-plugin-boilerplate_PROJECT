== Guidelines ==

This directory should include:
  - plugin-name.min.css
  - plugin-name.min.js
  - plugin-name.min.js.map

You should add *.min.* to your .gitignore file, as these are not working files.

These files are enqueued in /includes/Main.php.
If they are not present, WordPress will throw an error.
