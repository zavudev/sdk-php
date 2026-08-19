<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\Senders\Telegram\TelegramConnectResponse;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface TelegramContract
{
    /**
     * @api
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
    ): TelegramConnectResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function disconnect(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): mixed;
}
