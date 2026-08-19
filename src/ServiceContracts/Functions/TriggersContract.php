<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Functions;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Functions\Triggers\TriggerListResponse;
use Zavudev\Functions\Triggers\TriggerNewResponse;
use Zavudev\Functions\Triggers\TriggerUpdateResponse;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface TriggersContract
{
    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param list<string> $eventTypes event types to subscribe to
     * @param list<string|null> $senderIDs Senders to scope the triggers to. Use null for all senders.
     * @param string $cron required when eventTypes includes `cron`: a 5-field cron expression (minute hour day-of-month month day-of-week), evaluated in UTC
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        string $functionID,
        array $eventTypes,
        array $senderIDs,
        ?string $cron = null,
        RequestOptions|array|null $requestOptions = null,
    ): TriggerNewResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $triggerID,
        bool $active,
        RequestOptions|array|null $requestOptions = null,
    ): TriggerUpdateResponse;

    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function list(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): TriggerListResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $triggerID,
        RequestOptions|array|null $requestOptions = null
    ): mixed;
}
