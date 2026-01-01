<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Contacts\Contact;
use Zavudev\Contacts\ContactUpdateParams\DefaultChannel;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;

interface ContactsContract
{
    /**
     * @api
     *
     * @throws APIException
     */
    public function retrieve(
        string $contactID,
        ?RequestOptions $requestOptions = null
    ): Contact;

    /**
     * @api
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
    ): Contact;

    /**
     * @api
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
    ): Cursor;

    /**
     * @api
     *
     * @param string $phoneNumber E.164 phone number.
     *
     * @throws APIException
     */
    public function retrieveByPhone(
        string $phoneNumber,
        ?RequestOptions $requestOptions = null
    ): Contact;
}
