<?php

declare(strict_types=1);

namespace Zavudev\Services\Contacts;

use Zavudev\Client;
use Zavudev\Contacts\Channels\ChannelAddParams\Channel;
use Zavudev\Contacts\Channels\ChannelAddResponse;
use Zavudev\Contacts\Channels\ChannelSetPrimaryResponse;
use Zavudev\Contacts\Channels\ChannelUpdateResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\Contacts\ChannelsContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class ChannelsService implements ChannelsContract
{
    /**
     * @api
     */
    public ChannelsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ChannelsRawService($client);
    }

    /**
     * @api
     *
     * Update a contact's channel properties.
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
    ): ChannelUpdateResponse {
        $params = Util::removeNulls(
            [
                'contactID' => $contactID,
                'label' => $label,
                'metadata' => $metadata,
                'verified' => $verified,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($channelID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Add a new communication channel to an existing contact.
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
    ): ChannelAddResponse {
        $params = Util::removeNulls(
            [
                'channel' => $channel,
                'identifier' => $identifier,
                'countryCode' => $countryCode,
                'isPrimary' => $isPrimary,
                'label' => $label,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->add($contactID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Remove a communication channel from a contact. Cannot remove the last channel.
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
    ): mixed {
        $params = Util::removeNulls(['contactID' => $contactID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->remove($channelID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Set a channel as the primary channel for its type.
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
    ): ChannelSetPrimaryResponse {
        $params = Util::removeNulls(['contactID' => $contactID]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->setPrimary($channelID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
