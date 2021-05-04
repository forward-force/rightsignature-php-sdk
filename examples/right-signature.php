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

//Get document by id
$document = $rightSignature->documents()->getById(reset($documents)['id']);
var_dump($document);

