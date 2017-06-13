<?php

namespace Starteed;

use Starteed\Resources\ResourceBase;
use Starteed\Resources\GeneralResource;

/**
 * Starteed Self General configuration
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
class General extends ResourceBase
{
    /**
     * Starteed Self instance in order to make requests
     *
     * @var SelfCrowdfunding
     */
    protected $starteed;

    /**
     * Sets up the General instance.
     *
     * @param SelfCrowdfunding $starteed - Self instance in order to make requests
     */
    public function __construct(SelfCrowdfunding $starteed)
    {
        $this->starteed = $starteed;
        parent::__construct($starteed, 'general');
    }

    /**
     * Retrieve General
     *
     * @param array $options Request payload
     *
     * @return GeneralResource General resource to access related data
     */
    public function retrieve(array $options = [])
    {
        $response = parent::get('', $options);
        $body = $response->getBody();
        return new GeneralResource($this->starteed, $body['data']);
    }
}