<?php

namespace ForwardForce\RightSignature\Contracts;

interface ApiAwareContract
{
    /**
     * Get all of entity
     *
     * @return array
     */
    public function fetch(): array;
}
