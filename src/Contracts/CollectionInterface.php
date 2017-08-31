<?php

namespace Starteed\Contracts;

interface CollectionInterface
{
    /**
     * @param array $options
     *
     * @return \Starteed\Contracts\RequestableInterface[]
     */
    public function all(array $options);
}