<?php

namespace Starteed;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\CampaignResource;

/**
 * Starteed Campaign Resource
 *
 * Resource class to access single or paginated Starteed Crowdfunding campaigns
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Crowdfunding
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class Campaign extends ResourceBase
{
    /**
     * Starteed Crowdfunding instance in order to make requests
     *
     * @var Crowdfunding
     */
    protected $starteed;

    /**
     * Sets up the Campaign instance.
     *
     * @param Crowdfunding $starteed - Crowdfunding instance in order to make requests
     */
    public function __construct(Crowdfunding $starteed)
    {
        $this->starteed = $starteed;
        parent::__construct($starteed, 'campaigns');
    }

    /**
     * Retrieve all campaigns
     *
     * @param array $options Request payload
     *
     * @return object Array of data with meta pagination
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
     * Retrieve single campaign by ID
     *
     * @param int   $id      Campaign ID
     * @param array $options Request payload
     *
     * @return CampaignResource Campaign resource to access related data
     */
    public function retrieve(int $id, array $options = [])
    {
        $response = parent::get($id, $options);
        $body = $response->getBody();
        return new CampaignResource($this->starteed, $body['data']);
    }

    /**
     * Search campaigns by values
     *
     * @param array $payload Request payload
     *
     * @return CampaignResource Campaign resource to access related data
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
            array_push($parsed, new CampaignResource($this->starteed, $item));
        }
        return $parsed;
    }
}