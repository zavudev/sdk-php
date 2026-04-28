<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\URLs\URLGetDetailsResponse;
use Zavudev\URLs\URLListVerifiedParams;
use Zavudev\URLs\URLSubmitForVerificationParams;
use Zavudev\URLs\URLSubmitForVerificationResponse;
use Zavudev\URLs\VerifiedURL;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface URLsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|URLListVerifiedParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<VerifiedURL>>
     *
     * @throws APIException
     */
    public function listVerified(
        array|URLListVerifiedParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<URLGetDetailsResponse>
     *
     * @throws APIException
     */
    public function retrieveDetails(
        string $urlID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|URLSubmitForVerificationParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<URLSubmitForVerificationResponse>
     *
     * @throws APIException
     */
    public function submitForVerification(
        array|URLSubmitForVerificationParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
