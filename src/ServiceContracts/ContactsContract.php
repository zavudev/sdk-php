<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Contacts\Contact;
use Zavudev\Contacts\ContactCreateParams\Channel1 as Channel;
use Zavudev\Contacts\ContactUpdateParams\DefaultChannel;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type Channel1Shape from \Zavudev\Contacts\ContactCreateParams\Channel1
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface ContactsContract
{
    /**
     * @api
     *
     * @param list<Channel|Channel1Shape> $channels communication channels for the contact
     * @param string $displayName display name for the contact
     * @param array<string,string> $metadata arbitrary metadata to associate with the contact
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function create(
        array $channels,
        ?string $displayName = null,
        ?array $metadata = null,
        RequestOptions|array|null $requestOptions = null,
    ): Contact;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $contactID,
        RequestOptions|array|null $requestOptions = null
    ): Contact;

    /**
     * @api
     *
     * @param DefaultChannel|value-of<DefaultChannel>|null $defaultChannel Preferred channel for this contact. Set to null to clear.
     * @param string|null $displayName Human-readable name for this contact. Set to null to clear it and fall back to the contact's identifier. Contacts created automatically from an inbound message have no display name until you set one.
     * @param array<string,string> $metadata
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $contactID,
        DefaultChannel|string|null $defaultChannel = null,
        ?string $displayName = null,
        ?array $metadata = null,
        RequestOptions|array|null $requestOptions = null,
    ): Contact;

    /**
     * @api
     *
     * @param string $cursor Opaque cursor from a previous response's `nextCursor`. Do not construct it.
     * @param string $phoneNumber Exact match on the contact's primary phone number, in E.164.
     * @param string $search Free-text match over the contact's name (`displayName` and the WhatsApp profile name), phone numbers and email addresses. Case- and accent-insensitive. A phone number matches on a trailing fragment too, so `5551234` finds `+14155551234`.
     *
     * Contacts created automatically from an inbound message have no `displayName` — they are matched by their identifier until you set one with `PATCH /v1/contacts/{contactId}`.
     *
     * Results come back in relevance order rather than newest-first. `cursor` is opaque in both modes; pass back exactly what the previous response returned, and start a new pagination run when the search term changes.
     * @param list<string> $tag Tag name. Repeatable: `?tag=vip&tag=chile` returns contacts carrying **every** tag given, not any of them — the same rule the dashboard filter applies.
     *
     * Tags are matched by name, case-insensitively. An unknown tag returns 400 rather than being ignored, because a typo that silently matched every contact would be a worse answer than an error.
     * @param RequestOpts|null $requestOptions
     *
     * @return Cursor<Contact>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        ?string $phoneNumber = null,
        ?string $search = null,
        ?array $tag = null,
        RequestOptions|array|null $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function delete(
        string $contactID,
        RequestOptions|array|null $requestOptions = null
    ): mixed;

    /**
     * @api
     *
     * @param string $sourceContactID ID of the contact to merge into the target contact. The source contact will be marked as merged.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function merge(
        string $contactID,
        string $sourceContactID,
        RequestOptions|array|null $requestOptions = null,
    ): Contact;

    /**
     * @api
     *
     * @param string $phoneNumber E.164 phone number.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveByPhone(
        string $phoneNumber,
        RequestOptions|array|null $requestOptions = null
    ): Contact;
}
