<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Contacts\Contact;
use Zavudev\Contacts\ContactListParams;
use Zavudev\Contacts\ContactUpdateParams;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;

interface ContactsRawContract
{
    /**
     * @api
     *
     * @return BaseResponse<Contact>
     *
     * @throws APIException
     */
    public function retrieve(
        string $contactID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ContactUpdateParams $params
     *
     * @return BaseResponse<Contact>
     *
     * @throws APIException
     */
    public function update(
        string $contactID,
        array|ContactUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ContactListParams $params
     *
     * @return BaseResponse<Cursor<Contact>>
     *
     * @throws APIException
     */
    public function list(
        array|ContactListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $phoneNumber E.164 phone number.
     *
     * @return BaseResponse<Contact>
     *
     * @throws APIException
     */
    public function retrieveByPhone(
        string $phoneNumber,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
