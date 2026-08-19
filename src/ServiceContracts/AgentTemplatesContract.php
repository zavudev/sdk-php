<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\AgentTemplates\AgentTemplateGetResponse;
use Zavudev\AgentTemplates\AgentTemplateListResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface AgentTemplatesContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $templateID,
        RequestOptions|array|null $requestOptions = null
    ): AgentTemplateGetResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): AgentTemplateListResponse;
}
