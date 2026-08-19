<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\TemplatesContract;
use Zavudev\Templates\Template;
use Zavudev\Templates\TemplateCreateParams\Button;
use Zavudev\Templates\TemplateCreateParams\HeaderType;
use Zavudev\Templates\TemplateSyncResponse;
use Zavudev\Templates\WhatsappCategory;

/**
 * @phpstan-import-type ButtonShape from \Zavudev\Templates\TemplateCreateParams\Button
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class TemplatesService implements TemplatesContract
{
    /**
     * @api
     */
    public TemplatesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new TemplatesRawService($client);
    }

    /**
     * @api
     *
     * Create a WhatsApp message template. Note: Templates must be approved by Meta before use.
     *
     * @param string $body Default template body. Used when no channel-specific body is set.
     * @param bool $addSecurityRecommendation Add 'Do not share this code' disclaimer. Only for AUTHENTICATION templates.
     * @param list<Button|ButtonShape> $buttons template buttons (max 3)
     * @param int $codeExpirationMinutes Code expiration time in minutes. Only for AUTHENTICATION templates.
     * @param string $footer footer text for the template
     * @param string $headerContent header content (text string or media URL)
     * @param HeaderType|value-of<HeaderType> $headerType type of header for the template
     * @param string $instagramBody Channel-specific body for Instagram. Falls back to `body` if not set.
     * @param string $smsBody Channel-specific body for SMS. Falls back to `body` if not set.
     * @param string $telegramBody Channel-specific body for Telegram. Falls back to `body` if not set.
     * @param list<string> $variables
     * @param WhatsappCategory|value-of<WhatsappCategory> $whatsappCategory whatsApp template category
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $body,
        string $name,
        string $language = 'en',
        ?bool $addSecurityRecommendation = null,
        ?array $buttons = null,
        ?int $codeExpirationMinutes = null,
        ?string $footer = null,
        ?string $headerContent = null,
        HeaderType|string|null $headerType = null,
        ?string $instagramBody = null,
        ?string $smsBody = null,
        ?string $telegramBody = null,
        ?array $variables = null,
        WhatsappCategory|string|null $whatsappCategory = null,
        RequestOptions|array|null $requestOptions = null,
    ): Template {
        $params = Util::removeNulls(
            [
                'body' => $body,
                'language' => $language,
                'name' => $name,
                'addSecurityRecommendation' => $addSecurityRecommendation,
                'buttons' => $buttons,
                'codeExpirationMinutes' => $codeExpirationMinutes,
                'footer' => $footer,
                'headerContent' => $headerContent,
                'headerType' => $headerType,
                'instagramBody' => $instagramBody,
                'smsBody' => $smsBody,
                'telegramBody' => $telegramBody,
                'variables' => $variables,
                'whatsappCategory' => $whatsappCategory,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get template
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $templateID,
        RequestOptions|array|null $requestOptions = null
    ): Template {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($templateID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List WhatsApp message templates for this project.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<Template>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor {
        $params = Util::removeNulls(['cursor' => $cursor, 'limit' => $limit]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete template
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $templateID,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($templateID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Submit a WhatsApp template to Meta for approval. The template must be in draft status and associated with a sender that has a WhatsApp Business Account configured.
     *
     * @param string $senderID the sender ID with the WhatsApp Business Account to submit the template to
     * @param WhatsappCategory|value-of<WhatsappCategory> $category Template category. If not provided, uses the category set on the template.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function submit(
        string $templateID,
        string $senderID,
        WhatsappCategory|string|null $category = null,
        RequestOptions|array|null $requestOptions = null,
    ): Template {
        $params = Util::removeNulls(
            ['senderID' => $senderID, 'category' => $category]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->submit($templateID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @param string $senderID Sync only the WhatsApp Business Account attached to this sender. If omitted, every WhatsApp sender in the project is synced.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function sync(
        ?string $senderID = null,
        RequestOptions|array|null $requestOptions = null
    ): TemplateSyncResponse {
        $params = Util::removeNulls(['senderID' => $senderID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->sync(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
