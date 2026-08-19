<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\AgentTemplates\AgentTemplateGetResponse;
use Zavudev\AgentTemplates\AgentTemplateListResponse;
use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\AgentTemplatesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class AgentTemplatesRawService implements AgentTemplatesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Fetch a single factory agent fully rendered: the function files to scaffold (an `index.ts` that declares the agent with `defineAgent` and its skills with `defineTool`) plus the secrets it needs. This is what `npx zavudev agents pull <id>` writes to disk before `npx zavudev deploy`.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AgentTemplateGetResponse>
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
            path: ['v1/agent-templates/%1$s', $templateID],
            options: $requestOptions,
            convert: AgentTemplateGetResponse::class,
        );
    }

    /**
     * @api
     *
     * List the factory agents available to scaffold with `npx zavudev agents pull`. Each entry is a ready-made voice or text agent (system prompt, skills, and — for voice agents — a co-located voice config).
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AgentTemplateListResponse>
     *
     * @throws APIException
     */
    public function list(
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/agent-templates',
            options: $requestOptions,
            convert: AgentTemplateListResponse::class,
        );
    }
}
