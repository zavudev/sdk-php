<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders\Agent\Tools;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\Senders\WebhookSecretResponse;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface WebhookContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function rotateSecret(
        string $toolID,
        string $senderID,
        RequestOptions|array|null $requestOptions = null,
    ): WebhookSecretResponse;
}
