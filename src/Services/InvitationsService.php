<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\Invitations\Invitation;
use Zavudev\Invitations\InvitationCancelResponse;
use Zavudev\Invitations\InvitationGetResponse;
use Zavudev\Invitations\InvitationListParams\Status;
use Zavudev\Invitations\InvitationNewResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\InvitationsContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class InvitationsService implements InvitationsContract
{
    /**
     * @api
     */
    public InvitationsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new InvitationsRawService($client);
    }

    /**
     * @api
     *
     * Create a partner invitation link for a client to connect their WhatsApp Business account. The client will complete Meta's embedded signup flow and the resulting sender will be created in your project.
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
    ): InvitationNewResponse {
        $params = Util::removeNulls(
            [
                'allowedPhoneCountries' => $allowedPhoneCountries,
                'clientEmail' => $clientEmail,
                'clientName' => $clientName,
                'clientPhone' => $clientPhone,
                'expiresInDays' => $expiresInDays,
                'phoneNumberID' => $phoneNumberID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get invitation
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $invitationID,
        RequestOptions|array|null $requestOptions = null
    ): InvitationGetResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($invitationID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List partner invitations for this project.
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
    ): Cursor {
        $params = Util::removeNulls(
            ['cursor' => $cursor, 'limit' => $limit, 'status' => $status]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Cancel an active invitation. The client will no longer be able to use the invitation link.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function cancel(
        string $invitationID,
        RequestOptions|array|null $requestOptions = null
    ): InvitationCancelResponse {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->cancel($invitationID, requestOptions: $requestOptions);

        return $response->parse();
    }
}
