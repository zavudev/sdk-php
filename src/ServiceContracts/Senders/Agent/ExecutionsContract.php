<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders\Agent;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\AgentExecution;
use Zavudev\Senders\Agent\AgentExecutionStatus;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface ExecutionsContract
{
    /**
     * @api
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
    ): Cursor;
}
