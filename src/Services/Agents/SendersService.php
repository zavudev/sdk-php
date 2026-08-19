<?php

declare(strict_types=1);

namespace Zavudev\Services\Agents;

use Zavudev\Agents\Senders\SenderConnectResponse;
use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\Agents\SendersContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class SendersService implements SendersContract
{
    /**
     * @api
     */
    public SendersRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new SendersRawService($client);
    }

    /**
     * @api
     *
     * Make the agent answer on this sender. An agent can serve several senders; a sender answers with at most one agent, so connecting one that is already in use returns `400` naming the agent that holds it.
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
    ): SenderConnectResponse {
        $params = Util::removeNulls(['senderID' => $senderID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->connect($agentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Stop the agent answering on this sender. The agent's primary sender is part of the agent itself and cannot be disconnected here.
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
    ): mixed {
        $params = Util::removeNulls(['agentID' => $agentID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->disconnect($senderID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
