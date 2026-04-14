<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Contacts\Contact;
use Zavudev\Contacts\ContactCreateParams\Channel1 as Channel;
use Zavudev\Contacts\ContactUpdateParams\DefaultChannel;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\ContactsContract;
use Zavudev\Services\Contacts\ChannelsService;

/**
 * @phpstan-import-type Channel1Shape from \Zavudev\Contacts\ContactCreateParams\Channel1
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class ContactsService implements ContactsContract
{
    /**
     * @api
     */
    public ContactsRawService $raw;

    /**
     * @api
     */
    public ChannelsService $channels;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ContactsRawService($client);
        $this->channels = new ChannelsService($client);
    }

    /**
     * @api
     *
     * Create a new contact with one or more communication channels.
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
    ): Contact {
        $params = Util::removeNulls(
            [
                'channels' => $channels,
                'displayName' => $displayName,
                'metadata' => $metadata,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->create(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get contact
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $contactID,
        RequestOptions|array|null $requestOptions = null
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
     * List contacts with their communication channels.
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
     * Dismiss the merge suggestion for a contact.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function dismissMergeSuggestion(
        string $contactID,
        RequestOptions|array|null $requestOptions = null
    ): mixed {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->dismissMergeSuggestion($contactID, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Merge a source contact into this contact. All channels from the source contact will be moved to the target contact, and the source contact will be marked as merged.
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
    ): Contact {
        $params = Util::removeNulls(['sourceContactID' => $sourceContactID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->merge($contactID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get contact by phone number
     *
     * @param string $phoneNumber E.164 phone number.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieveByPhone(
        string $phoneNumber,
        RequestOptions|array|null $requestOptions = null
    ): Contact {
        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieveByPhone($phoneNumber, requestOptions: $requestOptions);

        return $response->parse();
    }
}
