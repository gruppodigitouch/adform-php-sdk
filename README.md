# AdForm SDK for PHP

[![Build Status](https://travis-ci.org/theblogtvspa/adform-php-sdk.svg?branch=master)](https://travis-ci.org/theblogtvspa/adform-php-sdk)
[![Latest Stable Version](https://poser.pugx.org/digitouch/adform-php-sdk/v/stable)](https://packagist.org/packages/digitouch/adform-php-sdk)

The **AdForm SDK for PHP** to access [AdForm's API](http://api.adform.com/help/)

### Installation
```
$ composer require digitouch/adform-php-sdk
```

### Usage
```
$api = new ApiFactory(new HttpClient);
$ticket = $api->auth('<username>', '<password>');
$result = $api->call(ApiFactory::ADVERTISERS, $ticket, ['Names' => '<name-filter>']);
```

### Examples
Same code examples are located in the "examples" dir.
Find and rename config.php.dist to config.php and edit with your AdForm credentials.
Finally run with:
```
$ php examples/advertisers.php
```


### Endpoints
Currently implemented Endpoints:
* [Authentication](http://api.adform.com/help/references/buyer-solutions/account/authentication/login)
* [Advertisers](http://api.adform.com/help/references/buyer-solutions/advertiser/management/get-advertisers)
* [Campaigns](http://api.adform.com/help/references/buyer-solutions/campaign)
* [Users](http://api.adform.com/help/references/buyer-solutions/account/users/get-users)
* [Reporting Stats](http://api.adform.com/help/references/buyer-solutions/reporting/stats)
* [Data Export](http://api.adform.com/help/references/buyer-solutions/reporting/data-exports)

### Run Tests
Use [Composer] to download dependencies:
```
$ composer install
```

Then run:
```
$ ./vendor/bin/phpunit
```