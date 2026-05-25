<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders\Agent;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\AgentExecution;
use Zavudev\Senders\Agent\Executions\ExecutionGetResponse;
use Zavudev\Senders\Agent\Executions\ExecutionListParams;
use Zavudev\Senders\Agent\Executions\ExecutionRetrieveParams;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface ExecutionsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ExecutionRetrieveParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ExecutionListParams $params
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
    ): BaseResponse;
}
