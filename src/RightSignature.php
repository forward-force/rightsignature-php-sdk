<?php

namespace ForwardForce\RightSignature;

use ForwardForce\RightSignature\Entities\Document;

class RightSignature
{
    /**
     * RightSignature API key
     *
     * @var string
     */
    protected string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Fetch documents from rightSignature.com
     *
     * @return Document
     */
    public function documents(): Document
    {
        return new Document($this->token);
    }
}
