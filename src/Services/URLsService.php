<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\URLsContract;
use Zavudev\URLs\URLGetDetailsResponse;
use Zavudev\URLs\URLListVerifiedParams\Status;
use Zavudev\URLs\URLSubmitForVerificationResponse;
use Zavudev\URLs\VerifiedURL;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class URLsService implements URLsContract
{
    /**
     * @api
     */
    public URLsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new URLsRawService($client);
    }

    /**
     * @api
     *
     * List URLs that have been verified for this project.
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
    ): Cursor {
        $params = Util::removeNulls(
            ['cursor' => $cursor, 'limit' => $limit, 'status' => $status]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->listVerified(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get details of a specific verified URL.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveDetails(
        string $urlID,
        RequestOptions|array|null $requestOptions = null
    ): URLGetDetailsResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveDetails($urlID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Submit a URL for verification. URLs are automatically checked against Google Web Risk API. Safe URLs are auto-approved, malicious URLs are blocked. URL shorteners (bit.ly, t.co, etc.) are always blocked.
     *
     * **Important:** All SMS and Email messages containing URLs require those URLs to be verified before the message can be sent. This endpoint allows pre-verification of URLs.
     *
     * @param string $url the URL to submit for verification
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function submitForVerification(
        string $url,
        RequestOptions|array|null $requestOptions = null
    ): URLSubmitForVerificationResponse {
        $params = Util::removeNulls(['url' => $url]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->submitForVerification(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
