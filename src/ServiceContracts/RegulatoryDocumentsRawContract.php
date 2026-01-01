<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RegulatoryDocuments\RegulatoryDocument;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentCreateParams;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentGetResponse;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentListParams;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentNewResponse;
use Zavudev\RegulatoryDocuments\RegulatoryDocumentUploadURLResponse;
use Zavudev\RequestOptions;

interface RegulatoryDocumentsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|RegulatoryDocumentCreateParams $params
     *
     * @return BaseResponse<RegulatoryDocumentNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|RegulatoryDocumentCreateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<RegulatoryDocumentGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $documentID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|RegulatoryDocumentListParams $params
     *
     * @return BaseResponse<Cursor<RegulatoryDocument>>
     *
     * @throws APIException
     */
    public function list(
        array|RegulatoryDocumentListParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $documentID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<RegulatoryDocumentUploadURLResponse>
     *
     * @throws APIException
     */
    public function uploadURL(
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
