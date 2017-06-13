<?php

namespace Starteed;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\CampaignResource;
use Starteed\Resources\NotificationResource;

/**
 * Starteed Self Notification configuration
 *
 * Class that handles notification settings related to a campaign
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Self
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class Notification extends ResourceBase
{
    /**
     * The Starteed Self campaign accessor
     *
     * @var CampaignResource
     */
    public $campaign;

    /**
     * Setup the Notification instance
     *
     * @param CampaignResource $campaign The Starteed Self campaign resource that we want to lookup for notification settings
     */
    public function __construct(CampaignResource $campaign)
    {
        $this->campaign = $campaign;
        parent::__construct($this->campaign->starteed, "campaigns/{$this->campaign->id}/notification");
    }

    /**
     * Retrieve the notification settings related to campaign
     *
     * @param int   $id      Notification ID
     * @param array $options Additional payload to send along the ID
     *
     * @return NotificationResource Notification resource
     */
    public function retrieve(array $options = [])
    {
        $response = parent::get('', $options);
        $body = $response->getBody();
        return new NotificationResource($this, $body['data']);
    }
}