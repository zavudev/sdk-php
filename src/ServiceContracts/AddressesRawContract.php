<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Addresses\Address;
use Zavudev\Addresses\AddressCreateParams;
use Zavudev\Addresses\AddressGetResponse;
use Zavudev\Addresses\AddressListParams;
use Zavudev\Addresses\AddressNewResponse;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;

interface AddressesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|AddressCreateParams $params
     *
     * @return BaseResponse<AddressNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|AddressCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<AddressGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $addressID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|AddressListParams $params
     *
     * @return BaseResponse<Cursor<Address>>
     *
     * @throws APIException
     */
    public function list(
        array|AddressListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $addressID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
