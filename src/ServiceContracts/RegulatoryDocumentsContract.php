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

interface RegulatoryDocumentsContract
{
    /**
     * @api
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
    ): RegulatoryDocumentNewResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function retrieve(
        string $documentID,
        ?RequestOptions $requestOptions = null
    ): RegulatoryDocumentGetResponse;

    /**
     * @api
     *
     * @return Cursor<RegulatoryDocument>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        ?RequestOptions $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @throws APIException
     */
    public function delete(
        string $documentID,
        ?RequestOptions $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @throws APIException
     */
    public function uploadURL(
        ?RequestOptions $requestOptions = null
    ): RegulatoryDocumentUploadURLResponse;
}
