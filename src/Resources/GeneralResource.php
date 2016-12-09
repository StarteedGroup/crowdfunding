<?php

namespace Starteed\Resources;

use Starteed\Crowdfunding;
use Starteed\Resources\ResourceBase;

class GeneralResource extends ResourceBase
{
    public function __construct(Crowdfunding $starteed, array $data)
    {
        parent::__construct($starteed, 'general', $data);
    }
}