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
     * @param array<string,string> $metadata
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $contactID,
        DefaultChannel|string|null $defaultChannel = null,
        ?array $metadata = null,
        RequestOptions|array|null $requestOptions = null,
    ): Contact;

    /**
     * @api
     *
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
        RequestOptions|array|null $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function dismissMergeSuggestion(
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
