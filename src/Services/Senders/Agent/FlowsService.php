<?php

declare(strict_types=1);

namespace Zavudev\Services\Senders\Agent;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\Flows\AgentFlow;
use Zavudev\Senders\Agent\Flows\FlowCreateParams\Step;
use Zavudev\Senders\Agent\Flows\FlowCreateParams\Trigger;
use Zavudev\Senders\Agent\Flows\FlowDuplicateResponse;
use Zavudev\Senders\Agent\Flows\FlowGetResponse;
use Zavudev\Senders\Agent\Flows\FlowNewResponse;
use Zavudev\Senders\Agent\Flows\FlowUpdateResponse;
use Zavudev\ServiceContracts\Senders\Agent\FlowsContract;

/**
 * @phpstan-import-type StepShape from \Zavudev\Senders\Agent\Flows\FlowCreateParams\Step
 * @phpstan-import-type TriggerShape from \Zavudev\Senders\Agent\Flows\FlowCreateParams\Trigger
 * @phpstan-import-type StepShape from \Zavudev\Senders\Agent\Flows\FlowUpdateParams\Step as StepShape1
 * @phpstan-import-type TriggerShape from \Zavudev\Senders\Agent\Flows\FlowUpdateParams\Trigger as TriggerShape1
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class FlowsService implements FlowsContract
{
    /**
     * @api
     */
    public FlowsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new FlowsRawService($client);
    }

    /**
     * @api
     *
     * Create a new flow for an agent.
     *
     * @param list<Step|StepShape> $steps
     * @param Trigger|TriggerShape $trigger
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        string $name,
        array $steps,
        Trigger|array $trigger,
        ?string $description = null,
        bool $enabled = false,
        int $priority = 0,
        RequestOptions|array|null $requestOptions = null,
    ): FlowNewResponse {
        $params = Util::removeNulls(
            [
                'name' => $name,
                'steps' => $steps,
                'trigger' => $trigger,
                'description' => $description,
                'enabled' => $enabled,
                'priority' => $priority,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create($senderID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get a specific flow.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $flowID,
        string $senderID,
        RequestOptions|array|null $requestOptions = null,
    ): FlowGetResponse {
        $params = Util::removeNulls(['senderID' => $senderID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($flowID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update a flow.
     *
     * @param string $flowID Path param
     * @param string $senderID Path param
     * @param string $description Body param
     * @param bool $enabled Body param
     * @param string $name Body param
     * @param int $priority Body param
     * @param list<\Zavudev\Senders\Agent\Flows\FlowUpdateParams\Step|StepShape1> $steps Body param
     * @param \Zavudev\Senders\Agent\Flows\FlowUpdateParams\Trigger|TriggerShape1 $trigger Body param
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $flowID,
        string $senderID,
        ?string $description = null,
        ?bool $enabled = null,
        ?string $name = null,
        ?int $priority = null,
        ?array $steps = null,
        \Zavudev\Senders\Agent\Flows\FlowUpdateParams\Trigger|array|null $trigger = null,
        RequestOptions|array|null $requestOptions = null,
    ): FlowUpdateResponse {
        $params = Util::removeNulls(
            [
                'senderID' => $senderID,
                'description' => $description,
                'enabled' => $enabled,
                'name' => $name,
                'priority' => $priority,
                'steps' => $steps,
                'trigger' => $trigger,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($flowID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List flows for an agent.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<AgentFlow>
     *
     * @throws APIException
     */
    public function list(
        string $senderID,
        ?string $cursor = null,
        ?bool $enabled = null,
        int $limit = 50,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor {
        $params = Util::removeNulls(
            ['cursor' => $cursor, 'enabled' => $enabled, 'limit' => $limit]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($senderID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Delete a flow. Cannot delete flows with active sessions.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $flowID,
        string $senderID,
        RequestOptions|array|null $requestOptions = null,
    ): mixed {
        $params = Util::removeNulls(['senderID' => $senderID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->delete($flowID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Create a copy of an existing flow with a new name.
     *
     * @param string $flowID Path param
     * @param string $senderID Path param
     * @param string $newName Body param
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function duplicate(
        string $flowID,
        string $senderID,
        string $newName,
        RequestOptions|array|null $requestOptions = null,
    ): FlowDuplicateResponse {
        $params = Util::removeNulls(
            ['senderID' => $senderID, 'newName' => $newName]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->duplicate($flowID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
