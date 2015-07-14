Coding standard
===============

We follow the [PSR-1][1] Basic coding standard and [PSR-2][2] Coding Style Guide. On top of that we also apply the
[Symfony Coding Standards][3].

We've listed some [tools][4] to assist with this coding style.

[1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[3]: http://symfony.com/doc/current/contributing/code/standards.html
[4]: 05-tools.md

## Visibility

### Class properties

The preferred visibility for class properties is `protected`, and it should almost never by anything else, unless
there's a clear and valid reason for it.

#### To elaborate

We know that strictly speaking it's best practice to keep visibility as low as possible (thus `private` by default). But
subclassing a class with private properties (when you specifically need to use the private properties) is far from ideal
and often leads to duplication of large code blocks. In practice a developer needs to change the property visibility
(sometimes in a different bundle/library) or duplicate code, possibly even the constructor to subclass this. Our
experiences learn that this happens more frequently than a developer using the property wrong. We'd rather have this
property a bit more exposed than this.

### Class methods

The convention for properties also largely applies for methods: `protected` by default, `private` only when you're
absolutely sure it will not (or must not) be extended. Use `public` when you need the method outside of the class in
your current issue, or if you think that is likely to happen later.

## Inject the ManagerRegistry instead of the EntityManager

See [this article][5] (and the comments) for the reasons why.

[5]: http://php-and-symfony.matthiasnoback.nl/2014/05/inject-the-manager-registry-instead-of-the-entity-manager/

## Doctrine entities
* fields must be `protected`
* mapping via annotations
* no `name` attribute in mapping (use the naming strategy)
* no `length` attribute for strings if it's the default (255)
* typehint as much as possible, eg `\DateTime` is not typehinted when you generate getters/setters

### Getters, setters, issers, etc
* setters before getters
* no meaningless "set field" comments
* use issers for booleans
* setters must be chainable (doc with `@return $this` for extensibility)
* collections must have a getter, adder and remover. No more, no less.
 
Example:

```php
/**
 * @param string $email
 *
 * @return $this
 */
public function setEmail($email)
{
    $this->email = $email;

    return $this;
}

/**
 * @return string
 */
public function getEmail()
{
    return $this->email;
}
```

## Various

* For improved readability, use `sprintf` to format variables in a string, instead of concatenating
