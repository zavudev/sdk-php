<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Contacts\Contact;
use Zavudev\Contacts\ContactUpdateParams\DefaultChannel;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\ContactsContract;

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
     * Get contact
     *
     * @throws APIException
     */
    public function retrieve(
        string $contactID,
        ?RequestOptions $requestOptions = null
    ): Contact {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($contactID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Update contact
     *
     * @param 'sms'|'whatsapp'|'email'|DefaultChannel|null $defaultChannel Preferred channel for this contact. Set to null to clear.
     * @param array<string,string> $metadata
     *
     * @throws APIException
     */
    public function update(
        string $contactID,
        string|DefaultChannel|null $defaultChannel = null,
        ?array $metadata = null,
        ?RequestOptions $requestOptions = null,
    ): Contact {
        $params = Util::removeNulls(
            ['defaultChannel' => $defaultChannel, 'metadata' => $metadata]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($contactID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List contacts
     *
     * @return Cursor<Contact>
     *
     * @throws APIException
     */
    public function list(
        ?string $cursor = null,
        int $limit = 50,
        ?string $phoneNumber = null,
        ?RequestOptions $requestOptions = null,
    ): Cursor {
        $params = Util::removeNulls(
            ['cursor' => $cursor, 'limit' => $limit, 'phoneNumber' => $phoneNumber]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get contact by phone number
     *
     * @param string $phoneNumber E.164 phone number.
     *
     * @throws APIException
     */
    public function retrieveByPhone(
        string $phoneNumber,
        ?RequestOptions $requestOptions = null
    ): Contact {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveByPhone($phoneNumber, requestOptions: $requestOptions);

        return $response->parse();
    }
}
