<?php

declare(strict_types=1);

namespace Zavudev\ServiceContracts\Contacts;

use Zavudev\Contacts\Channels\ChannelAddParams\Channel;
use Zavudev\Contacts\Channels\ChannelAddResponse;
use Zavudev\Contacts\Channels\ChannelSetPrimaryResponse;
use Zavudev\Contacts\Channels\ChannelUpdateResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
interface ChannelsContract
{
    /**
     * @api
     *
     * @param string $channelID path param: Channel ID
     * @param string $contactID Path param
     * @param string|null $label Body param: Optional label for the channel. Set to null to clear.
     * @param array<string,string> $metadata Body param
     * @param bool $verified body param: Whether the channel is verified
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $channelID,
        string $contactID,
        ?string $label = null,
        ?array $metadata = null,
        ?bool $verified = null,
        RequestOptions|array|null $requestOptions = null,
    ): ChannelUpdateResponse;

    /**
     * @api
     *
     * @param Channel|value-of<Channel> $channel channel type
     * @param string $identifier Channel identifier (phone number in E.164 format or email address).
     * @param string $countryCode ISO country code for phone numbers
     * @param bool $isPrimary whether this should be the primary channel for its type
     * @param string $label optional label for the channel
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function add(
        string $contactID,
        Channel|string $channel,
        string $identifier,
        ?string $countryCode = null,
        bool $isPrimary = false,
        ?string $label = null,
        RequestOptions|array|null $requestOptions = null,
    ): ChannelAddResponse;

    /**
     * @api
     *
     * @param string $channelID channel ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $channelID,
        string $contactID,
        RequestOptions|array|null $requestOptions = null,
    ): mixed;

    /**
     * @api
     *
     * @param string $channelID channel ID
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function setPrimary(
        string $channelID,
        string $contactID,
        RequestOptions|array|null $requestOptions = null,
    ): ChannelSetPrimaryResponse;
}
