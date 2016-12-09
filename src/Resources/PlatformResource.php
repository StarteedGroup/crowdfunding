<?php

namespace Starteed\Resources;

use Starteed\Crowdfunding;
use Starteed\Resources\ResourceBase;

class PlatformResource extends ResourceBase
{
    public function __construct(Crowdfunding $starteed, array $data)
    {
        parent::__construct($starteed, 'platform', $data);
    }
}