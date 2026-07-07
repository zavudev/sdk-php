<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\ServiceContracts\PlanContract;

final class PlanService implements PlanContract
{
    /**
     * @api
     */
    public PlanRawService $raw;

    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new PlanRawService($client);
    }
}
