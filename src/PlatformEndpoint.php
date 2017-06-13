<?php

namespace Starteed;

use Starteed\Contracts\ItemInterface;
use Starteed\Resources\PlatformResource;

/**
 * Starteed Self Crowdfunding Platform
 *
 * API endpoint related to Starteed SELF Platform.
 *
 * PHP version 7.0
 *
 * @category Class
 * @package  Self
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class PlatformEndpoint extends BaseRequest implements ItemInterface
{
    /**
     * Starteed Self instance in order to make requests
     *
     * @var SelfCrowdfunding
     */
    protected $starteed;

    /**
     * @var \Starteed\Resources\PlatformResource
     */
    protected $resource;

    /**
     * Sets up the Platform instance.
     *
     * @param SelfCrowdfunding $starteed Self instance in order to make requests
     */
    public function __construct(SelfCrowdfunding $starteed)
    {
        $this->setStarteedEndpoint($starteed);
    }

    /**
     * Retrieve platform
     *
     * @param null  $id
     * @param array $options Request payload
     *
     * @return \Starteed\Resources\PlatformResource Platform resource to access related data
     */
    public function retrieve($id = null, array $options = []): PlatformResource
    {
        if (!$this->resource) {
            $response = parent::get($this->getEndpointUri(), $options);
            $this->resource = new PlatformResource($this, $response);
        }
        return $this->resource;
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    public function getEndpointUri(string $uri = ''): string
    {
        return "platform/{$uri}";
    }
}