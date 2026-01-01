<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\AgentCreateParams;
use Zavudev\Senders\Agent\AgentResponse;
use Zavudev\Senders\Agent\AgentStats;
use Zavudev\Senders\Agent\AgentUpdateParams;

interface AgentRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|AgentCreateParams $params
     *
     * @return BaseResponse<AgentResponse>
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        array|AgentCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<AgentResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|AgentUpdateParams $params
     *
     * @return BaseResponse<AgentResponse>
     *
     * @throws APIException
     */
    public function update(
        string $senderID,
        array|AgentUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<AgentStats>
     *
     * @throws APIException
     */
    public function stats(
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
