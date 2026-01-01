<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Senders\Agent;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Agent\Flows\AgentFlow;
use Zavudev\Senders\Agent\Flows\FlowCreateParams\Step\Type;
use Zavudev\Senders\Agent\Flows\FlowDuplicateResponse;
use Zavudev\Senders\Agent\Flows\FlowGetResponse;
use Zavudev\Senders\Agent\Flows\FlowNewResponse;
use Zavudev\Senders\Agent\Flows\FlowUpdateResponse;

interface FlowsContract
{
    /**
     * @api
     *
     * @param list<array{
     *   id: string,
     *   config: array<string,mixed>,
     *   type: 'message'|'collect'|'condition'|'tool'|'llm'|'transfer'|Type,
     *   nextStepID?: string|null,
     * }> $steps
     * @param array{
     *   type: 'keyword'|'intent'|'always'|'manual'|\Zavudev\Senders\Agent\Flows\FlowCreateParams\Trigger\Type,
     *   intent?: string,
     *   keywords?: list<string>,
     * } $trigger
     *
     * @throws APIException
     */
    public function create(
        string $senderID,
        string $name,
        array $steps,
        array $trigger,
        ?string $description = null,
        bool $enabled = false,
        int $priority = 0,
        ?RequestOptions $requestOptions = null,
    ): FlowNewResponse;

    /**
     * @api
     *
     * @throws APIException
     */
    public function retrieve(
        string $flowID,
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): FlowGetResponse;

    /**
     * @api
     *
     * @param string $flowID Path param:
     * @param string $senderID Path param:
     * @param string $description Body param:
     * @param bool $enabled Body param:
     * @param string $name Body param:
     * @param int $priority Body param:
     * @param list<array{
     *   id: string,
     *   config: array<string,mixed>,
     *   type: 'message'|'collect'|'condition'|'tool'|'llm'|'transfer'|\Zavudev\Senders\Agent\Flows\FlowUpdateParams\Step\Type,
     *   nextStepID?: string|null,
     * }> $steps Body param:
     * @param array{
     *   type: 'keyword'|'intent'|'always'|'manual'|\Zavudev\Senders\Agent\Flows\FlowUpdateParams\Trigger\Type,
     *   intent?: string,
     *   keywords?: list<string>,
     * } $trigger Body param:
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
        ?array $trigger = null,
        ?RequestOptions $requestOptions = null,
    ): FlowUpdateResponse;

    /**
     * @api
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
        ?RequestOptions $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @throws APIException
     */
    public function delete(
        string $flowID,
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param string $flowID Path param:
     * @param string $senderID Path param:
     * @param string $newName Body param:
     *
     * @throws APIException
     */
    public function duplicate(
        string $flowID,
        string $senderID,
        string $newName,
        ?RequestOptions $requestOptions = null,
    ): FlowDuplicateResponse;
}
