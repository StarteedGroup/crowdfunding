<?php

namespace Starteed\Resources;

use Starteed\BaseResource;

class FontResource extends BaseResource
{
    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->setData($data);
    }
}