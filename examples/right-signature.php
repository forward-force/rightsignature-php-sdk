<?php
require_once __DIR__ . '../../vendor/autoload.php';

use ForwardForce\RightSignature\RightSignature;
use GuzzleHttp\Exception\GuzzleException;

//assumes token is in env var, or you can pass directly
$token = getenv('RIGHT_SIGNATURE_API_KEY');

//instance of the RightSignature client
$rightSignature = new RightSignature($token);

try {
    $documents = $rightSignature->documents();
    var_dump($documents);
} catch (GuzzleException $e) {
    var_dump($e->getMessage());
}
