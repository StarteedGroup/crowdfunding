<?php

namespace Starteed;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\VersionResource;

/**
 * Starteed Self Version
 *
 * Resource class to access single or paginated versions enabled to platform
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Self
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class Version extends ResourceBase
{
    /**
     * Starteed Self instance in order to make requests
     *
     * @var SelfCrowdfunding
     */
    protected $starteed;

    /**
     * Sets up the Version instance.
     *
     * @param SelfCrowdfunding $starteed - Self instance in order to make requests
     */
    public function __construct(SelfCrowdfunding $starteed)
    {
        $this->starteed = $starteed;
        parent::__construct($starteed, 'versions');
    }

    /**
     * Retrieve all versions
     *
     * @param array $options Request payload
     *
     * @return object Array of data with meta pagination
     */
    public function all(array $options =  [])
    {
        $raw_data = parent::get('', $options)->getBody();
        $data = $raw_data['data'];
        $pagination = $raw_data['meta']['pagination'];

        $parsed = [];
        foreach ($data as $item) {
            array_push($parsed, new VersionResource($this->starteed, $item));
        }

        return (object) [
            'data' => $parsed,
            'pagination' => $pagination
        ];
    }

    /**
     * Retrieve single version by ID
     *
     * @param int   $id      Version ID
     * @param array $options Request payload
     *
     * @return VersionResource Version resource to access related data
     */
    public function retrieve(int $id, array $options = [])
    {
        $response = parent::get($id, $options);
        $body = $response->getBody();
        return new VersionResource($this->starteed, $body['data']);
    }
}