<?php

namespace Starteed\Resources;

use Starteed\Faq;
use Starteed\Reward;
use Starteed\Update;
use Starteed\Donator;
use Starteed\Donation;
use Starteed\FreeDonation;
use Starteed\Notification;
use Starteed\Crowdfunding;
use Starteed\Resources\ResourceBase;
use Starteed\Resources\FundingResource;
use Starteed\Resources\CurrencyResource;
use Starteed\Resources\DonationResource;

class CampaignResource extends ResourceBase
{
    protected $faqs;
    protected $freeDonation;
    protected $rewards;
    protected $donators;
    protected $donations;

    public function __construct(Crowdfunding $starteed, array $data)
    {
        parent::__construct($starteed, 'campaigns/' . $data['id'], $data);
        $this->setupEndpoints();
    }

    protected function setupEndpoints()
    {
        $this->faqs = new Faq($this);
        $this->translation = new CampaignTranslationResource($this, (array) $this->translation->data);
        $this->freeDonation = new FreeDonation($this);
        $this->rewards = new Reward($this);
        $this->donators = new Donator($this);
        $this->donations = new Donation($this);
        $this->notification = new Notification($this);
        $this->updates = new Update($this);
        $this->funding = new FundingResource($this, (array) $this->funding->data);
        $this->currency = new CurrencyResource($this, (array) $this->currency->data);
    }

    public function donate(array $params)
    {
        $donation = new Donation($this);
        $params['campaign_id'] = $this->id;
        $response = $donation->post($params);
        $body = $response->getBody();
        return new DonationResource(new Donation($this), $body['data']);
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