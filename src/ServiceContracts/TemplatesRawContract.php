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

interface TemplatesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|TemplateCreateParams $params
     *
     * @return BaseResponse<Template>
     *
     * @throws APIException
     */
    public function create(
        array|TemplateCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<Template>
     *
     * @throws APIException
     */
    public function retrieve(
        string $templateID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|TemplateListParams $params
     *
     * @return BaseResponse<Cursor<Template>>
     *
     * @throws APIException
     */
    public function list(
        array|TemplateListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $templateID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|TemplateSubmitParams $params
     *
     * @return BaseResponse<Template>
     *
     * @throws APIException
     */
    public function submit(
        string $templateID,
        array|TemplateSubmitParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
