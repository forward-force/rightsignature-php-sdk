<?php

namespace ForwardForce\RightSignature\Entities;

use ForwardForce\RightSignature\Contracts\ApiAwareContract;
use ForwardForce\RightSignature\HttpClient;

/** @psalm-suppress PropertyNotSetInConstructor */
class Document extends HttpClient implements ApiAwareContract
{
    public function fetch(): array
    {
        return $this->get($this->buildQuery('/documents'));
    }
}
