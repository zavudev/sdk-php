<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\AgentCreateParams;
use Zavudev\Senders\Agent\AgentProvider;
use Zavudev\Senders\Agent\AgentResponse;
use Zavudev\Senders\Agent\AgentStats;
use Zavudev\Senders\Agent\AgentUpdateParams;
use Zavudev\ServiceContracts\Senders\AgentRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class AgentRawService implements AgentRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create an AI agent for a sender. Each sender can have at most one agent.
     *
     * @param array{
     *   model: string,
     *   name: string,
     *   provider: AgentProvider|value-of<AgentProvider>,
     *   systemPrompt: string,
     *   apiKey?: string,
     *   contextWindowMessages?: int,
     *   includeContactMetadata?: bool,
     *   maxTokens?: int,
     *   temperature?: float,
     *   triggerOnChannels?: list<string>,
     *   triggerOnMessageTypes?: list<string>,
     * }|AgentCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AgentResponse>
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        array|AgentCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AgentCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/senders/%1$s/agent', $senderID],
            body: (object) $parsed,
            options: $options,
            convert: AgentResponse::class,
        );
    }

    /**
     * @api
     *
     * Get the AI agent configuration for a sender.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AgentResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/senders/%1$s/agent', $senderID],
            options: $requestOptions,
            convert: AgentResponse::class,
        );
    }

    /**
     * @api
     *
     * Update an AI agent's configuration.
     *
     * @param array{
     *   apiKey?: string,
     *   contextWindowMessages?: int,
     *   enabled?: bool,
     *   includeContactMetadata?: bool,
     *   maxTokens?: int|null,
     *   model?: string,
     *   name?: string,
     *   provider?: AgentProvider|value-of<AgentProvider>,
     *   systemPrompt?: string,
     *   temperature?: float|null,
     *   triggerOnChannels?: list<string>,
     *   triggerOnMessageTypes?: list<string>,
     * }|AgentUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AgentResponse>
     *
     * @throws APIException
     */
    public function update(
        string $senderID,
        array|AgentUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = AgentUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v1/senders/%1$s/agent', $senderID],
            body: (object) $parsed,
            options: $options,
            convert: AgentResponse::class,
        );
    }

    /**
     * @api
     *
     * Delete an AI agent.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/senders/%1$s/agent', $senderID],
            options: $requestOptions,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Get statistics for an AI agent including invocations, tokens, and costs.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<AgentStats>
     *
     * @throws APIException
     */
    public function stats(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/senders/%1$s/agent/stats', $senderID],
            options: $requestOptions,
            convert: AgentStats::class,
        );
    }
}
