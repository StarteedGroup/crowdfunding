<?php

namespace Starteed\Resources;

use Starteed\SelfCrowdfunding;
use Starteed\Resources\ResourceBase;

class LayoutResource extends ResourceBase
{
    public function __construct(SelfCrowdfunding $starteed, array $data)
    {
        parent::__construct($starteed, 'layout', $data);
    }
}