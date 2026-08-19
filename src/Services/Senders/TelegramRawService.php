<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\Senders\Telegram\TelegramConnectParams;
use Zavudev\Senders\Telegram\TelegramConnectResponse;
use Zavudev\ServiceContracts\Senders\TelegramRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class TelegramRawService implements TelegramRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Connect a Telegram bot to a sender. Provide the bot token from @BotFather; Zavu validates it, registers the webhook, and routes the sender's Telegram messages through it.
     *
     * @param array{botToken: string}|TelegramConnectParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TelegramConnectResponse>
     *
     * @throws APIException
     */
    public function connect(
        string $senderID,
        array|TelegramConnectParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TelegramConnectParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/senders/%1$s/telegram', $senderID],
            body: (object) $parsed,
            options: $options,
            convert: TelegramConnectResponse::class,
        );
    }

    /**
     * @api
     *
     * Disconnect Telegram from a sender and remove the webhook.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function disconnect(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/senders/%1$s/telegram', $senderID],
            options: $requestOptions,
            convert: null,
        );
    }
}
