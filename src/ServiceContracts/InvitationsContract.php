<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\Invitations\Invitation;
use Zavudev\Invitations\InvitationCancelResponse;
use Zavudev\Invitations\InvitationCreateParams\ConnectionType;
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
