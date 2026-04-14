<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts;

use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Cursor;
use Zavudev\Invitations\Invitation;
use Zavudev\Invitations\InvitationCancelResponse;
use Zavudev\Invitations\InvitationCreateParams;
use Zavudev\Invitations\InvitationGetResponse;
use Zavudev\Invitations\InvitationListParams;
use Zavudev\Invitations\InvitationNewResponse;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface InvitationsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|InvitationCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvitationNewResponse>
     *
     * @throws APIException
     */
    public function create(
        array|InvitationCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvitationGetResponse>
     *
     * @throws APIException
     */
    public function retrieve(
        string $invitationID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|InvitationListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Cursor<Invitation>>
     *
     * @throws APIException
     */
    public function list(
        array|InvitationListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<InvitationCancelResponse>
     *
     * @throws APIException
     */
    public function cancel(
        string $invitationID,
        RequestOptions|array|null $requestOptions = null
    ): BaseResponse;
}
