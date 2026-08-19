<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders\Agent\KnowledgeBases;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\KnowledgeBases\AgentDocument;
use Zavudev\Senders\Agent\KnowledgeBases\Documents\DocumentGetDocumentResponse;
use Zavudev\Senders\Agent\KnowledgeBases\Documents\DocumentNewResponse;
use Zavudev\Senders\Agent\KnowledgeBases\Documents\DocumentUpdateDocumentResponse;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface DocumentsContract
{
    /**
     * @api
     *
     * @param string $kbID Path param
     * @param string $senderID Path param
     * @param string $content Body param
     * @param string $title Body param
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
    ): DocumentNewResponse;

    /**
     * @api
     *
     * @param string $kbID Path param
     * @param string $senderID Path param
     * @param string $cursor Query param
     * @param int $limit Query param
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
    ): Cursor;

    /**
     * @api
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
    ): mixed;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveDocument(
        string $docID,
        string $senderID,
        string $kbID,
        RequestOptions|array|null $requestOptions = null,
    ): DocumentGetDocumentResponse;

    /**
     * @api
     *
     * @param string $docID Path param
     * @param string $senderID Path param
     * @param string $kbID Path param
     * @param string $content Body param
     * @param string $title Body param
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function updateDocument(
        string $docID,
        string $senderID,
        string $kbID,
        ?string $content = null,
        ?string $title = null,
        RequestOptions|array|null $requestOptions = null,
    ): DocumentUpdateDocumentResponse;
}
