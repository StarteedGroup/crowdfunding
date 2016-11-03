<?php

namespace Starteed;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\CampaignResource;
use Starteed\Resources\SupporterResource;

/**
 * Starteed Crowdfunding Reward
 *
 * Class that handles supporters related to a campaign
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Crowdfunding
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class Supporter extends ResourceBase
{
    /**
     * The Starteed Crowdfunding campaign accessor
     *
     * @var CampaignResource
     */
    public $campaign;

    /**
     * Setup the Supporter instance
     *
     * @param CampaignResource $campaign The Starteed Crowdfunding campaign resource that we want to lookup for supporters
     */
    public function __construct(CampaignResource $campaign)
    {
        $this->campaign = $campaign;
        parent::__construct($this->campaign->starteed, "campaigns/{$this->campaign->id}/supporters");
    }

    /**
     * Retrieve all the supporters related to Starteed Crowdfunding campaign
     *
     * @param array $options Payload to send in order to include additional properties or change per page pagination
     *
     * @return obj Supporter resources with paginations
     */
    public function all(array $options =  [])
    {
        $raw_data = parent::get('', $options)->getBody();
        $data = $raw_data['data'];
        $pagination = $raw_data['meta']['pagination'];

        $parsed = [];
        foreach ($data as $item) {
            array_push($parsed, new SupporterResource($this, $item));
        }

        return (object) [
            'data' => $parsed,
            'pagination' => $pagination
        ];
    }

    /**
     * Retrieve single supporter looking up for ID
     *
     * @param int   $id      Supporter ID
     * @param array $options Additional payload to send along the ID
     *
     * @return SupporterResource Single supporter resource
     */
    public function retrieve(int $id, array $options = [])
    {
        $response = parent::get($id, $options);
        $body = $response->getBody();
        return new SupporterResource($this, $body['data']);
    }
}