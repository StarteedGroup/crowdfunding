<?php

namespace Starteed;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\PlatformResource;

/**
 * Starteed Platform Resource
 *
 * Resource class to access single or paginated versions enabled to platform
 *
 * PHP version 5.4
 *
 * @category Class
 * @package  Crowdfunding
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class Platform extends ResourceBase
{
    /**
     * Starteed Crowdfunding instance in order to make requests
     *
     * @var Crowdfunding
     */
    protected $starteed;

    /**
     * Sets up the Platform instance.
     *
     * @param Crowdfunding $starteed - Crowdfunding instance in order to make requests
     */
    public function __construct(Crowdfunding $starteed)
    {
        $this->starteed = $starteed;
        parent::__construct($starteed, 'platform');
    }

    /**
     * Retrieve platform
     *
     * @param array $options Request payload
     *
     * @return PlatformResource Platform resource to access related data
     */
    public function retrieve(array $options = [])
    {
        $response = parent::get('', $options);
        $body = $response->getBody();
        return new PlatformResource($this->starteed, $body['data']);
    }
}