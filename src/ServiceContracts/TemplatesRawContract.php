<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Templates\Template;
use Zavudev\Templates\TemplateCreateParams;
use Zavudev\Templates\TemplateListParams;
use Zavudev\Templates\TemplateSubmitParams;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface TemplatesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|TemplateCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Template>
     *
     * @throws APIException
     */
    public function create(
        array|TemplateCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Template>
     *
     * @throws APIException
     */
    public function retrieve(
        string $templateID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|TemplateListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<Template>>
     *
     * @throws APIException
     */
    public function list(
        array|TemplateListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $templateID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|TemplateSubmitParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Template>
     *
     * @throws APIException
     */
    public function submit(
        string $templateID,
        array|TemplateSubmitParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
