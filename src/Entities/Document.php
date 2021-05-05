<?php

namespace ForwardForce\RightSignature\Entities;

use ForwardForce\RightSignature\Contracts\ApiAwareContract;
use ForwardForce\RightSignature\HttpClient;
use GuzzleHttp\Exception\GuzzleException;

/** @psalm-suppress PropertyNotSetInConstructor */
class Document extends HttpClient implements ApiAwareContract
{
    /**
     * Fetch all documents
     *
     * @return array
     * @throws GuzzleException
     */
    public function fetch(): array
    {
        return $this->get($this->buildQuery('/documents'));
    }

    /**
     * Grab a single document by id
     *
     * @param string $uuid
     * @return array
     * @throws GuzzleException
     */
    public function getById(string $uuid): array
    {
        return $this->get($this->buildQuery('/documents/' . $uuid));
    }

    /**
     * Send a document to signer
     *
     * @param string $uuid
     * @return array
     * @throws GuzzleException
     */
    public function sendDocument(string $uuid): array
    {
        return $this->post($this->buildQuery('/documents/' . $uuid . '/send_document'));
    }
}
