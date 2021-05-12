# RightSignature API - PHP SDK

## Installation

Install via composer as follows:
```
composer require forward-force/rightSignature-api-sdk
```

## Usage

### Authentication

In order to authenticate, you need to pass the *PRIVATE API TOKEN* like so:

```
$rightSignature = new RightSignature($token); //pv_deec47538d80245234a66e1d14d38be81
```

### Examples

Fetch all documents:
```php
$rightSignature = new RightSignature($token);

try {
    $documents = $rightSignature->documents()->fetch();
    var_dump($documents);
} catch (GuzzleException $e) {
    var_dump($e->getMessage());
}
```

Get document by id:

```php
$document = $rightSignature->documents()->getById('fcc2517e-c596-4d91-9f59-112a292eb643');
```

Clone template, prepare template (populate merge fields), and send off to signers:

```php
$signer1 = ['name' => 'buyer_signer', 'signer_email' => 'foo@example.com', 'signer_name' => 'John Doe'];
$signer2 = ['name' => 'seller_signer', 'signer_email' => 'bar@example.com', 'signer_name' => 'Jane Smith'];

$document = $rightSignature->documents()
    ->addBodyParameter('roles', [$signer1, $signer2])
    ->addBodyParameter('reusable_template', [
        'roles' => [$signer1, $signer2]
    ])
    ->addBodyParameter("message", "Please sign this")
    ->addBodyParameter('name', 'Name 1')
    ->addMergeField('client_name', 'The Client')
    ->sendDocument('fcc2517e-c596-4d91-9f59-112a292eb643');
```
Get all reusable templates:

```php
try {
    $documents = $rightSignature->documents()->fetchReusableTemplates();
    var_dump($documents);
} catch (GuzzleException $e) {
    var_dump($e->getMessage());
}
```

Get reusable template by id
```php
$document = $rightSignature->documents()->getReusableTemplateById('fcc2517e-c596-4d91-9f59-112a292eb643');
```

## Contributions

To run locally, you can use the docker container provided here. You can run it like so:

```
docker-compose up
```
There is auto-generated documentation as to how to run this library on local, please  take a look at [phpdocker/README.md](phpdocker/README.md)

*If you find an issue, have a question, or a suggestion, please don't hesitate to open a github issue.*

### Acknowledgments

Thank you to [phpdocker.io](https://phpdocker.io) for making getting PHP environments effortless! 
