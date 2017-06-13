<?php

namespace Starteed;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\CampaignResource;
use Starteed\Resources\DonationResource;

/**
 * Starteed Self Donation
 *
 * Class that handles donations related to a campaign.
 * JWT token is mandatory due to sensitive datas.
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Self
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class Donation extends ResourceBase
{
    /**
     * The Starteed Self campaign accessor
     *
     * @var CampaignResource
     */
    public $campaign;

    /**
     * Setup the Donation instance
     *
     * @param CampaignResource $campaign The Starteed Self campaign resource that we want to lookup for donations
     */
    public function __construct(CampaignResource $campaign)
    {
        $this->campaign = $campaign;
        parent::__construct($this->campaign->starteed, "campaigns/{$this->campaign->id}/donations");
    }

    /**
     * Retrieve all the donations related to Starteed Self campaign
     *
     * @param array $options Payload to send in order to include additional properties or change per page pagination
     *
     * @return obj Donation resources with paginations
     */
    public function all(array $options =  [])
    {
        $raw_data = parent::get('', $options)->getBody();
        $pagination = $raw_data['meta']['pagination'];

        return (object) [
            'data' => $this->parseCollection( $raw_data['data'] ),
            'pagination' => json_decode(json_encode($pagination))
        ];
    }

    /**
     * Retrieve single donation looking up for ID
     *
     * @param int   $id      Donation ID
     * @param array $options Additional payload to send along the ID
     *
     * @return DonationResource Single Donation resource
     */
    public function retrieve(int $id, array $options = [])
    {
        $response = parent::get($id, $options);
        $body = $response->getBody();
        return new DonationResource($this, $body['data']);
    }

    /**
     * Search donations by values
     *
     * @param array $payload Request payload
     *
     * @return DonationResource Donation resource to access related data
     */
    public function search(array $payload)
    {
        $raw_data = parent::get('search', $payload)->getBody();
        $pagination = $raw_data['meta']['pagination'];

        return (object) [
            'data' => $this->parseCollection( $raw_data['data'] ),
            'pagination' => json_decode(json_encode($pagination))
        ];
    }

    protected function parseCollection(array $data)
    {
        $parsed = [];
        foreach ($data as $item) {
            array_push($parsed, new DonationResource($this, $item));
        }
        return $parsed;
    }

    /**
     * Retrieve all completed donations
     */
    public function completed(int $page = 1)
    {
        return $this->search([
            'where' => [
                'IDEXT_ProjectStatusPayment' => 2
            ],
            'limit' => 24,
            'page' => $page
        ]);
    }
}