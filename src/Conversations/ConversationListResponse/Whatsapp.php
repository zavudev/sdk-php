<?php

declare(strict_types=1);

namespace Zavudev\Conversations\ConversationListResponse;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * WhatsApp identity, present when the contact adopted a username.
 *
 * @phpstan-type WhatsappShape = array{bsuid?: string|null, username?: string|null}
 */
final class Whatsapp implements BaseModel
{
    /** @use SdkModel<WhatsappShape> */
    use SdkModel;

    /**
     * Business-scoped user ID. Can be used as `to` when sending.
     */
    #[Optional]
    public ?string $bsuid;

    #[Optional]
    public ?string $username;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?string $bsuid = null,
        ?string $username = null
    ): self {
        $self = new self;

        null !== $bsuid && $self['bsuid'] = $bsuid;
        null !== $username && $self['username'] = $username;

        return $self;
    }

    /**
     * Business-scoped user ID. Can be used as `to` when sending.
     */
    public function withBsuid(string $bsuid): self
    {
        $self = clone $this;
        $self['bsuid'] = $bsuid;

        return $self;
    }

    public function withUsername(string $username): self
    {
        $self = clone $this;
        $self['username'] = $username;

        return $self;
    }
}
