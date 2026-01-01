<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RegulatoryDocuments\RegulatoryDocument;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentCreateParams\DocumentType;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentGetResponse;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentNewResponse;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentUploadURLResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\RegulatoryDocumentsContract;

final class RegulatoryDocumentsService implements RegulatoryDocumentsContract
{
    /**
     * @api
     */
    public RegulatoryDocumentsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new RegulatoryDocumentsRawService($client);
    }

    /**
     * @api
     *
     * Create a regulatory document record after uploading the file. Use the upload-url endpoint first to get an upload URL.
     *
     * @param 'passport'|'national_id'|'drivers_license'|'utility_bill'|'tax_id'|'business_registration'|'proof_of_address'|'other'|DocumentType $documentType
     * @param string $storageID storage ID from the upload-url endpoint
     *
     * @throws APIException
     */
    public function create(
        string|DocumentType $documentType,
        int $fileSize,
        string $mimeType,
        string $name,
        string $storageID,
        ?RequestOptions $requestOptions = null,
    ): RegulatoryDocumentNewResponse {
        $params = Util::removeNulls(
            [
                'documentType' => $documentType,
                'fileSize' => $fileSize,
                'mimeType' => $mimeType,
                'name' => $name,
                'storageID' => $storageID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get a specific regulatory document.
     *
     * @throws APIException
     */
    public function retrieve(
        string $documentID,
        ?RequestOptions $requestOptions = null
    ): RegulatoryDocumentGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($documentID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List regulatory documents for this project.
     *
     * @return Cursor<RegulatoryDocument>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        ?RequestOptions $requestOptions = null,
    ): Cursor {
        $params = Util::removeNulls(['cursor' => $cursor, 'limit' => $limit]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete a regulatory document. Cannot delete verified documents.
     *
     * @throws APIException
     */
    public function delete(
        string $documentID,
        ?RequestOptions $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($documentID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get a presigned URL to upload a document file. After uploading, use the storageId to create the document record.
     *
     * @throws APIException
     */
    public function uploadURL(
        ?RequestOptions $requestOptions = null
    ): RegulatoryDocumentUploadURLResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->uploadURL(requestOptions: $requestOptions);

        return $response->parse();
    }
}
