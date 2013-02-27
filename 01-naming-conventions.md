Naming conventions
==================

## Commands

* Commands introduced by bundles should be prefixed with the (short) bundle name or alias. 
* Further naming should be done using regular namespace conventions (from more generic to less generic). 
* Try to group objects/entities in a namespace, but to limit the total to 3 parts.
* The command's class name is a CamelCased concatenation of the namespaces

For example a command that creates a user in the CmsBundle should be named `cms:user:create` and located in `<CmsBundle>/Command/UserCreateCommand.php`.

## Bundles

* Composer name: `fm/feature-bundle`
* GitHub repo name: `FeatureBundle`
* Namespace binnen Symfony: `FM\FeatureBundle`
* Bundle naam binnen Symfony: `FMFeatureBundle`

