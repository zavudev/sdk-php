<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\RequestOptions;
use Zavudev\Senders\Sender;
use Zavudev\Senders\SenderCreateParams;
use Zavudev\Senders\SenderListParams;
use Zavudev\Senders\SenderUpdateParams;
use Zavudev\Senders\SenderUpdateProfileParams;
use Zavudev\Senders\SenderUpdateProfileResponse;
use Zavudev\Senders\SenderUploadProfilePictureParams;
use Zavudev\Senders\SenderUploadProfilePictureResponse;
use Zavudev\Senders\WebhookSecretResponse;
use Zavudev\Senders\WhatsappBusinessProfileResponse;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface SendersRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|SenderCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Sender>
     *
     * @throws APIException
     */
    public function create(
        array|SenderCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Sender>
     *
     * @throws APIException
     */
    public function retrieve(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SenderUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Sender>
     *
     * @throws APIException
     */
    public function update(
        string $senderID,
        array|SenderUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SenderListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<Sender>>
     *
     * @throws APIException
     */
    public function list(
        array|SenderListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function delete(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WhatsappBusinessProfileResponse>
     *
     * @throws APIException
     */
    public function getProfile(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WebhookSecretResponse>
     *
     * @throws APIException
     */
    public function regenerateWebhookSecret(
        string $senderID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SenderUpdateProfileParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SenderUpdateProfileResponse>
     *
     * @throws APIException
     */
    public function updateProfile(
        string $senderID,
        array|SenderUpdateProfileParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SenderUploadProfilePictureParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SenderUploadProfilePictureResponse>
     *
     * @throws APIException
     */
    public function uploadProfilePicture(
        string $senderID,
        array|SenderUploadProfilePictureParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
