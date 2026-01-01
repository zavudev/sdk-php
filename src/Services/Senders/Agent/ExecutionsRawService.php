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
use Zavudev\Senders\Agent\Executions\ExecutionListParams;
use Zavudev\ServiceContracts\Senders\Agent\ExecutionsRawContract;

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
     * List recent agent executions with pagination.
     *
     * @param array{
     *   cursor?: string,
     *   limit?: int,
     *   status?: 'success'|'error'|'filtered'|'rate_limited'|'balance_insufficient'|AgentExecutionStatus,
     * }|ExecutionListParams $params
     *
     * @return BaseResponse<Cursor<AgentExecution>>
     *
     * @throws APIException
     */
    public function list(
        string $senderID,
        array|ExecutionListParams $params,
        ?RequestOptions $requestOptions = null,
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
