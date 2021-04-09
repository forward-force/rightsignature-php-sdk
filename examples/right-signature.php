<?php
require_once __DIR__ . '../../vendor/autoload.php';

use ForwardForce\RightSignature\RightSignature;
use GuzzleHttp\Exception\GuzzleException;

//assumes token is in env var, or you can pass directly
$token = getenv('RIGHT_SIGNATURE_API_KEY');

//instance of the RightSignature client
$rightSignature = new RightSignature($token);

try {
    $property = $rightSignature->property('151 Battle Green Dr', 'Rochester', 'NY', '14624');
    var_dump($property);
} catch (GuzzleException $e) {
    var_dump($e->getMessage());
}
