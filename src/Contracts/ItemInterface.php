<?php

namespace Starteed\Contracts;

interface ItemInterface
{
    /**
     * @param int|null  $id
     * @param array     $options
     *
     * @return \Starteed\Contracts\RequestableInterface
     */
    public function retrieve($id = null, array $options = []);
}