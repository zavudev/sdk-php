<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Agents;

use Zavudev\Agents\Senders\SenderConnectResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface SendersContract
{
    /**
     * @api
     *
     * @param string $agentID agent ID
     * @param string $senderID sender to connect
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function connect(
        string $agentID,
        string $senderID,
        RequestOptions|array|null $requestOptions = null,
    ): SenderConnectResponse;

    /**
     * @api
     *
     * @param string $agentID agent ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function disconnect(
        string $senderID,
        string $agentID,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;
}
