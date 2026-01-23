<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RegulatoryDocuments\RegulatoryDocument;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentCreateParams;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentCreateParams\DocumentType;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentGetResponse;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentListParams;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentNewResponse;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentUploadURLResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\RegulatoryDocumentsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class RegulatoryDocumentsRawService implements RegulatoryDocumentsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a regulatory document record after uploading the file. Use the upload-url endpoint first to get an upload URL.
     *
     * @param array{
     *   documentType: value-of<DocumentType>,
     *   fileSize: int,
     *   mimeType: string,
     *   name: string,
     *   storageID: string,
     * }|RegulatoryDocumentCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RegulatoryDocumentNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|RegulatoryDocumentCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RegulatoryDocumentCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/documents',
            body: (object) $parsed,
            options: $options,
            convert: RegulatoryDocumentNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get a specific regulatory document.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RegulatoryDocumentGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $documentID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/documents/%1$s', $documentID],
            options: $requestOptions,
            convert: RegulatoryDocumentGetResponse::class,
        );
    }

    /**
     * @api
     *
     * List regulatory documents for this project.
     *
     * @param array{cursor?: string, limit?: int}|RegulatoryDocumentListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<RegulatoryDocument>>
     *
     * @throws APIException
     */
    public function list(
        array|RegulatoryDocumentListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RegulatoryDocumentListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/documents',
            query: $parsed,
            options: $options,
            convert: RegulatoryDocument::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Delete a regulatory document. Cannot delete verified documents.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $documentID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/documents/%1$s', $documentID],
            options: $requestOptions,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Get a presigned URL to upload a document file. After uploading, use the storageId to create the document record.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<RegulatoryDocumentUploadURLResponse>
     *
     * @throws APIException
     */
    public function uploadURL(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/documents/upload-url',
            options: $requestOptions,
            convert: RegulatoryDocumentUploadURLResponse::class,
        );
    }
}
