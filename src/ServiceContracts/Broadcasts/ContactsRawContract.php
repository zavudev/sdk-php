<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Broadcasts;

use Zavudev\Broadcasts\BroadcastContact;
use Zavudev\Broadcasts\Contacts\ContactAddParams;
use Zavudev\Broadcasts\Contacts\ContactAddResponse;
use Zavudev\Broadcasts\Contacts\ContactListParams;
use Zavudev\Broadcasts\Contacts\ContactRemoveParams;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;

interface ContactsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|ContactListParams $params
     *
     * @return BaseResponse<Cursor<BroadcastContact>>
     *
     * @throws APIException
     */
    public function list(
        string $broadcastID,
        array|ContactListParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ContactAddParams $params
     *
     * @return BaseResponse<ContactAddResponse>
     *
     * @throws APIException
     */
    public function add(
        string $broadcastID,
        array|ContactAddParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $contactID Broadcast contact ID (not the global contact ID)
     * @param array<string,mixed>|ContactRemoveParams $params
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function remove(
        string $contactID,
        array|ContactRemoveParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
