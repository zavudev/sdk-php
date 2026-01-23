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
use Zavudev\Templates\TemplateCreateParams\Button;
use Zavudev\Templates\TemplateListParams;
use Zavudev\Templates\TemplateSubmitParams;
use Zavudev\Templates\WhatsappCategory;

/**
 * @phpstan-import-type ButtonShape from \Zavudev\Templates\TemplateCreateParams\Button
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
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
     *   addSecurityRecommendation?: bool,
     *   buttons?: list<Button|ButtonShape>,
     *   codeExpirationMinutes?: int,
     *   variables?: list<string>,
     *   whatsappCategory?: WhatsappCategory|value-of<WhatsappCategory>,
     * }|TemplateCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Template>
     *
     * @throws APIException
     */
    public function create(
        array|TemplateCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Template>
     *
     * @throws APIException
     */
    public function retrieve(
        string $templateID,
        RequestOptions|array|null $requestOptions = null
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<Template>>
     *
     * @throws APIException
     */
    public function list(
        array|TemplateListParams $params,
        RequestOptions|array|null $requestOptions = null,
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
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $templateID,
        RequestOptions|array|null $requestOptions = null
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
     *   senderID: string, category?: WhatsappCategory|value-of<WhatsappCategory>
     * }|TemplateSubmitParams $params
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
