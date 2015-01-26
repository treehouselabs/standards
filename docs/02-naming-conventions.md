Naming conventions
==================

## Commands

* Commands introduced by bundles *should be* prefixed with the (short) bundle name or alias.
* Further naming *should be* done using regular namespace conventions (from more generic to less generic).
* Try to group objects/entities in a namespace, but to limit the total to 3 parts.
* The command's class name is a CamelCased concatenation of the namespaces

For example a command that creates a user in the CmsBundle *should be* named `cms:user:create` and located in
`<CmsBundle>/Command/UserCreateCommand.php`.

## Bundles

External bundles (distributed via composer):
* Composer name: `treehouselabs/feature-bundle`
* GitHub repo name: `TreeHouseFeatureBundle`
* Namespace: `TreeHouse\FeatureBundle`
* Bundle name: `TreeHouseFeatureBundle`

Internal bundles (in `src` folder):
* Namespace: `TreeHouse\FeatureBundle`
* Bundle name: `TreeHouseFeatureBundle`

## Services

All services *must be* be prefixed with the vendor/bundle name, eg: `tree_house_search.foo`. The rest of the id *should*
follow the rest of the class' namespace, but this *may* vary. For example if a service is located at
`TreeHouse\CacheBundle\EventListener\EntityListener.php`, the id could be `tree_house_cache.listener.entity`.

## Doctrine

We use the underscore naming strategy for all our projects:

```yaml
# app/config/config.yml
doctrine:
  orm:
    naming_strategy: doctrine.orm.naming_strategy.underscore
```

### Date/time properties

All date/datetime properties *must be* prefixed with that type, for instance: `datetimeCreated` and `datetimeModified`.
This helps identifying the purpose of the property, since `modified` could also mean a boolean.

## Events, listeners and subscribers

As per Symfony2 conventions, event classes *must be* located and named as followed:

* Events class (defining various events via constants) in the bundle root
* Event classes in the `Event` folder
* Listeners and subscribers in the `EventListener` folder

Example:

```
Bundle
├── BundleEvents.php
├── Event
│   ├── BundleEvent.php
│   └── OtherEvent.php
└── EventListener
    ├── BundleListener.php
    └── OtherListener.php
```

### Subscribers
Subscribers are listeners implementing the [EventSubscriberInterface][1]. An example from Symfony:

```php
namespace Symfony\Component\HttpKernel\EventListener;

class LocaleListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // ...
    }
}
```

[1]: https://github.com/symfony/EventDispatcher/blob/master/EventSubscriberInterface.php