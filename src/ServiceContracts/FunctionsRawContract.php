<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Functions\FunctionCreateParams;
use Zavudev\Functions\FunctionDeleteResponse;
use Zavudev\Functions\FunctionDeployParams;
use Zavudev\Functions\FunctionDeployResponse;
use Zavudev\Functions\FunctionGetDeploymentResponse;
use Zavudev\Functions\FunctionGetResponse;
use Zavudev\Functions\FunctionNewResponse;
use Zavudev\Functions\FunctionTailLogsParams;
use Zavudev\Functions\FunctionTailLogsResponse;
use Zavudev\Functions\FunctionUpdateParams;
use Zavudev\Functions\FunctionUpdateResponse;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface FunctionsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|FunctionCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FunctionNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|FunctionCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FunctionGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param array<string,mixed>|FunctionUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FunctionUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $functionID,
        array|FunctionUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FunctionDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $functionID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param array<string,mixed>|FunctionDeployParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FunctionDeployResponse>
     *
     * @throws APIException
     */
    public function deploy(
        string $functionID,
        array|FunctionDeployParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $deploymentID function deployment ID
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FunctionGetDeploymentResponse>
     *
     * @throws APIException
     */
    public function getDeployment(
        string $deploymentID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $functionID zavu Function ID
     * @param array<string,mixed>|FunctionTailLogsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<FunctionTailLogsResponse>
     *
     * @throws APIException
     */
    public function tailLogs(
        string $functionID,
        array|FunctionTailLogsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
