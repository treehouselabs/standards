Using PHPStorm
==============

We have collected some useful tips for working with PHPStorm on our projects.


## Using the proper Code Style settings

PHPStorm allows you to define some advanced formatting options for several languages,
and then apply them with a single hotkey to the file you are currently editing.
These options can be changed, saved and then exported for use by others.
To keep a consistent codestyle in our projects, you are advised to use the style shown below:

1. Copy the file from [here](/assets/codestyles/TreeHouse.xml) and save it under ``~/Library/Preferences/WebIde80/codestyles/TreeHouse.xml``
2. Open PHPStorm's preferences.
3. Navigate to ``Code Style > PHP``.
4. Select ``TreeHouse`` from the styles in the dropdown at the top.
5. Click OK at the bottom to confirm the change.
6. You can now press Cmd+Alt+L (MacOS) or Ctrl+Alt+L (Windows/Linux), or any other combination you added under ``Keymap`` preferences, to apply the style to the current file.


## Using PHP-CS-Fixer

[PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) is another tool to apply proper standards to your code.
Fortunately, it works together with the code style mentioned above.
To use PHP-CS-Fixer inside PHPStorm, simply follow the steps below:

1. Make sure PHP-CS-Fixer is installed as either a (require-dev) dependency in your project, or **globally** (e.g. you are able to run it from the command line using ``php-cs-fixer``).
2. Launch PHPStorm
3. Go to ``Preferences`` and then to ``External tools`` in the list of options on the left.
4. Click the little plus-icon on the bottom to add a new tool
5. Set the fields to be the same as seen in this screenshot (take not of the "Program" field, this depends on the location you installed PHP-CS-Fixer in, see step 1): ![screenshot 2017-03-07 17 12 03](https://cloud.githubusercontent.com/assets/1062751/23665599/382ff3d2-0359-11e7-83b4-2269d3f7c457.png)


### Keyboard shortcut

To easily run PHP-CS-Fixer on a file you currently have open, you can add a keyboard-shortcut that runs the executable using the steps below:

1. If you have the ``Preferences`` window open, close it now. This is important for the new external tool to be visible in the next steps.
2. Go to ``Preferences`` and then to ``Keymap`` in the list of options on the left.
3. Use the search field in the top-right corner and start typing ``php-cs-fixer``, your screen should now look somewhat like this: ![Keyboard-shortcut for PHP-CS-Fixer](/assets/screenshots/php-cs-fixer-keyboard-shortcut.png)
4. To assign a keyboard-shortcut, simply double-click on ``php-cs-fixer`` and click ``Add keyboard shortcut``.


### Knowing you fixed something...

When PHP-CS-Fixer actually changed something, you will see a notifcation at the bottom of the PHPStorm window with
the text ``External tool 'php-cs-fixer' completed with exit code 1``. The exit code will be 0 if there was no change.
