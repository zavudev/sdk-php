<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\ServiceContracts\Number10dlcContract;
use Zavudev\Services\Number10dlc\BrandsService;
use Zavudev\Services\Number10dlc\CampaignsService;

final class Number10dlcService implements Number10dlcContract
{
    /**
     * @api
     */
    public Number10dlcRawService $raw;

    /**
     * @api
     */
    public BrandsService $brands;

    /**
     * @api
     */
    public CampaignsService $campaigns;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new Number10dlcRawService($client);
        $this->brands = new BrandsService($client);
        $this->campaigns = new CampaignsService($client);
    }
}
