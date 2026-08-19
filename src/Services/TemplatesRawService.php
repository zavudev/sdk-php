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
use Zavudev\Templates\TemplateCreateParams\HeaderType;
use Zavudev\Templates\TemplateListParams;
use Zavudev\Templates\TemplateSubmitParams;
use Zavudev\Templates\TemplateSyncParams;
use Zavudev\Templates\TemplateSyncResponse;
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
     *   footer?: string,
     *   headerContent?: string,
     *   headerType?: HeaderType|value-of<HeaderType>,
     *   instagramBody?: string,
     *   smsBody?: string,
     *   telegramBody?: string,
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

    /**
     * @api
     *
     * Reconcile this project's templates against WhatsApp. Two things happen per connected WhatsApp Business Account: templates that exist on Meta but not in Zavu are imported (or linked to an existing template with the same name), and the approval status of the templates Zavu already knows about is refreshed from Meta.
     *
     * This is what to call when a template was created outside Zavu — in Meta Business Manager, or by another tool — or when a `template.status_changed` webhook was missed and a template is stuck in `pending`. Status changes normally arrive by webhook; this endpoint is the recovery path and the only path for a template Zavu never created.
     *
     * Templates that Meta reports as rejected or disabled are not imported; they are counted in `skipped`. Existing local templates are matched first by Meta template ID, then by name.
     *
     * By default every sender in the project with a WhatsApp Business Account is synced. Pass `senderId` to sync only that sender's account. The call is synchronous — it waits for Meta and returns what changed — so it can take a few seconds per account. A failure on one account does not fail the request: it is reported in `errors` and the remaining accounts are still synced.
     *
     * @param array{senderID?: string}|TemplateSyncParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TemplateSyncResponse>
     *
     * @throws APIException
     */
    public function sync(
        array|TemplateSyncParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TemplateSyncParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/templates/sync',
            body: (object) $parsed,
            options: $options,
            convert: TemplateSyncResponse::class,
        );
    }
}
