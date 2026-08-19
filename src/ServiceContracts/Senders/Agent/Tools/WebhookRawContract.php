<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders\Agent\Tools;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\Tools\Webhook\WebhookRotateSecretParams;
use Zavudev\Senders\WebhookSecretResponse;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface WebhookRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|WebhookRotateSecretParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookSecretResponse>
     *
     * @throws APIException
     */
    public function rotateSecret(
        string $toolID,
        array|WebhookRotateSecretParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
