<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\ServiceContracts\ExportsContract;

final class ExportsService implements ExportsContract
{
    /**
     * @api
     */
    public ExportsRawService $raw;

    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ExportsRawService($client);
    }
}
