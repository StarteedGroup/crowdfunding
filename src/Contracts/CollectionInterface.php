<?php

namespace Starteed\Contracts;

interface CollectionInterface
{
    /**
     * @param array $options
     *
     * @return array|\Starteed\Contracts\RequestableInterface[]
     */
    public function all(array $options = []): array;
}