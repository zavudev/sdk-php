<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\Invitations\Invitation;
use Zavudev\Invitations\InvitationCancelResponse;
use Zavudev\Invitations\InvitationGetResponse;
use Zavudev\Invitations\InvitationListParams\Status;
use Zavudev\Invitations\InvitationNewResponse;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface InvitationsContract
{
    /**
     * @api
     *
     * @param list<string> $allowedPhoneCountries ISO country codes for allowed phone numbers
     * @param string $clientEmail email of the client being invited
     * @param string $clientName name of the client being invited
     * @param string $clientPhone Phone number of the client in E.164 format.
     * @param int $expiresInDays number of days until the invitation expires
     * @param string $phoneNumberID ID of a Zavu phone number to pre-assign for WhatsApp registration. If provided, the client will use this number instead of their own.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?array $allowedPhoneCountries = null,
        ?string $clientEmail = null,
        ?string $clientName = null,
        ?string $clientPhone = null,
        int $expiresInDays = 7,
        ?string $phoneNumberID = null,
        RequestOptions|array|null $requestOptions = null,
    ): InvitationNewResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $invitationID,
        RequestOptions|array|null $requestOptions = null
    ): InvitationGetResponse;

    /**
     * @api
     *
     * @param Status|value-of<Status> $status current status of the partner invitation
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<Invitation>
     *
     * @throws APIException
     */
    public function list(
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
    public function cancel(
        string $invitationID,
        RequestOptions|array|null $requestOptions = null
    ): InvitationCancelResponse;
}
