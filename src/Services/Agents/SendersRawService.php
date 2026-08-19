<?php

declare(strict_types=1);

namespace Zavudev\Services\Agents;

use Zavudev\Agents\Senders\SenderConnectParams;
use Zavudev\Agents\Senders\SenderConnectResponse;
use Zavudev\Agents\Senders\SenderDisconnectParams;
use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\Agents\SendersRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class SendersRawService implements SendersRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Make the agent answer on this sender. An agent can serve several senders; a sender answers with at most one agent, so connecting one that is already in use returns `400` naming the agent that holds it.
     *
     * @param string $agentID agent ID
     * @param array{senderID: string}|SenderConnectParams $params
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
    ): BaseResponse {
        [$parsed, $options] = SenderConnectParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/agents/%1$s/senders', $agentID],
            body: (object) $parsed,
            options: $options,
            convert: SenderConnectResponse::class,
        );
    }

    /**
     * @api
     *
     * Stop the agent answering on this sender. The agent's primary sender is part of the agent itself and cannot be disconnected here.
     *
     * @param array{agentID: string}|SenderDisconnectParams $params
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
    ): BaseResponse {
        [$parsed, $options] = SenderDisconnectParams::parseRequest(
            $params,
            $requestOptions,
        );
        $agentID = $parsed['agentID'];
        unset($parsed['agentID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/agents/%1$s/senders/%2$s', $agentID, $senderID],
            options: $options,
            convert: null,
        );
    }
}
