<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Conversations\ConversationGetResponse;
use Zavudev\Conversations\ConversationListMessagesParams;
use Zavudev\Conversations\ConversationListParams;
use Zavudev\Conversations\ConversationListResponse;
use Zavudev\Conversations\ConversationMarkAsReadResponse;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\Messages\Message;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface ConversationsRawContract
{
    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ConversationGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $conversationID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ConversationListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<ConversationListResponse>>
     *
     * @throws APIException
     */
    public function list(
        array|ConversationListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ConversationListMessagesParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<Message>>
     *
     * @throws APIException
     */
    public function listMessages(
        string $conversationID,
        array|ConversationListMessagesParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ConversationMarkAsReadResponse>
     *
     * @throws APIException
     */
    public function markAsRead(
        string $conversationID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
