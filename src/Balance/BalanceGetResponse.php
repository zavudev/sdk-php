<?php

declare(strict_types=1);

namespace Zavudev\Balance;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type BalanceGetResponseShape = array{
 *   balance: int,
 *   currency: string,
 *   creditLimit?: int|null,
 *   isSubAccount?: bool|null,
 *   totalSpent?: int|null,
 * }
 */
final class BalanceGetResponse implements BaseModel
{
    /** @use SdkModel<BalanceGetResponseShape> */
    use SdkModel;

    /**
     * Team balance in cents. All charges are billed to the parent team.
     */
    #[Required]
    public int $balance;

    #[Required]
    public string $currency;

    /**
     * Spending cap in cents (only for sub-accounts).
     */
    #[Optional(nullable: true)]
    public ?int $creditLimit;

    /**
     * Whether this API key belongs to a sub-account.
     */
    #[Optional]
    public ?bool $isSubAccount;

    /**
     * Total amount spent by this sub-account in cents (only for sub-accounts).
     */
    #[Optional(nullable: true)]
    public ?int $totalSpent;

    /**
     * `new BalanceGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BalanceGetResponse::with(balance: ..., currency: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BalanceGetResponse)->withBalance(...)->withCurrency(...)
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
        int $balance,
        string $currency,
        ?int $creditLimit = null,
        ?bool $isSubAccount = null,
        ?int $totalSpent = null,
    ): self {
        $self = new self;

        $self['balance'] = $balance;
        $self['currency'] = $currency;

        null !== $creditLimit && $self['creditLimit'] = $creditLimit;
        null !== $isSubAccount && $self['isSubAccount'] = $isSubAccount;
        null !== $totalSpent && $self['totalSpent'] = $totalSpent;

        return $self;
    }

    /**
     * Team balance in cents. All charges are billed to the parent team.
     */
    public function withBalance(int $balance): self
    {
        $self = clone $this;
        $self['balance'] = $balance;

        return $self;
    }

    public function withCurrency(string $currency): self
    {
        $self = clone $this;
        $self['currency'] = $currency;

        return $self;
    }

    /**
     * Spending cap in cents (only for sub-accounts).
     */
    public function withCreditLimit(?int $creditLimit): self
    {
        $self = clone $this;
        $self['creditLimit'] = $creditLimit;

        return $self;
    }

    /**
     * Whether this API key belongs to a sub-account.
     */
    public function withIsSubAccount(bool $isSubAccount): self
    {
        $self = clone $this;
        $self['isSubAccount'] = $isSubAccount;

        return $self;
    }

    /**
     * Total amount spent by this sub-account in cents (only for sub-accounts).
     */
    public function withTotalSpent(?int $totalSpent): self
    {
        $self = clone $this;
        $self['totalSpent'] = $totalSpent;

        return $self;
    }
}
