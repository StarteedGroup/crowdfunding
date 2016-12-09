<?php

namespace Starteed\Resources;

use Starteed\Faq;
use Starteed\Reward;
use Starteed\Update;
use Starteed\Donation;
use Starteed\Supporter;
use Starteed\Transaction;
use Starteed\FreeDonation;
use Starteed\Notification;
use Starteed\Crowdfunding;
use Starteed\Resources\ResourceBase;
use Starteed\Resources\TransactionResource;

class CampaignResource extends ResourceBase
{
    protected $faqs;
    protected $freeDonation;
    protected $rewards;
    protected $supporters;
    protected $transactions;

    public function __construct(Crowdfunding $starteed, array $data)
    {
        parent::__construct($starteed, 'campaigns/' . $data['id'], $data);
        $this->setupEndpoints();
    }

    private function setupEndpoints()
    {
        $this->faqs = new Faq($this);
        $this->freeDonation = new FreeDonation($this);
        $this->rewards = new Reward($this);
        $this->supporters = new Supporter($this);
        $this->transactions = new Transaction($this);
        $this->notification = new Notification($this);
        $this->updates = new Update($this);
    }

    public function donate(array $params)
    {
        $donation = new Donation($this);
        $params['campaign_id'] = $this->id;
        $response = $donation->post($params);
        $body = $response->getBody();
        return new TransactionResource(new Transaction($this), $body['data']);
    }

    public function wizard()
    {
        $campaign = json_decode(json_encode( parent::get(null, ['include' => 'wizard'])->getBody() ));
        return $campaign->data->wizard->data;
    }

    public function share($platform, $user_id = null)
    {
        return parent::request('POST', 'share', ['platform' => $platform, 'user_id' => $user_id], [])->getBody();
    }
}