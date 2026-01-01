<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders\Agent;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\Flows\AgentFlow;
use Zavudev\Senders\Agent\Flows\FlowCreateParams;
use Zavudev\Senders\Agent\Flows\FlowDeleteParams;
use Zavudev\Senders\Agent\Flows\FlowDuplicateParams;
use Zavudev\Senders\Agent\Flows\FlowDuplicateResponse;
use Zavudev\Senders\Agent\Flows\FlowGetResponse;
use Zavudev\Senders\Agent\Flows\FlowListParams;
use Zavudev\Senders\Agent\Flows\FlowNewResponse;
use Zavudev\Senders\Agent\Flows\FlowRetrieveParams;
use Zavudev\Senders\Agent\Flows\FlowUpdateParams;
use Zavudev\Senders\Agent\Flows\FlowUpdateResponse;

interface FlowsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|FlowCreateParams $params
     *
     * @return BaseResponse<FlowNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        array|FlowCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|FlowRetrieveParams $params
     *
     * @return BaseResponse<FlowGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $flowID,
        array|FlowRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $flowID Path param:
     * @param array<string,mixed>|FlowUpdateParams $params
     *
     * @return BaseResponse<FlowUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $flowID,
        array|FlowUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|FlowListParams $params
     *
     * @return BaseResponse<Cursor<AgentFlow>>
     *
     * @throws APIException
     */
    public function list(
        string $senderID,
        array|FlowListParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|FlowDeleteParams $params
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $flowID,
        array|FlowDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $flowID Path param:
     * @param array<string,mixed>|FlowDuplicateParams $params
     *
     * @return BaseResponse<FlowDuplicateResponse>
     *
     * @throws APIException
     */
    public function duplicate(
        string $flowID,
        array|FlowDuplicateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
