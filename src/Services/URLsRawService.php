<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\URLsRawContract;
use Zavudev\URLs\URLGetDetailsResponse;
use Zavudev\URLs\URLListVerifiedParams;
use Zavudev\URLs\URLListVerifiedParams\Status;
use Zavudev\URLs\URLSubmitForVerificationParams;
use Zavudev\URLs\URLSubmitForVerificationResponse;
use Zavudev\URLs\VerifiedURL;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class URLsRawService implements URLsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * List URLs that have been verified for this project.
     *
     * @param array{
     *   cursor?: string, limit?: int, status?: Status|value-of<Status>
     * }|URLListVerifiedParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<VerifiedURL>>
     *
     * @throws APIException
     */
    public function listVerified(
        array|URLListVerifiedParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = URLListVerifiedParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/urls',
            query: $parsed,
            options: $options,
            convert: VerifiedURL::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Get details of a specific verified URL.
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/urls/%1$s', $urlID],
            options: $requestOptions,
            convert: URLGetDetailsResponse::class,
        );
    }

    /**
     * @api
     *
     * Submit a URL for verification. URLs are automatically checked against Google Web Risk API. Safe URLs are auto-approved, malicious URLs are blocked. URL shorteners (bit.ly, t.co, etc.) are always blocked.
     *
     * **Important:** All SMS and Email messages containing URLs require those URLs to be verified before the message can be sent. This endpoint allows pre-verification of URLs.
     *
     * @param array{url: string}|URLSubmitForVerificationParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<URLSubmitForVerificationResponse>
     *
     * @throws APIException
     */
    public function submitForVerification(
        array|URLSubmitForVerificationParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = URLSubmitForVerificationParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/urls',
            body: (object) $parsed,
            options: $options,
            convert: URLSubmitForVerificationResponse::class,
        );
    }
}
