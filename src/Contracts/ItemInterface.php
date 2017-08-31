<?php

namespace Starteed\Contracts;

interface ItemInterface
{
    /**
     * @param int   $id
     * @param array $options
     *
     * @return \Starteed\Contracts\RequestableInterface
     */
    public function retrieve(int $id, array $options);
}