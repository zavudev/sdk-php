<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\Invitations\Invitation;
use Zavudev\Invitations\InvitationCancelResponse;
use Zavudev\Invitations\InvitationCreateParams\ConnectionType;
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
     * Create a partner invitation link for a client to connect a Meta channel. The client opens the returned `url` and authorizes with Meta; the resulting sender is created in your project when they finish, and the invitation transitions to `completed`.
     *
     * `connectionType` picks the channel:
     * - `whatsapp_waba` (default): Meta's embedded signup links an official WhatsApp Business Account.
     * - `messenger`: the client picks a Facebook Page they administer; its Messenger inbox (including Marketplace chats) is routed to Zavu.
     *
     * One invitation connects one channel — create one per channel to onboard a client on several. `phoneNumberId` and `allowedPhoneCountries` apply to `whatsapp_waba` only.
     *
     * @param list<string> $allowedPhoneCountries ISO country codes for allowed phone numbers. Only valid when `connectionType` is `whatsapp_waba` — sending it with `messenger` returns 400.
     * @param string $clientEmail email of the client being invited
     * @param string $clientName name of the client being invited
     * @param string $clientPhone Phone number of the client in E.164 format.
     * @param ConnectionType|value-of<ConnectionType> $connectionType Which Meta channel the client connects, and how.
     * - `whatsapp_waba` (default): Meta's embedded signup links an official WhatsApp Business Account. Accepts `phoneNumberId` and `allowedPhoneCountries`.
     * - `messenger`: the client authorizes with Facebook and picks a Facebook Page they administer. The Page's Messenger inbox — including Marketplace chats — is routed to Zavu. They must be an admin of at least one Page. A Page can only be connected to one Zavu project at a time: if the client picks a Page that another project already connected, the newer connection wins and the older one is disconnected.
     *
     * One invitation connects one channel. To onboard a client on several channels, create one invitation per channel; each completes into its own sender.
     * @param int $expiresInDays number of days until the invitation expires
     * @param string $phoneNumberID ID of a Zavu phone number to pre-assign for WhatsApp registration. If provided, the client will use this number instead of their own. Only valid when `connectionType` is `whatsapp_waba` — sending it with `messenger` returns 400, since a Facebook Page has no phone number.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        ?array $allowedPhoneCountries = null,
        ?string $clientEmail = null,
        ?string $clientName = null,
        ?string $clientPhone = null,
        ConnectionType|string $connectionType = 'whatsapp_waba',
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
                'connectionType' => $connectionType,
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
     * @param Status|value-of<Status> $status Current status of the partner invitation.
     *
     * `failed` means the client started the connection and it did not finish (they cancelled Meta's dialog, denied a permission, or abandoned the tab). A failed invitation is still usable: the same link can be retried, and it moves back to `in_progress` when the client tries again.
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
