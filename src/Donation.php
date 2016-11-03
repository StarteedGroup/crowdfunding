<?php

namespace Starteed;

use Starteed\StarteedResponse;
use Starteed\Resources\ResourceBase;
use Starteed\Resources\CampaignResource;
use Starteed\Resources\TransactionResource;

/**
 * Starteed Crowdfunding Donation
 *
 * Class to handle donation to campaign
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Crowdfunding
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class Donation extends ResourceBase
{
    /**
     * Starteed Crowdfunding campaign selected
     *
     * @var CampaignResource
     */
    protected $campaign;

    /**
     * Setup the Donation instance
     *
     * @param CampaignResource $campaign Starteed Crowdfunding campaign that support wants to pledges
     */
    public function __construct(CampaignResource $campaign)
    {
        $this->campaign = $campaign;
        parent::__construct($this->campaign->starteed, "campaigns/{$this->campaign->id}/donate");
    }

    /**
     * Send the POST request with pyaload
     *
     * @param array $payload Donation parameters such as amount, user_id, reward_id and so on
     * @param array $headers Additional headers to send with the payload
     *
     * @return StarteedResponse Response due to sync request
     */
    public function post(array $payload = [], array $headers = [])
    {
        $parsed_payload = $this->parsePayload($payload);
        return $this->request('POST', '', $parsed_payload, $headers);
    }

    /**
     * Parse payload data overriding the Starteed Crowdfunding campaign id
     *
     * @param array $payload The payload that need to be parsed
     *
     * @return array Parsed payload data
     */
    public function parsePayload(array $payload = [])
    {
        $payload['IDEXT_Project'] = $this->campaign->id;
        return $payload;
    }
}