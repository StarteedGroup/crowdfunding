<?php

namespace Starteed;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\RewardResource;
use Starteed\Resources\CampaignResource;

/**
 * Starteed Crowdfunding Reward
 *
 * Class that handles rewards related to a campaign
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Crowdfunding
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class Reward extends ResourceBase
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
        parent::__construct($this->campaign->starteed, "campaigns/{$this->campaign->id}/rewards");
    }

    /**
     * Retrieve all the rewards related to Starteed Crowdfunding campaign
     *
     * @param array $options Payload to send in order to include additional properties or change per page pagination
     *
     * @return obj Reward resources with paginations
     */
    public function all(array $options = [])
    {
        $raw_data = parent::get('', $options)->getBody();
        $data = $raw_data['data'];
        $pagination = $raw_data['meta']['pagination'];

        $parsed = [];
        foreach ($data as $item) {
            array_push($parsed, new RewardResource($this, $item));
        }

        return (object) [
            'data' => $parsed,
            'pagination' => $pagination
        ];
    }

    /**
     * Retrieve single reward looking up for ID
     *
     * @param int   $id      Reward ID
     * @param array $options Additional payload to send along the ID
     *
     * @return RewardResource Single Supporter resource
     */
    public function retrieve(int $id, array $options = [])
    {
        $response = parent::get($id, $options);
        $body = $response->getBody();
        return new RewardResource($this, $body['data']);
    }
}