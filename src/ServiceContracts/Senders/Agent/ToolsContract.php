<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders\Agent;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\Tools\AgentTool;
use Zavudev\Senders\Agent\Tools\ToolCreateParams\Parameters\Type;
use Zavudev\Senders\Agent\Tools\ToolGetResponse;
use Zavudev\Senders\Agent\Tools\ToolNewResponse;
use Zavudev\Senders\Agent\Tools\ToolTestResponse;
use Zavudev\Senders\Agent\Tools\ToolUpdateResponse;

interface ToolsContract
{
    /**
     * @api
     *
     * @param array{
     *   properties: array<string,array{description?: string, type?: string}>,
     *   required: list<string>,
     *   type: 'object'|Type,
     * } $parameters
     * @param string $webhookURL must be HTTPS
     * @param string $webhookSecret optional secret for webhook signature verification
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        string $description,
        string $name,
        array $parameters,
        string $webhookURL,
        bool $enabled = true,
        ?string $webhookSecret = null,
        ?RequestOptions $requestOptions = null,
    ): ToolNewResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function retrieve(
        string $toolID,
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): ToolGetResponse;

    /**
     * @api
     *
     * @param string $toolID Path param:
     * @param string $senderID Path param:
     * @param string $description Body param:
     * @param bool $enabled Body param:
     * @param string $name Body param:
     * @param array{
     *   properties: array<string,array{description?: string, type?: string}>,
     *   required: list<string>,
     *   type: 'object'|\Zavudev\Senders\Agent\Tools\ToolUpdateParams\Parameters\Type,
     * } $parameters Body param:
     * @param string|null $webhookSecret Body param:
     * @param string $webhookURL Body param:
     *
     * @throws APIException
     */
    public function update(
        string $toolID,
        string $senderID,
        ?string $description = null,
        ?bool $enabled = null,
        ?string $name = null,
        ?array $parameters = null,
        ?string $webhookSecret = null,
        ?string $webhookURL = null,
        ?RequestOptions $requestOptions = null,
    ): ToolUpdateResponse;

    /**
     * @api
     *
     * @return Cursor<AgentTool>
     *
     * @throws APIException
     */
    public function list(
        string $senderID,
        ?string $cursor = null,
        ?bool $enabled = null,
        int $limit = 50,
        ?RequestOptions $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @throws APIException
     */
    public function delete(
        string $toolID,
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param string $toolID Path param:
     * @param string $senderID Path param:
     * @param array<string,mixed> $testParams body param: Parameters to pass to the tool for testing
     *
     * @throws APIException
     */
    public function test(
        string $toolID,
        string $senderID,
        array $testParams,
        ?RequestOptions $requestOptions = null,
    ): ToolTestResponse;
}
