# Using code standards in TreeHouse projects

This repository provides documentation and tools to help comply with our code 
standards.


## Code standards

We mostly adhere to the [Symfony code style][symfony-cs], but each project can 
define its own rules. What's more important than specific rules, is that 
everyone applies them, consistently. That's what this repository aims to help 
with.

[symfony-cs]: http://symfony.com/doc/current/contributing/code/standards.html


## Installation

To install in a project, add this as a dev dependency:

```bash
composer require --dev treehouselabs/standards
```

### Configuration

Copy the distributed `.php_cs` file, modify where needed:

```bash
cp vendor/treehouselabs/standards/.php_cs .
```

**NOTE**: Make sure that `.php_cs.cache` is in `.gitignore`!

```bash
vendor/
.php_cs.cache
composer.lock
```

### Travis

When the fixer is run as a Travis script, builds fail when there is a CS 
violation. Add this to `.travis.yml`:

```bash
script:
  - bin/php-cs-fixer fix --config=.php_cs --verbose --diff --dry-run
```

For increased performance, make sure to cache the fixer's cache dir:

```bash
cache:
  directories:
    - $HOME/.php-cs-fixer
```


## Usage

There are multiple ways to integrate CS in your workflow. Here are some methods
that we use:

### Just write it yourself :smile:

Not the easiest way, but if it suits you, adopt the code style, and write it 
that way. No fixes needed!

### Apply manually

At any time before committing, run the fixer manually:

```bash
./bin/php-cs-fixer fix -v
```

This can also be done using a [plugin][plugins] for your editor of choice.

### Using a git commit hook

The repository ships with a git pre-commit hook that automatically fixes your 
code before committing it. Be careful however since this can modify code 
without you seeing it.

```bash
cp vendor/treehouselabs/standards/hooks/pre-commit .git/pre-commit
chmod +x .git/pre-commit
```
 
Of course if you prefer a different method, that's cool. Whatever works. Again,
the important thing is that it's applied consistently.

[plugins]: http://cs.sensiolabs.org/#helpers