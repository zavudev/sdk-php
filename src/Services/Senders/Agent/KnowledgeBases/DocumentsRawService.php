<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders\Agent\KnowledgeBases;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\KnowledgeBases\AgentDocument;
use Zavudev\Senders\Agent\KnowledgeBases\Documents\DocumentCreateParams;
use Zavudev\Senders\Agent\KnowledgeBases\Documents\DocumentDeleteParams;
use Zavudev\Senders\Agent\KnowledgeBases\Documents\DocumentListParams;
use Zavudev\Senders\Agent\KnowledgeBases\Documents\DocumentNewResponse;
use Zavudev\ServiceContracts\Senders\Agent\KnowledgeBases\DocumentsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class DocumentsRawService implements DocumentsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Add a document to a knowledge base. The document will be automatically processed for RAG.
     *
     * @param string $kbID Path param:
     * @param array{
     *   senderID: string, content: string, title: string
     * }|DocumentCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DocumentNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $kbID,
        array|DocumentCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DocumentCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $senderID = $parsed['senderID'];
        unset($parsed['senderID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/senders/%1$s/agent/knowledge-bases/%2$s/documents', $senderID, $kbID,
            ],
            body: (object) array_diff_key($parsed, array_flip(['senderID'])),
            options: $options,
            convert: DocumentNewResponse::class,
        );
    }

    /**
     * @api
     *
     * List documents in a knowledge base.
     *
     * @param string $kbID Path param:
     * @param array{
     *   senderID: string, cursor?: string, limit?: int
     * }|DocumentListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<AgentDocument>>
     *
     * @throws APIException
     */
    public function list(
        string $kbID,
        array|DocumentListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DocumentListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $senderID = $parsed['senderID'];
        unset($parsed['senderID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/senders/%1$s/agent/knowledge-bases/%2$s/documents', $senderID, $kbID,
            ],
            query: $parsed,
            options: $options,
            convert: AgentDocument::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Delete a document from a knowledge base.
     *
     * @param array{senderID: string, kbID: string}|DocumentDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $docID,
        array|DocumentDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = DocumentDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $senderID = $parsed['senderID'];
        unset($parsed['senderID']);
        $kbID = $parsed['kbID'];
        unset($parsed['kbID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: [
                'v1/senders/%1$s/agent/knowledge-bases/%2$s/documents/%3$s',
                $senderID,
                $kbID,
                $docID,
            ],
            options: $options,
            convert: null,
        );
    }
}
