<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Templates\Template;
use Zavudev\Templates\TemplateCreateParams\Button;
use Zavudev\Templates\WhatsappCategory;

/**
 * @phpstan-import-type ButtonShape from \Zavudev\Templates\TemplateCreateParams\Button
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface TemplatesContract
{
    /**
     * @api
     *
     * @param string $body Default template body. Used when no channel-specific body is set.
     * @param bool $addSecurityRecommendation Add 'Do not share this code' disclaimer. Only for AUTHENTICATION templates.
     * @param list<Button|ButtonShape> $buttons template buttons (max 3)
     * @param int $codeExpirationMinutes Code expiration time in minutes. Only for AUTHENTICATION templates.
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
        ?string $instagramBody = null,
        ?string $smsBody = null,
        ?string $telegramBody = null,
        ?array $variables = null,
        WhatsappCategory|string|null $whatsappCategory = null,
        RequestOptions|array|null $requestOptions = null,
    ): Template;

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
    ): Template;

    /**
     * @api
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
    ): Cursor;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $templateID,
        RequestOptions|array|null $requestOptions = null
    ): mixed;

    /**
     * @api
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
    ): Template;
}
