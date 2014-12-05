Coding standard
===============

We follow the [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md) Basic coding standard and [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) Coding Style Guide. On top of that we also apply the [Symfony Coding Standards](http://symfony.com/doc/current/contributing/code/standards.html).

We've listed some [tools](04-tools.md) to assist with this coding style.

## PHPDoc

Although the PSR is not yet accepted, we are using the [proposed standard](https://github.com/phpDocumentor/fig-standards/blob/master/proposed/phpdoc.md) for PHPDoc.

### Basic usage

If you look at the screenshot below, all boxes are checked (except the fully-qualified class one), that aligned `@param`'s, with empty lines around them, like so:

```php
/**
 * Method description
 *
 * @param string  $foo
 * @param boolean $bar
 *
 * @return integer
 */
```

The `{@inheritdoc}` tag is inline in the proposal. However it is discussed to just use a regular `@inheritdoc` tag, which some prefer. Until this seems to get a resolution, either way is accepted.


## Visibility

### Class properties

The preferred visibility for class properties is `protected`, and it should almost never by anything else, unless there's a valid reason for it.

#### To elaborate

We know that strictly speaking it's best practice to keep visibility as low as possible (thus `private` by default). But subclassing a class with private properties (when you specifically need to use the private properties) is far from ideal and often leads to duplication of large code blocks. In practice a developer needs to change the property visibility (sometimes in a different bundle/library) or duplicate code, possibly even the constructor to subclass this. Our experiences learn that this happens more frequently than a developer using the property wrong. We'd rather have this property a bit more exposed than this.

### Class methods

The convention for properties also largely applies for methods: `protected` by default, `private` only when you're absolutely sure it will not (or must not) be extended. Use `public` when you need the method outside of the class in your current issue, or if you think that is likely to happen later.

## Inject the ManagerRegistry instead of the EntityManager

See [this article](http://php-and-symfony.matthiasnoback.nl/2014/05/inject-the-manager-registry-instead-of-the-entity-manager/) (and the comments) for the reasons why.
