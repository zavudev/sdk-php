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
use Zavudev\Templates\WhatsappCategory;

/**
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
        ?array $variables = null,
        WhatsappCategory|string|null $whatsappCategory = null,
        RequestOptions|array|null $requestOptions = null,
    ): Template {
        $params = Util::removeNulls(
            [
                'body' => $body,
                'language' => $language,
                'name' => $name,
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
}
