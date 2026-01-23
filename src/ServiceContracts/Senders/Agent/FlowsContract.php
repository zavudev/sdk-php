<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders\Agent;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\Flows\AgentFlow;
use Zavudev\Senders\Agent\Flows\FlowCreateParams\Step;
use Zavudev\Senders\Agent\Flows\FlowCreateParams\Trigger;
use Zavudev\Senders\Agent\Flows\FlowDuplicateResponse;
use Zavudev\Senders\Agent\Flows\FlowGetResponse;
use Zavudev\Senders\Agent\Flows\FlowNewResponse;
use Zavudev\Senders\Agent\Flows\FlowUpdateResponse;

/**
 * @phpstan-import-type StepShape from \Zavudev\Senders\Agent\Flows\FlowCreateParams\Step
 * @phpstan-import-type TriggerShape from \Zavudev\Senders\Agent\Flows\FlowCreateParams\Trigger
 * @phpstan-import-type StepShape from \Zavudev\Senders\Agent\Flows\FlowUpdateParams\Step as StepShape1
 * @phpstan-import-type TriggerShape from \Zavudev\Senders\Agent\Flows\FlowUpdateParams\Trigger as TriggerShape1
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface FlowsContract
{
    /**
     * @api
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
    ): FlowNewResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $flowID,
        string $senderID,
        RequestOptions|array|null $requestOptions = null,
    ): FlowGetResponse;

    /**
     * @api
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
    ): FlowUpdateResponse;

    /**
     * @api
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
    ): Cursor;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $flowID,
        string $senderID,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;

    /**
     * @api
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
    ): FlowDuplicateResponse;
}
