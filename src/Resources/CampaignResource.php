<?php

namespace Starteed\Resources;

use Starteed\Faq;
use Starteed\Reward;
use Starteed\Supporter;
use Starteed\Transaction;
use Starteed\Crowdfunding;
use Starteed\Resources\ResourceBase;
use Starteed\Resources\TransactionResource;

class CampaignResource extends ResourceBase
{
    public $faqs;
    public $rewards;
    public $supporters;
    public $transactions;

    public function __construct(Crowdfunding $starteed, array $data)
    {
        $this->starteed = $starteed;
        $this->resource = json_decode(json_encode($data));
        parent::__construct($this->starteed, "campaigns/{$this->id}");
        $this->setupEndpoints();
    }

    private function setupEndpoints()
    {
        $this->faqs = new Faq($this);
        $this->rewards = new Reward($this);
        $this->supporters = new Supporter($this);
        $this->transactions = new Transaction($this);
    }

    public function donate(array $params)
    {
        $donation = new Donation($this);
        $params['IDEXT_Project'] = $this->id;
        $response = $donation->post($params);
        $body = $response->getBody();
        return new TransactionResource(new Transaction($this), $body['data']);
    }

    {
    }
}