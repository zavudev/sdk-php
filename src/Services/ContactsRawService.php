<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Contacts\Contact;
use Zavudev\Contacts\ContactCreateParams;
use Zavudev\Contacts\ContactCreateParams\Channel1 as Channel;
use Zavudev\Contacts\ContactListParams;
use Zavudev\Contacts\ContactMergeParams;
use Zavudev\Contacts\ContactUpdateParams;
use Zavudev\Contacts\ContactUpdateParams\DefaultChannel;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\ContactsRawContract;

/**
 * @phpstan-import-type Channel1Shape from \Zavudev\Contacts\ContactCreateParams\Channel1
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class ContactsRawService implements ContactsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create a new contact with one or more communication channels.
     *
     * @param array{
     *   channels: list<Channel|Channel1Shape>,
     *   displayName?: string,
     *   metadata?: array<string,string>,
     * }|ContactCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Contact>
     *
     * @throws APIException
     */
    public function create(
        array|ContactCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ContactCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/contacts',
            body: (object) $parsed,
            options: $options,
            convert: Contact::class,
        );
    }

    /**
     * @api
     *
     * Get contact
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Contact>
     *
     * @throws APIException
     */
    public function retrieve(
        string $contactID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/contacts/%1$s', $contactID],
            options: $requestOptions,
            convert: Contact::class,
        );
    }

    /**
     * @api
     *
     * Update contact
     *
     * @param array{
     *   defaultChannel?: DefaultChannel|value-of<DefaultChannel>|null,
     *   metadata?: array<string,string>,
     * }|ContactUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Contact>
     *
     * @throws APIException
     */
    public function update(
        string $contactID,
        array|ContactUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ContactUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v1/contacts/%1$s', $contactID],
            body: (object) $parsed,
            options: $options,
            convert: Contact::class,
        );
    }

    /**
     * @api
     *
     * List contacts with their communication channels.
     *
     * @param array{
     *   cursor?: string, limit?: int, phoneNumber?: string
     * }|ContactListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<Contact>>
     *
     * @throws APIException
     */
    public function list(
        array|ContactListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ContactListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/contacts',
            query: $parsed,
            options: $options,
            convert: Contact::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Dismiss the merge suggestion for a contact.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function dismissMergeSuggestion(
        string $contactID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/contacts/%1$s/merge-suggestion', $contactID],
            options: $requestOptions,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Merge a source contact into this contact. All channels from the source contact will be moved to the target contact, and the source contact will be marked as merged.
     *
     * @param array{sourceContactID: string}|ContactMergeParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Contact>
     *
     * @throws APIException
     */
    public function merge(
        string $contactID,
        array|ContactMergeParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ContactMergeParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/contacts/%1$s/merge', $contactID],
            body: (object) $parsed,
            options: $options,
            convert: Contact::class,
        );
    }

    /**
     * @api
     *
     * Get contact by phone number
     *
     * @param string $phoneNumber E.164 phone number.
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Contact>
     *
     * @throws APIException
     */
    public function retrieveByPhone(
        string $phoneNumber,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/contacts/phone/%1$s', $phoneNumber],
            options: $requestOptions,
            convert: Contact::class,
        );
    }
}
