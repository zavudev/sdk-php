<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Agents;

use Zavudev\Agents\Senders\SenderConnectParams;
use Zavudev\Agents\Senders\SenderConnectResponse;
use Zavudev\Agents\Senders\SenderDisconnectParams;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface SendersRawContract
{
    /**
     * @api
     *
     * @param string $agentID agent ID
     * @param array<string,mixed>|SenderConnectParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SenderConnectResponse>
     *
     * @throws APIException
     */
    public function connect(
        string $agentID,
        array|SenderConnectParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SenderDisconnectParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function disconnect(
        string $senderID,
        array|SenderDisconnectParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
