<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Contacts;

use Zavudev\Contacts\Channels\ChannelAddParams;
use Zavudev\Contacts\Channels\ChannelAddResponse;
use Zavudev\Contacts\Channels\ChannelRemoveParams;
use Zavudev\Contacts\Channels\ChannelSetPrimaryParams;
use Zavudev\Contacts\Channels\ChannelSetPrimaryResponse;
use Zavudev\Contacts\Channels\ChannelUpdateParams;
use Zavudev\Contacts\Channels\ChannelUpdateResponse;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface ChannelsRawContract
{
    /**
     * @api
     *
     * @param string $channelID path param: Channel ID
     * @param array<string,mixed>|ChannelUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ChannelUpdateResponse>
     *
     * @throws APIException
     */
    public function update(
        string $channelID,
        array|ChannelUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|ChannelAddParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ChannelAddResponse>
     *
     * @throws APIException
     */
    public function add(
        string $contactID,
        array|ChannelAddParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $channelID channel ID
     * @param array<string,mixed>|ChannelRemoveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<mixed>
     *
     * @throws APIException
     */
    public function remove(
        string $channelID,
        array|ChannelRemoveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $channelID channel ID
     * @param array<string,mixed>|ChannelSetPrimaryParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ChannelSetPrimaryResponse>
     *
     * @throws APIException
     */
    public function setPrimary(
        string $channelID,
        array|ChannelSetPrimaryParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
