<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders\Agent\KnowledgeBases;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\KnowledgeBases\AgentDocument;
use Zavudev\Senders\Agent\KnowledgeBases\Documents\DocumentCreateParams;
use Zavudev\Senders\Agent\KnowledgeBases\Documents\DocumentDeleteParams;
use Zavudev\Senders\Agent\KnowledgeBases\Documents\DocumentListParams;
use Zavudev\Senders\Agent\KnowledgeBases\Documents\DocumentNewResponse;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface DocumentsRawContract
{
    /**
     * @api
     *
     * @param string $kbID Path param
     * @param array<string,mixed>|DocumentCreateParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $kbID Path param
     * @param array<string,mixed>|DocumentListParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|DocumentDeleteParams $params
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
    ): BaseResponse;
}
