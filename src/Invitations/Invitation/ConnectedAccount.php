<?php

declare(strict_types=1);

namespace Zavudev\Invitations\Invitation;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Invitations\Invitation\ConnectedAccount\Channel;

/**
 * The account the client linked, populated once the invitation is `completed`. Null before that. Use it to show the partner what was connected without fetching the sender.
 *
 * @phpstan-type ConnectedAccountShape = array{
 *   id: string, channel: Channel|value-of<Channel>, name?: string|null
 * }
 */
final class ConnectedAccount implements BaseModel
{
    /** @use SdkModel<ConnectedAccountShape> */
    use SdkModel;

    /**
     * Provider-side identifier: the WhatsApp phone number ID, or the Facebook Page ID.
     */
    #[Required]
    public string $id;

    /** @var value-of<Channel> $channel */
    #[Required(enum: Channel::class)]
    public string $channel;

    /**
     * Display name of the connected account: the WhatsApp verified name, or the Facebook Page name.
     */
    #[Optional(nullable: true)]
    public ?string $name;

    /**
     * `new ConnectedAccount()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ConnectedAccount::with(id: ..., channel: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ConnectedAccount)->withID(...)->withChannel(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Channel|value-of<Channel> $channel
     */
    public static function with(
        string $id,
        Channel|string $channel,
        ?string $name = null
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['channel'] = $channel;

        null !== $name && $self['name'] = $name;

        return $self;
    }

    /**
     * Provider-side identifier: the WhatsApp phone number ID, or the Facebook Page ID.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param Channel|value-of<Channel> $channel
     */
    public function withChannel(Channel|string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

        return $self;
    }

    /**
     * Display name of the connected account: the WhatsApp verified name, or the Facebook Page name.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
