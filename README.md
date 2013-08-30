redmine
=======

Access layer for for Redmine, written in PHP.

#### Available Clients
* REST Api
* Database

#### Dev branch is master branch.

[![Build Status](https://travis-ci.org/sveneisenschmidt/redmine.png?branch=master)](https://travis-ci.org/sveneisenschmidt/redmine)


### Installing via Composer

The recommended way to install is through [Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php

# Add Redmine as a dependency
php composer.phar require se/redmine:dev-master
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```
