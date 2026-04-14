<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\URLs\URLGetDetailsResponse;
use Zavudev\URLs\URLListVerifiedParams\Status;
use Zavudev\URLs\URLSubmitForVerificationResponse;
use Zavudev\URLs\VerifiedURL;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface URLsContract
{
    /**
     * @api
     *
     * @param Status|value-of<Status> $status filter by verification status
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<VerifiedURL>
     *
     * @throws APIException
     */
    public function listVerified(
        ?string $cursor = null,
        int $limit = 50,
        Status|string|null $status = null,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveDetails(
        string $urlID,
        RequestOptions|array|null $requestOptions = null
    ): URLGetDetailsResponse;

    /**
     * @api
     *
     * @param string $url the URL to submit for verification
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function submitForVerification(
        string $url,
        RequestOptions|array|null $requestOptions = null
    ): URLSubmitForVerificationResponse;
}
