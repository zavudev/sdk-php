<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\Senders\Telegram\TelegramConnectParams;
use Zavudev\Senders\Telegram\TelegramConnectResponse;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface TelegramRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|TelegramConnectParams $params
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
    ): BaseResponse;

    /**
     * @api
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
    ): BaseResponse;
}
