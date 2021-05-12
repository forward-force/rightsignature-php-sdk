<?php
require_once __DIR__ . '../../vendor/autoload.php';

use ForwardForce\RightSignature\RightSignature;
use GuzzleHttp\Exception\GuzzleException;

//assumes token is in env var, or you can pass directly
$token = getenv('RIGHT_SIGNATURE_API_KEY');

//instance of the RightSignature client
$rightSignature = new RightSignature($token);

//Get all documents
try {
    $documents = $rightSignature->documents()->fetch();
    var_dump($documents);
} catch (GuzzleException $e) {
    var_dump($e->getMessage());
}

//Get all reusable templates
try {
    $documents = $rightSignature->documents()->fetchReusableTemplates();
    var_dump($documents);
} catch (GuzzleException $e) {
    var_dump($e->getMessage());
}

//Get document by id
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
    ->sendDocument(reset($documents)['id']);

var_dump($document);

//Get document by id
$document = $rightSignature->documents()->getById(reset($documents)['id']);
var_dump($document);


//Get reusable template by id
$document = $rightSignature->documents()->getReusableTemplateById(reset($documents)['id']);
var_dump($document);

