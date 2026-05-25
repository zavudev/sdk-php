<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders\Agent;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\AgentExecution;
use Zavudev\Senders\Agent\AgentExecutionStatus;
use Zavudev\Senders\Agent\Executions\ExecutionGetResponse;
use Zavudev\Senders\Agent\Executions\ExecutionListParams;
use Zavudev\Senders\Agent\Executions\ExecutionRetrieveParams;
use Zavudev\ServiceContracts\Senders\Agent\ExecutionsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class ExecutionsRawService implements ExecutionsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Fetch full details for one execution — including `errorMessage`, `errorCode`, and `responseText`. Use this to debug failures surfaced by the list endpoint.
     *
     * @param array{senderID: string}|ExecutionRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ExecutionGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $executionID,
        array|ExecutionRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExecutionRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $senderID = $parsed['senderID'];
        unset($parsed['senderID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/senders/%1$s/agent/executions/%2$s', $senderID, $executionID],
            options: $options,
            convert: ExecutionGetResponse::class,
        );
    }

    /**
     * @api
     *
     * List recent agent executions with pagination.
     *
     * @param array{
     *   cursor?: string,
     *   limit?: int,
     *   status?: AgentExecutionStatus|value-of<AgentExecutionStatus>,
     * }|ExecutionListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<AgentExecution>>
     *
     * @throws APIException
     */
    public function list(
        string $senderID,
        array|ExecutionListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ExecutionListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/senders/%1$s/agent/executions', $senderID],
            query: $parsed,
            options: $options,
            convert: AgentExecution::class,
            page: Cursor::class,
        );
    }
}
