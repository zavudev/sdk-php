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

interface SendersRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|SenderCreateParams $params
     *
     * @return BaseResponse<Sender>
     *
     * @throws APIException
     */
    public function create(
        array|SenderCreateParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<Sender>
     *
     * @throws APIException
     */
    public function retrieve(
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SenderUpdateParams $params
     *
     * @return BaseResponse<Sender>
     *
     * @throws APIException
     */
    public function update(
        string $senderID,
        array|SenderUpdateParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SenderListParams $params
     *
     * @return BaseResponse<Cursor<Sender>>
     *
     * @throws APIException
     */
    public function list(
        array|SenderListParams $params,
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
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<WhatsappBusinessProfileResponse>
     *
     * @throws APIException
     */
    public function getProfile(
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @return BaseResponse<WebhookSecretResponse>
     *
     * @throws APIException
     */
    public function regenerateWebhookSecret(
        string $senderID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SenderUpdateProfileParams $params
     *
     * @return BaseResponse<SenderUpdateProfileResponse>
     *
     * @throws APIException
     */
    public function updateProfile(
        string $senderID,
        array|SenderUpdateProfileParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SenderUploadProfilePictureParams $params
     *
     * @return BaseResponse<SenderUploadProfilePictureResponse>
     *
     * @throws APIException
     */
    public function uploadProfilePicture(
        string $senderID,
        array|SenderUploadProfilePictureParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;
}
