redmine
=======

[![Latest Stable Version](https://poser.pugx.org/se/redmine/v/unstable.png)](https://packagist.org/packages/se/redmine)

Access layer for for Redmine, written in PHP.

#### Dev branch is master branch.

[![Build Status](https://travis-ci.org/sveneisenschmidt/redmine.png?branch=master)](https://travis-ci.org/sveneisenschmidt/redmine)

### Installation

The recommended way to install is through [Composer](http://getcomposer.org).

```yaml
{
    "require": {
        "se/redmine": "dev-master"
    }
}
```

### Usage

##### Pick a Client
``` php
<?php

use SE\Component\Redmine\Client\RestClient();

$client = new RestClient('www.example.org/redmine', 'apiKey=c42ahcfg');

// Or coming soon
use SE\Component\Redmine\Client\DbClient();

$client = new DbClient('www.example.org:3306', 'redmine_v21', 'user', 'pass');

```

##### Unified API for all Clients
``` php
<?php

$repository = $client->getRepository('issues');

// Find all by criteria
$issues = $repository->findAll(array('status_id' => 'closed')); // [SE\Component\Redmine\Entity\Collection\Issues](https://github.com/sveneisenschmidt/redmine/blob/master/src/SE/Component/Redmine/Entity/Collection/Issues.php)



// Find one by id & persist changes
$issue = $repository->find(2); // find by id
$issue->setSubject('New Title');
$repository->persist($issue);

// Create new Issue
use SE\Component\Redmine\Entity\Issue;

$issue = new Issue();
$issue->setSubject('My First Issue');

$repository->persist($issue);

print $issue->getId(); // returns Id of newly create Issue, similar to Doctrine


```
#### Implemented Entities

* [Issues] (https://github.com/sveneisenschmidt/redmine/blob/master/src/SE/Component/Redmine/Entity/Issue.php)
* [News] (https://github.com/sveneisenschmidt/redmine/blob/master/src/SE/Component/Redmine/Entity/News.php)

### Running Tests

```bash
vendor/bin/phpunit -c phpunit.xml.dist
```

Run a set of tests against a running redmine via editing constants in [test/config.dist.php](https://github.com/sveneisenschmidt/redmine/blob/master/src/tests/config.dist.php) and calling
phpunit with --group=live.

```bash
vendor/bin/phpunit -c phpunit.xml.dist --group=live

```

