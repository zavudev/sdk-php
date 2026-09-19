<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Broadcasts;

use Zavudev\Broadcasts\BroadcastContact;
use Zavudev\Broadcasts\BroadcastContactStatus;
use Zavudev\Broadcasts\Contacts\ContactAddParams\Contact;
use Zavudev\Broadcasts\Contacts\ContactAddResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type ContactShape from \Zavudev\Broadcasts\Contacts\ContactAddParams\Contact
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface ContactsContract
{
    /**
     * @api
     *
     * @param BroadcastContactStatus|value-of<BroadcastContactStatus> $status Status of a contact within a broadcast.
     *
     * - `pending`, `queued`, `sending`: not handed to the provider yet.
     * - `sent`: accepted by the provider; delivery is not confirmed yet. Channels that never report delivery leave the recipient here.
     * - `delivered`: the channel confirmed delivery to the device. A WhatsApp read receipt also counts as delivered.
     * - `failed`: not delivered. A recipient can move from `sent` or `delivered` to `failed` when the provider reports a failure late.
     * - `skipped`: not sent, because the recipient opted out of the channel or the broadcast was cancelled before reaching it.
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<BroadcastContact>
     *
     * @throws APIException
     */
    public function list(
        string $broadcastID,
        ?string $cursor = null,
        int $limit = 50,
        BroadcastContactStatus|string|null $status = null,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @param list<Contact|ContactShape> $contacts list of contacts to add (max 1000 per request)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function add(
        string $broadcastID,
        array $contacts,
        RequestOptions|array|null $requestOptions = null,
    ): ContactAddResponse;

    /**
     * @api
     *
     * @param string $contactID Broadcast contact ID (not the global contact ID)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $contactID,
        string $broadcastID,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;
}
