<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
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
use Zavudev\Senders\SenderUploadProfilePictureParams\MimeType;
use Zavudev\Senders\SenderUploadProfilePictureResponse;
use Zavudev\Senders\WebhookEvent;
use Zavudev\Senders\WebhookSecretResponse;
use Zavudev\Senders\WhatsappBusinessProfileResponse;
use Zavudev\Senders\WhatsappBusinessProfileVertical;
use Zavudev\ServiceContracts\SendersRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class SendersRawService implements SendersRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Create sender
     *
     * @param array{
     *   name: string,
     *   phoneNumber: string,
     *   setAsDefault?: bool,
     *   webhookEvents?: list<WebhookEvent|value-of<WebhookEvent>>,
     *   webhookURL?: string,
     * }|SenderCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Sender>
     *
     * @throws APIException
     */
    public function create(
        array|SenderCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SenderCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/senders',
            body: (object) $parsed,
            options: $options,
            convert: Sender::class,
        );
    }

    /**
     * @api
     *
     * Get sender
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/senders/%1$s', $senderID],
            options: $requestOptions,
            convert: Sender::class,
        );
    }

    /**
     * @api
     *
     * Update sender
     *
     * @param array{
     *   emailReceivingEnabled?: bool,
     *   name?: string,
     *   setAsDefault?: bool,
     *   webhookActive?: bool,
     *   webhookEvents?: list<WebhookEvent|value-of<WebhookEvent>>,
     *   webhookURL?: string|null,
     * }|SenderUpdateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = SenderUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v1/senders/%1$s', $senderID],
            body: (object) $parsed,
            options: $options,
            convert: Sender::class,
        );
    }

    /**
     * @api
     *
     * List senders
     *
     * @param array{cursor?: string, limit?: int}|SenderListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<Sender>>
     *
     * @throws APIException
     */
    public function list(
        array|SenderListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SenderListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/senders',
            query: $parsed,
            options: $options,
            convert: Sender::class,
            page: Cursor::class,
        );
    }

    /**
     * @api
     *
     * Delete sender
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/senders/%1$s', $senderID],
            options: $requestOptions,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Get the WhatsApp Business profile for a sender. The sender must have a WhatsApp Business Account connected.
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/senders/%1$s/profile', $senderID],
            options: $requestOptions,
            convert: WhatsappBusinessProfileResponse::class,
        );
    }

    /**
     * @api
     *
     * Regenerate the webhook secret for a sender. The old secret will be invalidated immediately.
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
    ): BaseResponse {
        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/senders/%1$s/webhook/secret', $senderID],
            options: $requestOptions,
            convert: WebhookSecretResponse::class,
        );
    }

    /**
     * @api
     *
     * Update the WhatsApp Business profile for a sender. The sender must have a WhatsApp Business Account connected.
     *
     * @param array{
     *   about?: string,
     *   address?: string,
     *   description?: string,
     *   email?: string,
     *   vertical?: value-of<WhatsappBusinessProfileVertical>,
     *   websites?: list<string>,
     * }|SenderUpdateProfileParams $params
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
    ): BaseResponse {
        [$parsed, $options] = SenderUpdateProfileParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v1/senders/%1$s/profile', $senderID],
            body: (object) $parsed,
            options: $options,
            convert: SenderUpdateProfileResponse::class,
        );
    }

    /**
     * @api
     *
     * Upload a new profile picture for the WhatsApp Business profile. The image will be uploaded to Meta and set as the profile picture.
     *
     * @param array{
     *   imageURL: string, mimeType: MimeType|value-of<MimeType>
     * }|SenderUploadProfilePictureParams $params
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
    ): BaseResponse {
        [$parsed, $options] = SenderUploadProfilePictureParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/senders/%1$s/profile/picture', $senderID],
            body: (object) $parsed,
            options: $options,
            convert: SenderUploadProfilePictureResponse::class,
        );
    }
}
