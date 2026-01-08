<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RegulatoryDocuments\RegulatoryDocument;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentCreateParams\DocumentType;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentGetResponse;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentNewResponse;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentUploadURLResponse;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface RegulatoryDocumentsContract
{
    /**
     * @api
     *
     * @param DocumentType|value-of<DocumentType> $documentType
     * @param string $storageID storage ID from the upload-url endpoint
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        DocumentType|string $documentType,
        int $fileSize,
        string $mimeType,
        string $name,
        string $storageID,
        RequestOptions|array|null $requestOptions = null,
    ): RegulatoryDocumentNewResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $documentID,
        RequestOptions|array|null $requestOptions = null
    ): RegulatoryDocumentGetResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<RegulatoryDocument>
     *
     * @throws APIException
     */
    public function list(
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
        string $documentID,
        RequestOptions|array|null $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function uploadURL(
        RequestOptions|array|null $requestOptions = null
    ): RegulatoryDocumentUploadURLResponse;
}
