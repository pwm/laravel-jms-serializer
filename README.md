# laravel-jms-serializer

A Laravel 5 package for https://github.com/schmittjoh/serializer

## 1. Installation

No composer package at the moment. To get it directly from github edit your composer.json:

```
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/pwm/laravel-jms-serializer"
    }
],
"require": {
    "pwm/laravel-jms-serializer": "dev-master"
},
```

Run `composer update`

Add the following to the `providers` array in `config/app.php`:
```
Pwm\LaravelJMSSerializer\LaravelJMSSerializerProvider::class,
```

Add the following to the `aliases` array in `config/app.php`:
```
'Serializer' => Pwm\LaravelJMSSerializer\LaravelJMSSerializerFacade::class,
```

## 2. Usage

Apologies for brevity.

```php
class Foo {
    /** @JSA\Type("integer") */
    protected $id;
    public function __construct($id) { $this->id = $id; }
}
```

```php
$o = new Foo("1");

return response(\Serializer::serialize($o,'json'))
    ->header('Content-Type', 'application/json');
    
return response(\Serializer::serialize($o,'xml'))
->header('Content-Type', 'text/xml');
```          

## 3. More info about JMS
http://jmsyst.com/libs/serializer
