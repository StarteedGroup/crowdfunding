<?php

namespace Starteed\Resources;

use Starteed\FreeDonation;
use Starteed\Resources\ResourceBase;

class FreeDonationResource extends ResourceBase
{
    protected $campaign;

    public function __construct(FreeDonation $free_donation, array $data)
    {
        $this->campaign = $free_donation->campaign;
        parent::__construct($free_donation->starteed, $free_donation->endpoint, $data);
    }
}