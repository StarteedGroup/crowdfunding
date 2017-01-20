<?php

namespace Starteed\Resources;

use Starteed\Donator;
use Starteed\Resources\ResourceBase;

class DonatorResource extends ResourceBase
{
    public function __construct(Donator $donator, array $data)
    {
        parent::__construct($donator->starteed, $donator->endpoint . '/' . $data['id'], $data);
    }
}