<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\Invitations\Invitation;
use Zavudev\Invitations\InvitationCancelResponse;
use Zavudev\Invitations\InvitationCreateParams;
use Zavudev\Invitations\InvitationGetResponse;
use Zavudev\Invitations\InvitationListParams;
use Zavudev\Invitations\InvitationListParams\Status;
use Zavudev\Invitations\InvitationNewResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\InvitationsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class InvitationsRawService implements InvitationsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a partner invitation link for a client to connect their WhatsApp Business account. The client will complete Meta's embedded signup flow and the resulting sender will be created in your project.
     *
     * @param array{
     *   allowedPhoneCountries?: list<string>,
     *   clientEmail?: string,
     *   clientName?: string,
     *   clientPhone?: string,
     *   expiresInDays?: int,
     *   phoneNumberID?: string,
     * }|InvitationCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvitationNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|InvitationCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = InvitationCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/invitations',
            body: (object) $parsed,
            options: $options,
            convert: InvitationNewResponse::class,
        );
    }

    /**
     * @api
     *
     * Get invitation
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvitationGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $invitationID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/invitations/%1$s', $invitationID],
            options: $requestOptions,
            convert: InvitationGetResponse::class,
        );
    }

    /**
     * @api
     *
     * List partner invitations for this project.
     *
     * @param array{
     *   cursor?: string, limit?: int, status?: Status|value-of<Status>
     * }|InvitationListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<Invitation>>
     *
     * @throws APIException
     */
    public function list(
        array|InvitationListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = InvitationListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/invitations',
            query: $parsed,
            options: $options,
            convert: Invitation::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Cancel an active invitation. The client will no longer be able to use the invitation link.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvitationCancelResponse>
     *
     * @throws APIException
     */
    public function cancel(
        string $invitationID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/invitations/%1$s/cancel', $invitationID],
            options: $requestOptions,
            convert: InvitationCancelResponse::class,
        );
    }
}
