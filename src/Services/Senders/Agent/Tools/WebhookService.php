<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders\Agent\Tools;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\RequestOptions;
use Zavudev\Senders\WebhookSecretResponse;
use Zavudev\ServiceContracts\Senders\Agent\Tools\WebhookContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class WebhookService implements WebhookContract
{
    /**
     * @api
     */
    public WebhookRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new WebhookRawService($client);
    }

    /**
     * @api
     *
     * Generate a new signing secret for this tool. The previous one stops working on the next call, with no overlap, so update your endpoint first. The tool keeps its id, so flows that reference it by name are unaffected.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function rotateSecret(
        string $toolID,
        string $senderID,
        RequestOptions|array|null $requestOptions = null,
    ): WebhookSecretResponse {
        $params = Util::removeNulls(['senderID' => $senderID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->rotateSecret($toolID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
