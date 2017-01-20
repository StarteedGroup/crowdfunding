<?php

namespace Starteed\Resources;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\DonationResource;

class MethodResource extends ResourceBase
{
    public function __construct(DonationResource $donation, array $data)
    {
        parent::__construct($donation->starteed, "", $data);
    }
}