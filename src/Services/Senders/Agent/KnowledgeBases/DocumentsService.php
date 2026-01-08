<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders\Agent\KnowledgeBases;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\KnowledgeBases\AgentDocument;
use Zavudev\Senders\Agent\KnowledgeBases\Documents\DocumentNewResponse;
use Zavudev\ServiceContracts\Senders\Agent\KnowledgeBases\DocumentsContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class DocumentsService implements DocumentsContract
{
    /**
     * @api
     */
    public DocumentsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new DocumentsRawService($client);
    }

    /**
     * @api
     *
     * Add a document to a knowledge base. The document will be automatically processed for RAG.
     *
     * @param string $kbID Path param:
     * @param string $senderID Path param:
     * @param string $content Body param:
     * @param string $title Body param:
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $kbID,
        string $senderID,
        string $content,
        string $title,
        RequestOptions|array|null $requestOptions = null,
    ): DocumentNewResponse {
        $params = Util::removeNulls(
            ['senderID' => $senderID, 'content' => $content, 'title' => $title]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create($kbID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List documents in a knowledge base.
     *
     * @param string $kbID Path param:
     * @param string $senderID Path param:
     * @param string $cursor Query param:
     * @param int $limit Query param:
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<AgentDocument>
     *
     * @throws APIException
     */
    public function list(
        string $kbID,
        string $senderID,
        ?string $cursor = null,
        int $limit = 50,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor {
        $params = Util::removeNulls(
            ['senderID' => $senderID, 'cursor' => $cursor, 'limit' => $limit]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($kbID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete a document from a knowledge base.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $docID,
        string $senderID,
        string $kbID,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(['senderID' => $senderID, 'kbID' => $kbID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($docID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
