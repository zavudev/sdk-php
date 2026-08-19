<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Functions;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Functions\Triggers\TriggerCreateParams;
use Zavudev\Functions\Triggers\TriggerListResponse;
use Zavudev\Functions\Triggers\TriggerNewResponse;
use Zavudev\Functions\Triggers\TriggerUpdateParams;
use Zavudev\Functions\Triggers\TriggerUpdateResponse;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface TriggersRawContract
{
    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param array<string,mixed>|TriggerCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TriggerNewResponse>
     *
     * @throws APIException
     */
    public function create(
        string $functionID,
        array|TriggerCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|TriggerUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TriggerUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $triggerID,
        array|TriggerUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TriggerListResponse>
     *
     * @throws APIException
     */
    public function list(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $triggerID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
