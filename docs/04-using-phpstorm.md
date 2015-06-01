Using PHPStorm
==============

We have collected some useful tips for working with PHPStorm on our projects


## PHP-CS-Fixer

To use PHP-CS-Fixer inside PHPStorm, simply follow the steps below:

1. Make sure PHP-CS-Fixer is installed **globally** (e.g. you are able to run it from the command line using
   `php-cs-fixer`)
2. Launch PHPStorm
3. Go to `Preferences` and then to `External tools` in the list of options on the left.
4. Click the little plus-icon on the bottom to add a new tool
5. Set the fields to be the same as seen in this screenshot: ![PHP-CS-Fixer in PHPStorm][cs-fixer]

[cs-fixer]: /assets/screenshots/php-cs-fixer-in-phpstorm.png


### Keyboard shortcut

To easily run PHP-CS-Fixer on a file you currently have open, you can add a keyboard-shortcut that runs the executable
using the steps below:

1. If you have the `Preferences` window open, close it now. This is important for the new external tool to be visible in
   the next steps.
2. Go to `Preferences` and then to `Keymap` in the list of options on the left.
3. Use the search field in the top-right corner and start typing `php-cs-fixer`, your screen should now look somewhat
   like this: ![Keyboard-shortcut for PHP-CS-Fixer][kbd-shortcut]
4. To assign a keyboard-shortcut, simply double-click on `php-cs-fixer` and click `Add keyboard shortcut`.

[kbd-shortcut]: /assets/screenshots/php-cs-fixer-keyboard-shortcut.png
