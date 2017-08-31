<?php

namespace Starteed\Resources;

use Starteed\BaseResource;

/**
 * @property boolean $is_paypal
 * @property boolean $is_bank_transfer
 */
class MethodResource extends BaseResource
{
    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->setData($data);
    }
}