<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Templates\Template;
use Zavudev\Templates\WhatsappCategory;

interface TemplatesContract
{
    /**
     * @api
     *
     * @param list<string> $variables
     * @param 'UTILITY'|'MARKETING'|'AUTHENTICATION'|WhatsappCategory $whatsappCategory whatsApp template category
     *
     * @throws APIException
     */
    public function create(
        string $body,
        string $name,
        string $language = 'en',
        ?array $variables = null,
        string|WhatsappCategory|null $whatsappCategory = null,
        ?RequestOptions $requestOptions = null,
    ): Template;

    /**
     * @api
     *
     * @throws APIException
     */
    public function retrieve(
        string $templateID,
        ?RequestOptions $requestOptions = null
    ): Template;

    /**
     * @api
     *
     * @return Cursor<Template>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        ?RequestOptions $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @throws APIException
     */
    public function delete(
        string $templateID,
        ?RequestOptions $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param string $senderID the sender ID with the WhatsApp Business Account to submit the template to
     * @param 'UTILITY'|'MARKETING'|'AUTHENTICATION'|WhatsappCategory $category Template category. If not provided, uses the category set on the template.
     *
     * @throws APIException
     */
    public function submit(
        string $templateID,
        string $senderID,
        string|WhatsappCategory|null $category = null,
        ?RequestOptions $requestOptions = null,
    ): Template;
}
