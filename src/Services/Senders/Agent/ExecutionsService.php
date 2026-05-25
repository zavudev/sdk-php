<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders\Agent;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\AgentExecution;
use Zavudev\Senders\Agent\AgentExecutionStatus;
use Zavudev\Senders\Agent\Executions\ExecutionGetResponse;
use Zavudev\ServiceContracts\Senders\Agent\ExecutionsContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class ExecutionsService implements ExecutionsContract
{
    /**
     * @api
     */
    public ExecutionsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ExecutionsRawService($client);
    }

    /**
     * @api
     *
     * Fetch full details for one execution — including `errorMessage`, `errorCode`, and `responseText`. Use this to debug failures surfaced by the list endpoint.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $executionID,
        string $senderID,
        RequestOptions|array|null $requestOptions = null,
    ): ExecutionGetResponse {
        $params = Util::removeNulls(['senderID' => $senderID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($executionID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List recent agent executions with pagination.
     *
     * @param AgentExecutionStatus|value-of<AgentExecutionStatus> $status status of an agent execution
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<AgentExecution>
     *
     * @throws APIException
     */
    public function list(
        string $senderID,
        ?string $cursor = null,
        int $limit = 50,
        AgentExecutionStatus|string|null $status = null,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor {
        $params = Util::removeNulls(
            ['cursor' => $cursor, 'limit' => $limit, 'status' => $status]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($senderID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
