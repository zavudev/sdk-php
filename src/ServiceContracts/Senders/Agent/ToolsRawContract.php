<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders\Agent;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\Tools\AgentTool;
use Zavudev\Senders\Agent\Tools\ToolCreateParams;
use Zavudev\Senders\Agent\Tools\ToolDeleteParams;
use Zavudev\Senders\Agent\Tools\ToolGetResponse;
use Zavudev\Senders\Agent\Tools\ToolListParams;
use Zavudev\Senders\Agent\Tools\ToolNewResponse;
use Zavudev\Senders\Agent\Tools\ToolRetrieveParams;
use Zavudev\Senders\Agent\Tools\ToolTestParams;
use Zavudev\Senders\Agent\Tools\ToolTestResponse;
use Zavudev\Senders\Agent\Tools\ToolUpdateParams;
use Zavudev\Senders\Agent\Tools\ToolUpdateResponse;

interface ToolsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ToolCreateParams $params
     *
     * @return BaseResponse<ToolNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        array|ToolCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ToolRetrieveParams $params
     *
     * @return BaseResponse<ToolGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $toolID,
        array|ToolRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $toolID Path param:
     * @param array<string,mixed>|ToolUpdateParams $params
     *
     * @return BaseResponse<ToolUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $toolID,
        array|ToolUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ToolListParams $params
     *
     * @return BaseResponse<Cursor<AgentTool>>
     *
     * @throws APIException
     */
    public function list(
        string $senderID,
        array|ToolListParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ToolDeleteParams $params
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $toolID,
        array|ToolDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $toolID Path param:
     * @param array<string,mixed>|ToolTestParams $params
     *
     * @return BaseResponse<ToolTestResponse>
     *
     * @throws APIException
     */
    public function test(
        string $toolID,
        array|ToolTestParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
