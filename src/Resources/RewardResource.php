<?php

namespace Starteed\Resources;

use Starteed\Reward;
use Starteed\Donation;
use Starteed\Resources\ResourceBase;
use Starteed\Resources\DonationResource;
use Starteed\Resources\RewardTranslationResource;

class RewardResource extends ResourceBase
{
    protected $campaign;

    public function __construct(Reward $reward, array $data)
    {
        $this->campaign = $reward->campaign;
        parent::__construct($reward->starteed, "{$reward->endpoint}/{$this->id}", $data);
        $this->setupEndpoints();
    }

    protected function setupEndpoints()
    {
        $this->translation = new RewardTranslationResource($this, (array) $this->translation->data);
    }

    public function donate(array $params)
    {
        $params['IDEXT_Reward'] = $this->id;
        $donation = new Donation($this->campaign);
        $response = $donation->post($params);
        $body = $response->getBody();

        return new DonationResource(new Donation($this), $body['data']);
    }
}