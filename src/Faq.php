<?php

namespace Starteed;

use Starteed\Resources\FaqResource;
use Starteed\Resources\ResourceBase;
use Starteed\Resources\CampaignResource;

/**
 * Starteed Self FAQ
 *
 * Class that handles FAQs related to a campaign
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Self
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class Faq extends ResourceBase
{
    /**
     * The Starteed Self campaign accessor
     *
     * @var CampaignResource
     */
    public $campaign;

    /**
     * Setup the Faq instance
     *
     * @param CampaignResource $campaign The Starteed Self campaign resource that we want to lookup for faqs
     */
    public function __construct(CampaignResource $campaign)
    {
        $this->campaign = $campaign;
        parent::__construct($this->campaign->starteed, "campaigns/{$this->campaign->id}/faqs");
    }

    /**
     * Retrieve all the faqs related to Starteed Self campaign
     *
     * @param array $options Payload to send in order to include additional properties or change per page pagination
     *
     * @return obj FAQ resources with paginations
     */
    public function all(array $options =  [])
    {
        $raw_data = parent::get('', $options)->getBody();
        if (
            array_key_exists('limit', $options)
            && is_numeric($options['limit'])
        ) {
            $pagination = $raw_data['meta']['pagination'];

        }
        $output = [
            'data' => $raw_data['data']
        ];
        if (isset($pagination)) {
            $output['pagination'] = $pagination;

        }
        $parsed = [];
        foreach ($raw_data['data'] as $item) {
            array_push($parsed, new FaqResource($this, $item));

        }
        $output['data'] = $parsed;
        return (object) $output;
    }

    /**
     * Retrieve single FAQ looking up for ID
     *
     * @param int   $id      Donator ID
     * @param array $options Additional payload to send along the ID
     *
     * @return FaqResource Single FAQ resource
     */
    public function retrieve(int $id, array $options = [])
    {
        $response = parent::get($id, $options);
        $body = $response->getBody();
        return new FaqResource($this, $body['data']);
    }
}