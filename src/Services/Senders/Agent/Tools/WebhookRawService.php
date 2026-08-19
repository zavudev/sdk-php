<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders\Agent\Tools;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\Tools\Webhook\WebhookRotateSecretParams;
use Zavudev\Senders\WebhookSecretResponse;
use Zavudev\ServiceContracts\Senders\Agent\Tools\WebhookRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class WebhookRawService implements WebhookRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Generate a new signing secret for this tool. The previous one stops working on the next call, with no overlap, so update your endpoint first. The tool keeps its id, so flows that reference it by name are unaffected.
     *
     * @param array{senderID: string}|WebhookRotateSecretParams $params
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
    ): BaseResponse {
        [$parsed, $options] = WebhookRotateSecretParams::parseRequest(
            $params,
            $requestOptions,
        );
        $senderID = $parsed['senderID'];
        unset($parsed['senderID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/senders/%1$s/agent/tools/%2$s/webhook/secret', $senderID, $toolID,
            ],
            options: $options,
            convert: WebhookSecretResponse::class,
        );
    }
}
