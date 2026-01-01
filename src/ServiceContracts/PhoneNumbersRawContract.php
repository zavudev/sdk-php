<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\PhoneNumbers\OwnedPhoneNumber;
use Zavudev\PhoneNumbers\PhoneNumberGetResponse;
use Zavudev\PhoneNumbers\PhoneNumberListParams;
use Zavudev\PhoneNumbers\PhoneNumberPurchaseParams;
use Zavudev\PhoneNumbers\PhoneNumberPurchaseResponse;
use Zavudev\PhoneNumbers\PhoneNumberRequirementsParams;
use Zavudev\PhoneNumbers\PhoneNumberRequirementsResponse;
use Zavudev\PhoneNumbers\PhoneNumberSearchAvailableParams;
use Zavudev\PhoneNumbers\PhoneNumberSearchAvailableResponse;
use Zavudev\PhoneNumbers\PhoneNumberUpdateParams;
use Zavudev\PhoneNumbers\PhoneNumberUpdateResponse;
use Zavudev\RequestOptions;

interface PhoneNumbersRawContract
{
    /**
     * @api
     *
     * @return BaseResponse<PhoneNumberGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $phoneNumberID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|PhoneNumberUpdateParams $params
     *
     * @return BaseResponse<PhoneNumberUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $phoneNumberID,
        array|PhoneNumberUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|PhoneNumberListParams $params
     *
     * @return BaseResponse<Cursor<OwnedPhoneNumber>>
     *
     * @throws APIException
     */
    public function list(
        array|PhoneNumberListParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|PhoneNumberPurchaseParams $params
     *
     * @return BaseResponse<PhoneNumberPurchaseResponse>
     *
     * @throws APIException
     */
    public function purchase(
        array|PhoneNumberPurchaseParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function release(
        string $phoneNumberID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|PhoneNumberRequirementsParams $params
     *
     * @return BaseResponse<PhoneNumberRequirementsResponse>
     *
     * @throws APIException
     */
    public function requirements(
        array|PhoneNumberRequirementsParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|PhoneNumberSearchAvailableParams $params
     *
     * @return BaseResponse<PhoneNumberSearchAvailableResponse>
     *
     * @throws APIException
     */
    public function searchAvailable(
        array|PhoneNumberSearchAvailableParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
