<?php

namespace Starteed\Resources;

use Starteed\Notification;
use Starteed\Resources\ResourceBase;
use Starteed\Resources\DonationResource;

class NotificationResource extends ResourceBase
{
    protected $campaign;

    public function __construct(Notification $notification, array $data)
    {
        $this->campaign = $notification->campaign;
        parent::__construct($notification->starteed, $notification->endpoint, $data);
    }
}