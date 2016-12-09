<?php

namespace Starteed;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\CampaignResource;
use Starteed\Resources\TransactionResource;

/**
 * Starteed Crowdfunding Reward
 *
 * Class that handles transactions related to a campaign.
 * JWT token is mandatory due to sensitive datas.
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Crowdfunding
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class Transaction extends ResourceBase
{
    /**
     * The Starteed Crowdfunding campaign accessor
     *
     * @var CampaignResource
     */
    public $campaign;

    /**
     * Setup the Transaction instance
     *
     * @param CampaignResource $campaign The Starteed Crowdfunding campaign resource that we want to lookup for transactions
     */
    public function __construct(CampaignResource $campaign)
    {
        $this->campaign = $campaign;
        parent::__construct($this->campaign->starteed, "campaigns/{$this->campaign->id}/transactions");
    }

    /**
     * Retrieve all the transactions related to Starteed Crowdfunding campaign
     *
     * @param array $options Payload to send in order to include additional properties or change per page pagination
     *
     * @return obj Transaction resources with paginations
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
     * Retrieve single transaction looking up for ID
     *
     * @param int   $id      Transaction ID
     * @param array $options Additional payload to send along the ID
     *
     * @return TransactionResource Single Transaction resource
     */
    public function retrieve(int $id, array $options = [])
    {
        $response = parent::get($id, $options);
        $body = $response->getBody();
        return new TransactionResource($this, $body['data']);
    }

    /**
     * Search transactions by values
     *
     * @param array $payload Request payload
     *
     * @return TransactionResource Transaction resource to access related data
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

    protected function parseCollection(array $data): array
    {
        $parsed = [];
        foreach ($data as $item) {
            array_push($parsed, new TransactionResource($this, $item));
        }
        return $parsed;
    }

    /**
     * Retrieve all completed transactions
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