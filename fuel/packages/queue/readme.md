# Introduction
fuel-queue is a simple queue system for FuelPHP is based on Resque-php but adapted to fuelphp Oil module.
Currently is unstable but works.

# Features
* Driver based, it currently supports redis and fuel db, more drivers coming soon...
* Simple usage, easy to integrate in your project.
* Lightweight

# Installation
Make a new file in fuel/app/tasks with the name queue.php on your application with the follow code:

```php
<?php
include_once PKGPATH . 'queue/tasks/queue.php';
```

now try on the command line:
	```
	php oil refine queue
	```

# Usage
DB Driver:
The database table scheme:

```sql
CREATE TABLE `queue` (
  `id` bigint(22) NOT NULL AUTO_INCREMENT,
  `queue` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `priority` int(1) NOT NULL DEFAULT '5',
  `payload` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

Redis: use defaults configurations from fuel/app/db.php redis configure it there.

Running workers for queues:
use Oil utility for process queues

```
php oil refine queue <queue_name>
```


