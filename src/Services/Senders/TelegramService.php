<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\RequestOptions;
use Zavudev\Senders\Telegram\TelegramConnectResponse;
use Zavudev\ServiceContracts\Senders\TelegramContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class TelegramService implements TelegramContract
{
    /**
     * @api
     */
    public TelegramRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new TelegramRawService($client);
    }

    /**
     * @api
     *
     * Connect a Telegram bot to a sender. Provide the bot token from @BotFather; Zavu validates it, registers the webhook, and routes the sender's Telegram messages through it.
     *
     * @param string $botToken bot token from @BotFather
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function connect(
        string $senderID,
        string $botToken,
        RequestOptions|array|null $requestOptions = null,
    ): TelegramConnectResponse {
        $params = Util::removeNulls(['botToken' => $botToken]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->connect($senderID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Disconnect Telegram from a sender and remove the webhook.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function disconnect(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->disconnect($senderID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
