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

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface KnowledgeBasesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|KnowledgeBaseCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<KnowledgeBaseNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        array|KnowledgeBaseCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|KnowledgeBaseRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<KnowledgeBaseGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $kbID,
        array|KnowledgeBaseRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $kbID Path param
     * @param array<string,mixed>|KnowledgeBaseUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<KnowledgeBaseUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $kbID,
        array|KnowledgeBaseUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|KnowledgeBaseListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<AgentKnowledgeBase>>
     *
     * @throws APIException
     */
    public function list(
        string $senderID,
        array|KnowledgeBaseListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|KnowledgeBaseDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $kbID,
        array|KnowledgeBaseDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
