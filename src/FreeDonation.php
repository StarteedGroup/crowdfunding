<?php

namespace Starteed;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\CampaignResource;
use Starteed\Resources\FreeDonationResource;

/**
 * Starteed Crowdfunding free donation
 *
 * Class that handles reward related to campaign free donation
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Crowdfunding
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class FreeDonation extends ResourceBase
{
    /**
     * The Starteed Crowdfunding campaign accessor
     *
     * @var CampaignResource
     */
    public $campaign;

    /**
     * Setup the Reward instance
     *
     * @param CampaignResource $campaign The Starteed Crowdfunding campaign resource that we want to lookup for rewards
     */
    public function __construct(CampaignResource $campaign)
    {
        $this->campaign = $campaign;
        parent::__construct($this->campaign->starteed, "campaigns/{$this->campaign->id}/free_donation");
    }

    /**
     * Retrieve reward
     *
     * @param array $options Additional payload to send along the ID
     *
     * @return FreeDonationResource Single free donation reward resource
     */
    public function retrieve(array $options = [])
    {
        $response = parent::get('', $options);
        $body = $response->getBody();
        return new FreeDonationResource($this, $body['data']);
    }
}