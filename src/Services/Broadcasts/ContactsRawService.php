<?php

declare(strict_types=1);

namespace Zavudev\Services\Broadcasts;

use Zavudev\Broadcasts\BroadcastContact;
use Zavudev\Broadcasts\BroadcastContactStatus;
use Zavudev\Broadcasts\Contacts\ContactAddParams;
use Zavudev\Broadcasts\Contacts\ContactAddParams\Contact;
use Zavudev\Broadcasts\Contacts\ContactAddResponse;
use Zavudev\Broadcasts\Contacts\ContactListParams;
use Zavudev\Broadcasts\Contacts\ContactRemoveParams;
use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\Broadcasts\ContactsRawContract;

/**
 * @phpstan-import-type ContactShape from \Zavudev\Broadcasts\Contacts\ContactAddParams\Contact
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
     * List contacts in a broadcast with optional status filter.
     *
     * @param array{
     *   cursor?: string,
     *   limit?: int,
     *   status?: BroadcastContactStatus|value-of<BroadcastContactStatus>,
     * }|ContactListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<BroadcastContact>>
     *
     * @throws APIException
     */
    public function list(
        string $broadcastID,
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
            path: ['v1/broadcasts/%1$s/contacts', $broadcastID],
            query: $parsed,
            options: $options,
            convert: BroadcastContact::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Add contacts to a broadcast in batch. Maximum 1000 contacts per request.
     *
     * @param array{contacts: list<Contact|ContactShape>}|ContactAddParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ContactAddResponse>
     *
     * @throws APIException
     */
    public function add(
        string $broadcastID,
        array|ContactAddParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ContactAddParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/broadcasts/%1$s/contacts', $broadcastID],
            body: (object) $parsed,
            options: $options,
            convert: ContactAddResponse::class,
        );
    }

    /**
     * @api
     *
     * Remove a contact from a broadcast in draft status.
     *
     * @param string $contactID Broadcast contact ID (not the global contact ID)
     * @param array{broadcastID: string}|ContactRemoveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function remove(
        string $contactID,
        array|ContactRemoveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ContactRemoveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $broadcastID = $parsed['broadcastID'];
        unset($parsed['broadcastID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/broadcasts/%1$s/contacts/%2$s', $broadcastID, $contactID],
            options: $options,
            convert: null,
        );
    }
}
