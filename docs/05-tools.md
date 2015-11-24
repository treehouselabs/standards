## Tools

Tools we use that help with code style.

### Editorconfig

See http://editorconfig.org

The [editorconfig](/.editorconfig) of this repository can be copied and used in your projects/IDE.


### PHP-CS-Fixer

To install PHP-CS-Fixer on Mac OS X:

```
brew install php-cs-fixer
```

For other platforms, follow the instructions in [their documentation](https://github.com/fabpot/PHP-CS-Fixer/blob/master/README.rst).

**Using PHP-CS-Fixer in PHPStorm:** We have created some instructions for easily integrating PHP-CS-Fixer into PHPStorm: [Using PHPStorm](04-using-phpstorm.md#php-cs-fixer)


### Conveyor

All of our Symfony projects are deployed using Conveyor. Here's how you deploy a project yourself:

1. Clone the Conveyor repository: 
  ```
  $ cd ~/git
  $ git clone https://github.com/webcreate/conveyor
  $ cd conveyor
  $ composer install
  ```
2. Navigate to your project directory:
  ```
  $ cd ~/git/huurwoningen
  ```
3. Execute the deploy command:
  ```
  $ ~/git/conveyor/bin/conveyor deploy symfony dev-master
  ```
  
  **NOTE:** `symfony` refers to the group of targets that needs to be deployed to. To find the correct group for your project, please read the `conveyor.yml` file distributed with your project.
  
**NOTE:** It may be necessary to first copy your SSH keys to the targeted servers before deploying. Find the respective SSH user and host in `conveyor.yml` and execute the following for each server (assuming you have the necessary passwords):
```
$ ssh-copy-id USER@HOST
```
