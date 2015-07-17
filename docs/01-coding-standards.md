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

The preferred visibility for class properties is `protected`, and it should almost never be anything else, unless
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

## Inheritance in docblocks

Where possible, add a docblock with the `@inherit` tag to any overriding method in a subclass (or methods that are interface implementations). **Do not** use the inline `{@inheritdoc}` tag, as that is used to include the parent method description, not the whole parent docblock. Also, lowercase the whole tag, no `@inheritDoc`:

```php
/*
 * @inheritdoc
 */
```

In some cases it can be helpful to extend a part of the parent's docblock. For instance when you are using a more specific class name as an argument. In this case you can add that below the `@inherit` tag:

```php
interface A 
{
    /**
     * @param A $a
     */
    public function foo(A $a);
}

class B implements A
{
    /**
     * @inheritdoc
     *
     * @param B $a
     */
    public function foo(A $a) {}
}
```

For the why on this, here are the arguments from Mike van Riel (the PhpDoc guy), with whom we agree:

> * Reduces time to consider: because there is a DocBlock you never have to wonder if it was omitted on purpose or that it was accidentally forgotten during code reviews or boy scouting
> * Increases ease of skimming a code base: if you consistently use DocBlocks with all your elements then your eyes will get used to the pattern of having a DocBlock with every element and this increases the speed with which you can find and determine structural elements in your code.
> * When someone reads your source code it will be immediately clear that they are dealing with an inherited element; helping them to navigate your codebase.

## Various

* For improved readability, use `sprintf` to format variables in a string, instead of concatenating
* Always import classes with `use` statements. This results in shorter, more readable code and makes refactoring easier, as all external classes are grouped together
* Where possible, always use trailing commas (PHP arrays, annotations, etc.). [This](https://twitter.com/umpirsky/status/611799916206276608) is one reason, easily copy/pasting a new row is another
