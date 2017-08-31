<?php

namespace Starteed\Resources;

use Starteed\BaseResource;

/**
 * @property bool   $is_keep_it_all
 * @property bool   $is_all_or_nothing
 * @property string $label
 */
class FundingResource extends BaseResource
{
    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->setData($data);
    }
}