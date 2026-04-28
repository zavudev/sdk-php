<?php

declare(strict_types=1);

namespace Zavudev\Usage;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Usage\UsageGetResponse\Limits;
use Zavudev\Usage\UsageGetResponse\Tier;

/**
 * @phpstan-import-type LimitsShape from \Zavudev\Usage\UsageGetResponse\Limits
 *
 * @phpstan-type UsageGetResponseShape = array{
 *   emailsSent: int,
 *   limits: Limits|LimitsShape,
 *   messagesA2P: int,
 *   monthKey: string,
 *   tier: Tier|value-of<Tier>,
 * }
 */
final class UsageGetResponse implements BaseModel
{
    /** @use SdkModel<UsageGetResponseShape> */
    use SdkModel;

    /**
     * Emails sent this month.
     */
    #[Required]
    public int $emailsSent;

    #[Required]
    public Limits $limits;

    /**
     * A2P messages sent this month (WhatsApp replies + Telegram).
     */
    #[Required]
    public int $messagesA2P;

    /**
     * Current month in YYYY-MM format.
     */
    #[Required]
    public string $monthKey;

    /** @var value-of<Tier> $tier */
    #[Required(enum: Tier::class)]
    public string $tier;

    /**
     * `new UsageGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UsageGetResponse::with(
     *   emailsSent: ..., limits: ..., messagesA2P: ..., monthKey: ..., tier: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UsageGetResponse)
     *   ->withEmailsSent(...)
     *   ->withLimits(...)
     *   ->withMessagesA2P(...)
     *   ->withMonthKey(...)
     *   ->withTier(...)
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
     * @param Limits|LimitsShape $limits
     * @param Tier|value-of<Tier> $tier
     */
    public static function with(
        int $emailsSent,
        Limits|array $limits,
        int $messagesA2P,
        string $monthKey,
        Tier|string $tier,
    ): self {
        $self = new self;

        $self['emailsSent'] = $emailsSent;
        $self['limits'] = $limits;
        $self['messagesA2P'] = $messagesA2P;
        $self['monthKey'] = $monthKey;
        $self['tier'] = $tier;

        return $self;
    }

    /**
     * Emails sent this month.
     */
    public function withEmailsSent(int $emailsSent): self
    {
        $self = clone $this;
        $self['emailsSent'] = $emailsSent;

        return $self;
    }

    /**
     * @param Limits|LimitsShape $limits
     */
    public function withLimits(Limits|array $limits): self
    {
        $self = clone $this;
        $self['limits'] = $limits;

        return $self;
    }

    /**
     * A2P messages sent this month (WhatsApp replies + Telegram).
     */
    public function withMessagesA2P(int $messagesA2P): self
    {
        $self = clone $this;
        $self['messagesA2P'] = $messagesA2P;

        return $self;
    }

    /**
     * Current month in YYYY-MM format.
     */
    public function withMonthKey(string $monthKey): self
    {
        $self = clone $this;
        $self['monthKey'] = $monthKey;

        return $self;
    }

    /**
     * @param Tier|value-of<Tier> $tier
     */
    public function withTier(Tier|string $tier): self
    {
        $self = clone $this;
        $self['tier'] = $tier;

        return $self;
    }
}
