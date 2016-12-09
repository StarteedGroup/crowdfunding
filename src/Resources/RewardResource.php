<?php

namespace Starteed\Resources;

use Starteed\Reward;
use Starteed\Donation;
use Starteed\Resources\ResourceBase;
use Starteed\Resources\TransactionResource;

class RewardResource extends ResourceBase
{
    protected $campaign;

    public function __construct(Reward $reward, array $data)
    {
        $this->campaign = $reward->campaign;
        parent::__construct($reward->starteed, "{$reward->endpoint}/{$this->id}", $data);
    }

    public function donate(array $params)
    {
        $params['IDEXT_Reward'] = $this->id;
        $donation = new Donation($this->campaign);
        $response = $donation->post($params);
        $body = $response->getBody();

        return new TransactionResource(new Transaction($this), $body['data']);
    }
}