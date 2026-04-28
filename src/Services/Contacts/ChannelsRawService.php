<?php

declare(strict_types=1);

namespace Zavudev\Services\Contacts;

use Zavudev\Client;
use Zavudev\Contacts\Channels\ChannelAddParams;
use Zavudev\Contacts\Channels\ChannelAddParams\Channel;
use Zavudev\Contacts\Channels\ChannelAddResponse;
use Zavudev\Contacts\Channels\ChannelRemoveParams;
use Zavudev\Contacts\Channels\ChannelSetPrimaryParams;
use Zavudev\Contacts\Channels\ChannelSetPrimaryResponse;
use Zavudev\Contacts\Channels\ChannelUpdateParams;
use Zavudev\Contacts\Channels\ChannelUpdateResponse;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\Contacts\ChannelsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class ChannelsRawService implements ChannelsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Update a contact's channel properties.
     *
     * @param string $channelID path param: Channel ID
     * @param array{
     *   contactID: string,
     *   label?: string|null,
     *   metadata?: array<string,string>,
     *   verified?: bool,
     * }|ChannelUpdateParams $params
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
    ): BaseResponse {
        [$parsed, $options] = ChannelUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $contactID = $parsed['contactID'];
        unset($parsed['contactID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'patch',
            path: ['v1/contacts/%1$s/channels/%2$s', $contactID, $channelID],
            body: (object) array_diff_key($parsed, array_flip(['contactID'])),
            options: $options,
            convert: ChannelUpdateResponse::class,
        );
    }

    /**
     * @api
     *
     * Add a new communication channel to an existing contact.
     *
     * @param array{
     *   channel: Channel|value-of<Channel>,
     *   identifier: string,
     *   countryCode?: string,
     *   isPrimary?: bool,
     *   label?: string,
     * }|ChannelAddParams $params
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
    ): BaseResponse {
        [$parsed, $options] = ChannelAddParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/contacts/%1$s/channels', $contactID],
            body: (object) $parsed,
            options: $options,
            convert: ChannelAddResponse::class,
        );
    }

    /**
     * @api
     *
     * Remove a communication channel from a contact. Cannot remove the last channel.
     *
     * @param string $channelID channel ID
     * @param array{contactID: string}|ChannelRemoveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = ChannelRemoveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $contactID = $parsed['contactID'];
        unset($parsed['contactID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/contacts/%1$s/channels/%2$s', $contactID, $channelID],
            options: $options,
            convert: null,
        );
    }

    /**
     * @api
     *
     * Set a channel as the primary channel for its type.
     *
     * @param string $channelID channel ID
     * @param array{contactID: string}|ChannelSetPrimaryParams $params
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
    ): BaseResponse {
        [$parsed, $options] = ChannelSetPrimaryParams::parseRequest(
            $params,
            $requestOptions,
        );
        $contactID = $parsed['contactID'];
        unset($parsed['contactID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/contacts/%1$s/channels/%2$s/primary', $contactID, $channelID],
            options: $options,
            convert: ChannelSetPrimaryResponse::class,
        );
    }
}
