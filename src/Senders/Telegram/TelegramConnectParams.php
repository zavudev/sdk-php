<?php

declare(strict_types=1);

namespace Zavudev\Senders\Telegram;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Connect a Telegram bot to a sender. Provide the bot token from @BotFather; Zavu validates it, registers the webhook, and routes the sender's Telegram messages through it.
 *
 * @see Zavudev\Services\Senders\TelegramService::connect()
 *
 * @phpstan-type TelegramConnectParamsShape = array{botToken: string}
 */
final class TelegramConnectParams implements BaseModel
{
    /** @use SdkModel<TelegramConnectParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Bot token from @BotFather.
     */
    #[Required]
    public string $botToken;

    /**
     * `new TelegramConnectParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TelegramConnectParams::with(botToken: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TelegramConnectParams)->withBotToken(...)
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
    public static function with(string $botToken): self
    {
        $self = new self;

        $self['botToken'] = $botToken;

        return $self;
    }

    /**
     * Bot token from @BotFather.
     */
    public function withBotToken(string $botToken): self
    {
        $self = clone $this;
        $self['botToken'] = $botToken;

        return $self;
    }
}
