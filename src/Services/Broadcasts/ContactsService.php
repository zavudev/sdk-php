<?php

declare(strict_types=1);

namespace Zavudev\Services\Broadcasts;

use Zavudev\Broadcasts\BroadcastContact;
use Zavudev\Broadcasts\BroadcastContactStatus;
use Zavudev\Broadcasts\Contacts\ContactAddParams\Contact;
use Zavudev\Broadcasts\Contacts\ContactAddResponse;
use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\Broadcasts\ContactsContract;

/**
 * @phpstan-import-type ContactShape from \Zavudev\Broadcasts\Contacts\ContactAddParams\Contact
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class ContactsService implements ContactsContract
{
    /**
     * @api
     */
    public ContactsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ContactsRawService($client);
    }

    /**
     * @api
     *
     * List contacts in a broadcast with optional status filter.
     *
     * @param BroadcastContactStatus|value-of<BroadcastContactStatus> $status status of a contact within a broadcast
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
    ): Cursor {
        $params = Util::removeNulls(
            ['cursor' => $cursor, 'limit' => $limit, 'status' => $status]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($broadcastID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Add contacts to a broadcast in batch. Maximum 1000 contacts per request.
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
    ): ContactAddResponse {
        $params = Util::removeNulls(['contacts' => $contacts]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->add($broadcastID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Remove a contact from a broadcast in draft status.
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
    ): mixed {
        $params = Util::removeNulls(['broadcastID' => $broadcastID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->remove($contactID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
