== Guidelines ==

This directory should include:
  - admin/admin.min.css
  - admin/admin.min.js
  - admin/admin.min.js.map

  - public/public.min.css
  - public/public.min.js
  - public/public.min.js.map

You should add *.min.* to your .gitignore file, as these are not working files.

These files are enqueued in /public/Public.php and /admin/Admin.php, respectively.
Those enqueueing functions are hooked in /includes/Main.php to prevent admin scripts
and styles from loading on the public side, and vice-versa.
If these files or directories are not present, WordPress will throw an error.
