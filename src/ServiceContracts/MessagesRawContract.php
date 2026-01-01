<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\Messages\Message;
use Zavudev\Messages\MessageListParams;
use Zavudev\Messages\MessageReactParams;
use Zavudev\Messages\MessageResponse;
use Zavudev\Messages\MessageSendParams;
use Zavudev\RequestOptions;

interface MessagesRawContract
{
    /**
     * @api
     *
     * @return BaseResponse<MessageResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $messageID,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|MessageListParams $params
     *
     * @return BaseResponse<Cursor<Message>>
     *
     * @throws APIException
     */
    public function list(
        array|MessageListParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $messageID Path param:
     * @param array<string,mixed>|MessageReactParams $params
     *
     * @return BaseResponse<MessageResponse>
     *
     * @throws APIException
     */
    public function react(
        string $messageID,
        array|MessageReactParams $params,
        ?RequestOptions $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|MessageSendParams $params
     *
     * @return BaseResponse<MessageResponse>
     *
     * @throws APIException
     */
    public function send(
        array|MessageSendParams $params,
        ?RequestOptions $requestOptions = null
    ): BaseResponse;
}
