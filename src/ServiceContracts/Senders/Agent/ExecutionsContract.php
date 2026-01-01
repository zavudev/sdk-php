<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders\Agent;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\AgentExecution;
use Zavudev\Senders\Agent\AgentExecutionStatus;

interface ExecutionsContract
{
    /**
     * @api
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
    ): Cursor;
}
