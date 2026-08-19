<?php

declare(strict_types=1);

namespace Zavudev\Senders\Telegram\TelegramConnectResponse;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type TelegramShape = array{
 *   connected: bool, botID?: string|null, botUsername?: string|null
 * }
 */
final class Telegram implements BaseModel
{
    /** @use SdkModel<TelegramShape> */
    use SdkModel;

    #[Required]
    public bool $connected;

    #[Optional('botId')]
    public ?string $botID;

    #[Optional]
    public ?string $botUsername;

    /**
     * `new Telegram()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Telegram::with(connected: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Telegram)->withConnected(...)
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
     */
    public static function with(
        bool $connected,
        ?string $botID = null,
        ?string $botUsername = null
    ): self {
        $self = new self;

        $self['connected'] = $connected;

        null !== $botID && $self['botID'] = $botID;
        null !== $botUsername && $self['botUsername'] = $botUsername;

        return $self;
    }

    public function withConnected(bool $connected): self
    {
        $self = clone $this;
        $self['connected'] = $connected;

        return $self;
    }

    public function withBotID(string $botID): self
    {
        $self = clone $this;
        $self['botID'] = $botID;

        return $self;
    }

    public function withBotUsername(string $botUsername): self
    {
        $self = clone $this;
        $self['botUsername'] = $botUsername;

        return $self;
    }
}
