<?php

namespace Starteed\Resources;

use Starteed\BaseResource;

/**
 * @property string $symbol
 */
class CurrencyResource extends BaseResource
{
    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->setData($data);
    }
}