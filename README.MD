

# Installation (this package based on lcobucci/jwt)

make sure your php version > 7.0

```bash
composer require viloveul/auth
```

## HOW

first you need to generate private key and public key
```bash
$ openssl genrsa -out private.pem -aes256 4096
$ openssl rsa -pubout -in private.pem -out public.pem
```

add this

```php
require __DIR__ . '/vendor/autoload.php';

$auth = new Viloveul\Auth\Authentication($your_phrase);

$auth->setPrivateKey('private.pem');

$auth->setPublicKey('public.pem');

// create user data
$data = new Viloveul\Auth\UserData([
	'id' => 5,
	'name' => 'Viloveul',
	'email' => 'me@viloveul.com'
]);

// get token
$token = $auth->generate($data);
var_dump($token);

// check token
$auth->setToken($token);
var_dump($auth->authenticate());

```