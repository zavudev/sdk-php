<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\TemplatesRawContract;
use Zavudev\Templates\Template;
use Zavudev\Templates\TemplateCreateParams;
use Zavudev\Templates\TemplateListParams;
use Zavudev\Templates\TemplateSubmitParams;
use Zavudev\Templates\WhatsappCategory;

final class TemplatesRawService implements TemplatesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a WhatsApp message template. Note: Templates must be approved by Meta before use.
     *
     * @param array{
     *   body: string,
     *   language: string,
     *   name: string,
     *   variables?: list<string>,
     *   whatsappCategory?: 'UTILITY'|'MARKETING'|'AUTHENTICATION'|WhatsappCategory,
     * }|TemplateCreateParams $params
     *
     * @return BaseResponse<Template>
     *
     * @throws APIException
     */
    public function create(
        array|TemplateCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = TemplateCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/templates',
            body: (object) $parsed,
            options: $options,
            convert: Template::class,
        );
    }

    /**
     * @api
     *
     * Get template
     *
     * @return BaseResponse<Template>
     *
     * @throws APIException
     */
    public function retrieve(
        string $templateID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/templates/%1$s', $templateID],
            options: $requestOptions,
            convert: Template::class,
        );
    }

    /**
     * @api
     *
     * List WhatsApp message templates for this project.
     *
     * @param array{cursor?: string, limit?: int}|TemplateListParams $params
     *
     * @return BaseResponse<Cursor<Template>>
     *
     * @throws APIException
     */
    public function list(
        array|TemplateListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        [$parsed, $options] = TemplateListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/templates',
            query: $parsed,
            options: $options,
            convert: Template::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Delete template
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $templateID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/templates/%1$s', $templateID],
            options: $requestOptions,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Submit a WhatsApp template to Meta for approval. The template must be in draft status and associated with a sender that has a WhatsApp Business Account configured.
     *
     * @param array{
     *   senderID: string,
     *   category?: 'UTILITY'|'MARKETING'|'AUTHENTICATION'|WhatsappCategory,
     * }|TemplateSubmitParams $params
     *
     * @return BaseResponse<Template>
     *
     * @throws APIException
     */
    public function submit(
        string $templateID,
        array|TemplateSubmitParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TemplateSubmitParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/templates/%1$s/submit', $templateID],
            body: (object) $parsed,
            options: $options,
            convert: Template::class,
        );
    }
}
