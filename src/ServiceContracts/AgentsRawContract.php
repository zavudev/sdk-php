<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Agents\AgentCreateParams;
use Zavudev\Agents\AgentGetResponse;
use Zavudev\Agents\AgentListParams;
use Zavudev\Agents\AgentListVoicesParams;
use Zavudev\Agents\AgentListVoicesResponse;
use Zavudev\Agents\AgentNewResponse;
use Zavudev\Agents\AgentTestParams;
use Zavudev\Agents\AgentTestResponse;
use Zavudev\Agents\AgentUpdateParams;
use Zavudev\Agents\AgentUpdateResponse;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\Agent;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface AgentsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|AgentCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AgentNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|AgentCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $agentID agent ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AgentGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $agentID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $agentID agent ID
     * @param array<string,mixed>|AgentUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AgentUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $agentID,
        array|AgentUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|AgentListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<Agent>>
     *
     * @throws APIException
     */
    public function list(
        array|AgentListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $agentID agent ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $agentID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|AgentListVoicesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AgentListVoicesResponse>
     *
     * @throws APIException
     */
    public function listVoices(
        array|AgentListVoicesParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $agentID agent ID
     * @param array<string,mixed>|AgentTestParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AgentTestResponse>
     *
     * @throws APIException
     */
    public function test(
        string $agentID,
        array|AgentTestParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
