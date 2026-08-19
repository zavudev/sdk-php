<?php

declare(strict_types=1);

namespace Zavudev\Senders\Telegram;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\Telegram\TelegramConnectResponse\Telegram;

/**
 * @phpstan-import-type TelegramShape from \Zavudev\Senders\Telegram\TelegramConnectResponse\Telegram
 *
 * @phpstan-type TelegramConnectResponseShape = array{
 *   telegram: Telegram|TelegramShape
 * }
 */
final class TelegramConnectResponse implements BaseModel
{
    /** @use SdkModel<TelegramConnectResponseShape> */
    use SdkModel;

    #[Required]
    public Telegram $telegram;

    /**
     * `new TelegramConnectResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TelegramConnectResponse::with(telegram: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TelegramConnectResponse)->withTelegram(...)
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
     * @param Telegram|TelegramShape $telegram
     */
    public static function with(Telegram|array $telegram): self
    {
        $self = new self;

        $self['telegram'] = $telegram;

        return $self;
    }

    /**
     * @param Telegram|TelegramShape $telegram
     */
    public function withTelegram(Telegram|array $telegram): self
    {
        $self = clone $this;
        $self['telegram'] = $telegram;

        return $self;
    }
}
