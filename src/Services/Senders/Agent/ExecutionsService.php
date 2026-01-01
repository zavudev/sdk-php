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
use Zavudev\ServiceContracts\Senders\Agent\ExecutionsContract;

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
     * List recent agent executions with pagination.
     *
     * @param 'success'|'error'|'filtered'|'rate_limited'|'balance_insufficient'|AgentExecutionStatus $status status of an agent execution
     *
     * @return Cursor<AgentExecution>
     *
     * @throws APIException
     */
    public function list(
        string $senderID,
        ?string $cursor = null,
        int $limit = 50,
        string|AgentExecutionStatus|null $status = null,
        ?RequestOptions $requestOptions = null,
    ): Cursor {
        $params = Util::removeNulls(
            ['cursor' => $cursor, 'limit' => $limit, 'status' => $status]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($senderID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
