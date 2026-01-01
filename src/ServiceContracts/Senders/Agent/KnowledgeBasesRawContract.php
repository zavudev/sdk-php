<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders\Agent;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\KnowledgeBases\AgentKnowledgeBase;
use Zavudev\Senders\Agent\KnowledgeBases\KnowledgeBaseCreateParams;
use Zavudev\Senders\Agent\KnowledgeBases\KnowledgeBaseDeleteParams;
use Zavudev\Senders\Agent\KnowledgeBases\KnowledgeBaseGetResponse;
use Zavudev\Senders\Agent\KnowledgeBases\KnowledgeBaseListParams;
use Zavudev\Senders\Agent\KnowledgeBases\KnowledgeBaseNewResponse;
use Zavudev\Senders\Agent\KnowledgeBases\KnowledgeBaseRetrieveParams;
use Zavudev\Senders\Agent\KnowledgeBases\KnowledgeBaseUpdateParams;
use Zavudev\Senders\Agent\KnowledgeBases\KnowledgeBaseUpdateResponse;

interface KnowledgeBasesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|KnowledgeBaseCreateParams $params
     *
     * @return BaseResponse<KnowledgeBaseNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        array|KnowledgeBaseCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|KnowledgeBaseRetrieveParams $params
     *
     * @return BaseResponse<KnowledgeBaseGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $kbID,
        array|KnowledgeBaseRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $kbID Path param:
     * @param array<string,mixed>|KnowledgeBaseUpdateParams $params
     *
     * @return BaseResponse<KnowledgeBaseUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $kbID,
        array|KnowledgeBaseUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|KnowledgeBaseListParams $params
     *
     * @return BaseResponse<Cursor<AgentKnowledgeBase>>
     *
     * @throws APIException
     */
    public function list(
        string $senderID,
        array|KnowledgeBaseListParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|KnowledgeBaseDeleteParams $params
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $kbID,
        array|KnowledgeBaseDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
