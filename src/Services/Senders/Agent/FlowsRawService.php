<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders\Agent;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\Flows\AgentFlow;
use Zavudev\Senders\Agent\Flows\FlowCreateParams;
use Zavudev\Senders\Agent\Flows\FlowCreateParams\Step;
use Zavudev\Senders\Agent\Flows\FlowCreateParams\Trigger;
use Zavudev\Senders\Agent\Flows\FlowDeleteParams;
use Zavudev\Senders\Agent\Flows\FlowDuplicateParams;
use Zavudev\Senders\Agent\Flows\FlowDuplicateResponse;
use Zavudev\Senders\Agent\Flows\FlowGetResponse;
use Zavudev\Senders\Agent\Flows\FlowListParams;
use Zavudev\Senders\Agent\Flows\FlowNewResponse;
use Zavudev\Senders\Agent\Flows\FlowRetrieveParams;
use Zavudev\Senders\Agent\Flows\FlowUpdateParams;
use Zavudev\Senders\Agent\Flows\FlowUpdateResponse;
use Zavudev\ServiceContracts\Senders\Agent\FlowsRawContract;

/**
 * @phpstan-import-type StepShape from \Zavudev\Senders\Agent\Flows\FlowCreateParams\Step
 * @phpstan-import-type TriggerShape from \Zavudev\Senders\Agent\Flows\FlowCreateParams\Trigger
 * @phpstan-import-type StepShape from \Zavudev\Senders\Agent\Flows\FlowUpdateParams\Step as StepShape1
 * @phpstan-import-type TriggerShape from \Zavudev\Senders\Agent\Flows\FlowUpdateParams\Trigger as TriggerShape1
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class FlowsRawService implements FlowsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a new flow for an agent.
     *
     * @param array{
     *   name: string,
     *   steps: list<Step|StepShape>,
     *   trigger: Trigger|TriggerShape,
     *   description?: string,
     *   enabled?: bool,
     *   priority?: int,
     * }|FlowCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FlowNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        array|FlowCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FlowCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/senders/%1$s/agent/flows', $senderID],
            body: (object) $parsed,
            options: $options,
            convert: FlowNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get a specific flow.
     *
     * @param array{senderID: string}|FlowRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FlowGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $flowID,
        array|FlowRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FlowRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $senderID = $parsed['senderID'];
        unset($parsed['senderID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/senders/%1$s/agent/flows/%2$s', $senderID, $flowID],
            options: $options,
            convert: FlowGetResponse::class,
        );
    }

    /**
     * @api
     *
     * Update a flow.
     *
     * @param string $flowID Path param:
     * @param array{
     *   senderID: string,
     *   description?: string,
     *   enabled?: bool,
     *   name?: string,
     *   priority?: int,
     *   steps?: list<FlowUpdateParams\Step|StepShape1>,
     *   trigger?: FlowUpdateParams\Trigger|TriggerShape1,
     * }|FlowUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FlowUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $flowID,
        array|FlowUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FlowUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $senderID = $parsed['senderID'];
        unset($parsed['senderID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v1/senders/%1$s/agent/flows/%2$s', $senderID, $flowID],
            body: (object) array_diff_key($parsed, array_flip(['senderID'])),
            options: $options,
            convert: FlowUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * List flows for an agent.
     *
     * @param array{
     *   cursor?: string, enabled?: bool, limit?: int
     * }|FlowListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<AgentFlow>>
     *
     * @throws APIException
     */
    public function list(
        string $senderID,
        array|FlowListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FlowListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/senders/%1$s/agent/flows', $senderID],
            query: $parsed,
            options: $options,
            convert: AgentFlow::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Delete a flow. Cannot delete flows with active sessions.
     *
     * @param array{senderID: string}|FlowDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $flowID,
        array|FlowDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FlowDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );
        $senderID = $parsed['senderID'];
        unset($parsed['senderID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/senders/%1$s/agent/flows/%2$s', $senderID, $flowID],
            options: $options,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Create a copy of an existing flow with a new name.
     *
     * @param string $flowID Path param:
     * @param array{senderID: string, newName: string}|FlowDuplicateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FlowDuplicateResponse>
     *
     * @throws APIException
     */
    public function duplicate(
        string $flowID,
        array|FlowDuplicateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = FlowDuplicateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $senderID = $parsed['senderID'];
        unset($parsed['senderID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/senders/%1$s/agent/flows/%2$s/duplicate', $senderID, $flowID],
            body: (object) array_diff_key($parsed, array_flip(['senderID'])),
            options: $options,
            convert: FlowDuplicateResponse::class,
        );
    }
}
