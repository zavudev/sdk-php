<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\AgentTemplates\AgentTemplateGetResponse;
use Zavudev\AgentTemplates\AgentTemplateListResponse;
use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\AgentTemplatesContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class AgentTemplatesService implements AgentTemplatesContract
{
    /**
     * @api
     */
    public AgentTemplatesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AgentTemplatesRawService($client);
    }

    /**
     * @api
     *
     * Fetch a single factory agent fully rendered: the function files to scaffold (an `index.ts` that declares the agent with `defineAgent` and its skills with `defineTool`) plus the secrets it needs. This is what `npx zavudev agents pull <id>` writes to disk before `npx zavudev deploy`.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $templateID,
        RequestOptions|array|null $requestOptions = null
    ): AgentTemplateGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($templateID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List the factory agents available to scaffold with `npx zavudev agents pull`. Each entry is a ready-made voice or text agent (system prompt, skills, and — for voice agents — a co-located voice config).
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): AgentTemplateListResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(requestOptions: $requestOptions);

        return $response->parse();
    }
}
