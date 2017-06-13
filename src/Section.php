<?php

namespace Starteed;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\SectionResource;

/**
 * Starteed Self Section
 *
 * Class that handles sections related to a campaign
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Self
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class Section extends ResourceBase
{
    /**
     * Starteed Self instance in order to make requests
     *
     * @var SelfCrowdfunding
     */
    protected $starteed;

    /**
     * Sets up the Section instance.
     *
     * @param SelfCrowdfunding $starteed - Self instance in order to make requests
     */
    public function __construct(SelfCrowdfunding $starteed)
    {
        $this->starteed = $starteed;
        parent::__construct($starteed, 'sections');
    }

    /**
     * Retrieve all the sections related to Starteed Self campaign
     *
     * @param array $options Payload to send in order to include additional properties or change per page pagination
     *
     * @return obj Section resources with paginations
     */
    public function all(array $options = [])
    {
        $raw_data = parent::get('', $options)->getBody();
        $data = $raw_data['data'];
        $pagination = $raw_data['meta']['pagination'];

        $parsed = [];
        foreach ($data as $item) {
            array_push($parsed, new SectionResource($this->starteed, $item));
        }

        return (object) [
            'data' => $parsed,
            'pagination' => json_decode(json_encode($pagination))
        ];
    }

    /**
     * Retrieve single reward looking up for ID
     *
     * @param int   $id      Section ID
     * @param array $options Additional payload to send along the ID
     *
     * @return SectionResource Single reward resource
     */
    public function retrieve(int $id, array $options = [])
    {
        $response = parent::get($id, $options);
        $body = $response->getBody();
        return new SectionResource($this->starteed, $body['data']);
    }
}