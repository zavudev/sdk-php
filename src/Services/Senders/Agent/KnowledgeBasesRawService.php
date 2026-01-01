<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders\Agent;

use Zavudev\Client;
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
use Zavudev\ServiceContracts\Senders\Agent\KnowledgeBasesRawContract;

final class KnowledgeBasesRawService implements KnowledgeBasesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a new knowledge base for an agent.
     *
     * @param array{
     *   name: string, description?: string
     * }|KnowledgeBaseCreateParams $params
     *
     * @return BaseResponse<KnowledgeBaseNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        array|KnowledgeBaseCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = KnowledgeBaseCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/senders/%1$s/agent/knowledge-bases', $senderID],
            body: (object) $parsed,
            options: $options,
            convert: KnowledgeBaseNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get a specific knowledge base.
     *
     * @param array{senderID: string}|KnowledgeBaseRetrieveParams $params
     *
     * @return BaseResponse<KnowledgeBaseGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $kbID,
        array|KnowledgeBaseRetrieveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = KnowledgeBaseRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $senderID = $parsed['senderID'];
        unset($parsed['senderID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/senders/%1$s/agent/knowledge-bases/%2$s', $senderID, $kbID],
            options: $options,
            convert: KnowledgeBaseGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Update a knowledge base.
     *
     * @param string $kbID Path param:
     * @param array{
     *   senderID: string, description?: string|null, name?: string
     * }|KnowledgeBaseUpdateParams $params
     *
     * @return BaseResponse<KnowledgeBaseUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $kbID,
        array|KnowledgeBaseUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = KnowledgeBaseUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $senderID = $parsed['senderID'];
        unset($parsed['senderID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v1/senders/%1$s/agent/knowledge-bases/%2$s', $senderID, $kbID],
            body: (object) array_diff_key($parsed, array_flip(['senderID'])),
            options: $options,
            convert: KnowledgeBaseUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * List knowledge bases for an agent.
     *
     * @param array{cursor?: string, limit?: int}|KnowledgeBaseListParams $params
     *
     * @return BaseResponse<Cursor<AgentKnowledgeBase>>
     *
     * @throws APIException
     */
    public function list(
        string $senderID,
        array|KnowledgeBaseListParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = KnowledgeBaseListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/senders/%1$s/agent/knowledge-bases', $senderID],
            query: $parsed,
            options: $options,
            convert: AgentKnowledgeBase::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Delete a knowledge base and all its documents.
     *
     * @param array{senderID: string}|KnowledgeBaseDeleteParams $params
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $kbID,
        array|KnowledgeBaseDeleteParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = KnowledgeBaseDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $senderID = $parsed['senderID'];
        unset($parsed['senderID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/senders/%1$s/agent/knowledge-bases/%2$s', $senderID, $kbID],
            options: $options,
            convert: null,
        );
    }
}
