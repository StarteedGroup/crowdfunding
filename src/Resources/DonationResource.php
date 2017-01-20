<?php

namespace Starteed\Resources;

use Starteed\Donator;
use Starteed\Donation;
use Starteed\Resources\DonatorResource;
use Starteed\Resources\ResourceBase;

class DonationResource extends ResourceBase
{
	protected $donation;

    public function __construct(Donation $donation, array $data)
    {
    	$this->donation = $donation;
        parent::__construct($this->donation->starteed, $this->donation->endpoint . '/' . $data['id'], $data);
        $this->setupEndpoints();
    }

    protected function setupEndpoints()
    {
    	$endpoint = new Donator($this->donation->campaign);
        $this->donator = new DonatorResource($endpoint, (array) $this->donator->data);
        $this->method = new MethodResource($this, (array) $this->method->data);
    }

    public function share(array $emails)
    {
        return parent::request('POST', 'share', ['emails' => $emails], [])->getBody();
    }
}