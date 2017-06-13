<?php

namespace Starteed;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\DonatorResource;
use Starteed\Resources\CampaignResource;

/**
 * Starteed Self Donator
 *
 * Class that handles donators related to a campaign
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Self
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class Donator extends ResourceBase
{
    /**
     * The Starteed Self campaign accessor
     *
     * @var CampaignResource
     */
    public $campaign;

    /**
     * Setup the Donator instance
     *
     * @param CampaignResource $campaign The Starteed Self campaign resource that we want to lookup for donators
     */
    public function __construct(CampaignResource $campaign)
    {
        $this->campaign = $campaign;
        parent::__construct($this->campaign->starteed, "campaigns/{$this->campaign->id}/donators");
    }

    /**
     * Retrieve all the donators related to Starteed Self campaign
     *
     * @param array $options Payload to send in order to include additional properties or change per page pagination
     *
     * @return obj Donator resources with paginations
     */
    public function all(array $options =  [])
    {
        $raw_data = parent::get('', $options)->getBody();
        $data = $raw_data['data'];
        $pagination = $raw_data['meta']['pagination'];

        $parsed = [];
        foreach ($data as $item) {
            array_push($parsed, new DonatorResource($this, $item));
        }

        return (object) [
            'data' => $parsed,
            'pagination' => json_decode(json_encode($pagination))
        ];
    }

    /**
     * Retrieve single donator looking up for ID
     *
     * @param int   $id      Donator ID
     * @param array $options Additional payload to send along the ID
     *
     * @return DonatorResource Single donator resource
     */
    public function retrieve(int $id, array $options = [])
    {
        $response = parent::get($id, $options);
        $body = $response->getBody();
        return new DonatorResource($this, $body['data']);
    }
}