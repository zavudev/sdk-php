<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Broadcasts;

use Zavudev\Broadcasts\BroadcastContact;
use Zavudev\Broadcasts\BroadcastContactStatus;
use Zavudev\Broadcasts\Contacts\ContactAddResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;

interface ContactsContract
{
    /**
     * @api
     *
     * @param 'pending'|'queued'|'sending'|'delivered'|'failed'|'skipped'|BroadcastContactStatus $status status of a contact within a broadcast
     *
     * @return Cursor<BroadcastContact>
     *
     * @throws APIException
     */
    public function list(
        string $broadcastID,
        ?string $cursor = null,
        int $limit = 50,
        string|BroadcastContactStatus|null $status = null,
        ?RequestOptions $requestOptions = null,
    ): Cursor;

    /**
     * @api
     *
     * @param list<array{
     *   recipient: string, templateVariables?: array<string,string>
     * }> $contacts List of contacts to add (max 1000 per request)
     *
     * @throws APIException
     */
    public function add(
        string $broadcastID,
        array $contacts,
        ?RequestOptions $requestOptions = null,
    ): ContactAddResponse;

    /**
     * @api
     *
     * @param string $contactID Broadcast contact ID (not the global contact ID)
     *
     * @throws APIException
     */
    public function remove(
        string $contactID,
        string $broadcastID,
        ?RequestOptions $requestOptions = null,
    ): mixed;
}
