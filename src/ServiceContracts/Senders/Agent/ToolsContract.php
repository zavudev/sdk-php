<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders\Agent;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\Tools\AgentTool;
use Zavudev\Senders\Agent\Tools\ToolGetResponse;
use Zavudev\Senders\Agent\Tools\ToolNewResponse;
use Zavudev\Senders\Agent\Tools\ToolParameters;
use Zavudev\Senders\Agent\Tools\ToolTestResponse;
use Zavudev\Senders\Agent\Tools\ToolUpdateResponse;

/**
 * @phpstan-import-type ToolParametersShape from \Zavudev\Senders\Agent\Tools\ToolParameters
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface ToolsContract
{
    /**
     * @api
     *
     * @param ToolParameters|ToolParametersShape $parameters
     * @param string $webhookURL must be HTTPS
     * @param string $webhookSecret optional secret for webhook signature verification
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        string $description,
        string $name,
        ToolParameters|array $parameters,
        string $webhookURL,
        bool $enabled = true,
        ?string $webhookSecret = null,
        RequestOptions|array|null $requestOptions = null,
    ): ToolNewResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $toolID,
        string $senderID,
        RequestOptions|array|null $requestOptions = null,
    ): ToolGetResponse;

    /**
     * @api
     *
     * @param string $toolID Path param
     * @param string $senderID Path param
     * @param string $description Body param
     * @param bool $enabled Body param
     * @param string $name Body param
     * @param ToolParameters|ToolParametersShape $parameters Body param
     * @param string|null $webhookSecret Body param
     * @param string $webhookURL Body param
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $toolID,
        string $senderID,
        ?string $description = null,
        ?bool $enabled = null,
        ?string $name = null,
        ToolParameters|array|null $parameters = null,
        ?string $webhookSecret = null,
        ?string $webhookURL = null,
        RequestOptions|array|null $requestOptions = null,
    ): ToolUpdateResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
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
        string $toolID,
        string $senderID,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;

    /**
     * @api
     *
     * @param string $toolID Path param
     * @param string $senderID Path param
     * @param array<string,mixed> $testParams body param: Parameters to pass to the tool for testing
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function test(
        string $toolID,
        string $senderID,
        array $testParams,
        RequestOptions|array|null $requestOptions = null,
    ): ToolTestResponse;
}
