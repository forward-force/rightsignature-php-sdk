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
     * Fetch all reusable templates
     *
     * @return array
     * @throws GuzzleException
     */
    public function fetchReusableTemplates(): array
    {
        return $this->get($this->buildQuery('/reusable_templates'));
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
     * Grab a reusable template by id
     *
     * @param string $uuid
     * @return array
     * @throws GuzzleException
     */
    public function getReusableTemplateById(string $uuid): array
    {
        return $this->get($this->buildQuery('/reusable_templates/' . $uuid));
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
        $document = $this->getReusableTemplateById($uuid);

        $mergeFields = $this->transformMergeTags($document, $this->getMergeFields());
        $this->addBodyParameter('merge_field_values', $mergeFields);

        return $this->post($this->buildQuery('/reusable_templates/' . $uuid . '/send_document'));
    }

    /**
     * Transforms merge fields from key value pair to RightSignature API required data nested data structure
     *
     * @param array $document
     * @param array $mergeFields
     * @return array
     */
    private function transformMergeTags(array $document, array $mergeFields): array
    {
        $idMap = array_column($document['merge_field_components'], 'name', 'id');

        $map = [];
        foreach ($document['merge_field_components'] as $component) {
            $map[$component['id']] = $component;
        }

        $mapped = [];
        foreach ($mergeFields as $id => $value) {
            $uuid = array_search($id, $idMap);

            if (!$uuid || !isset($map[$uuid])) {
                continue;
            }

            $component = $map[$uuid];

            if ($component['type'] == 'TextComponent') {
                $value = (string) $value;
            }

            $mapped[] = ['id' => $uuid, 'value' => $value];
        }

        return $mapped;
    }
}
