<?php

namespace Starteed;

use Starteed\Contracts\ItemInterface;
use Starteed\Resources\GeneralResource;
use Starteed\Resources\PlatformResource;

/**
 * Starteed Self Crowdfunding General configuration
 *
 * API endpoint related to Starteed SELF General configuration.
 *
 * PHP version 7.0
 *
 * @category Class
 * @package  Self
 * @author   Dario Tranchitella <dario.tranchitella@starteed.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://starteed.com
 */
class GeneralEndpoint extends BaseRequest implements ItemInterface
{
    /**
     * Starteed Self instance in order to make requests
     *
     * @var \Starteed\SelfCrowdfunding
     */
    protected $starteed;

    /**
     * @var \Starteed\Resources\GeneralResource
     */
    protected $resource;

    /**
     * Sets up the General configuration instance.
     *
     * @param \Starteed\SelfCrowdfunding $starteed SELF instance in order to make requests
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
     * @return \Starteed\Resources\GeneralResource Platform resource to access related data
     */
    public function retrieve($id = null, array $options = []): GeneralResource
    {
        if (!$this->resource) {
            $response = parent::get($this->getEndpointUri(), $options);
            $this->resource = new GeneralResource($this, $response);
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
        return "general/{$uri}";
    }
}