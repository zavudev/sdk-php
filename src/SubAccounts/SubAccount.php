<?php

declare(strict_types=1);

namespace Zavudev\SubAccounts;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\SubAccounts\SubAccount\Status;

/**
 * @phpstan-type SubAccountShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   name: string,
 *   status: Status|value-of<Status>,
 *   totalSpent: int,
 *   apiKey?: string|null,
 *   creditLimit?: int|null,
 *   externalID?: string|null,
 *   metadata?: array<string,mixed>|null,
 * }
 */
final class SubAccount implements BaseModel
{
    /** @use SdkModel<SubAccountShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public string $name;

    /** @var value-of<Status> $status */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * Total amount spent by this sub-account in cents.
     */
    #[Required]
    public int $totalSpent;

    /**
     * API key for the sub-account. Only returned on creation.
     */
    #[Optional]
    public ?string $apiKey;

    /**
     * Spending cap in cents. When reached, messages from this sub-account will be blocked.
     */
    #[Optional(nullable: true)]
    public ?int $creditLimit;

    /**
     * External reference ID set by the parent account.
     */
    #[Optional('externalId', nullable: true)]
    public ?string $externalID;

    /** @var array<string,mixed>|null $metadata */
    #[Optional(map: 'mixed', nullable: true)]
    public ?array $metadata;

    /**
     * `new SubAccount()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SubAccount::with(
     *   id: ..., createdAt: ..., name: ..., status: ..., totalSpent: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SubAccount)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withName(...)
     *   ->withStatus(...)
     *   ->withTotalSpent(...)
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
     * @param Status|value-of<Status> $status
     * @param array<string,mixed>|null $metadata
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        string $name,
        Status|string $status,
        int $totalSpent,
        ?string $apiKey = null,
        ?int $creditLimit = null,
        ?string $externalID = null,
        ?array $metadata = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['name'] = $name;
        $self['status'] = $status;
        $self['totalSpent'] = $totalSpent;

        null !== $apiKey && $self['apiKey'] = $apiKey;
        null !== $creditLimit && $self['creditLimit'] = $creditLimit;
        null !== $externalID && $self['externalID'] = $externalID;
        null !== $metadata && $self['metadata'] = $metadata;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Total amount spent by this sub-account in cents.
     */
    public function withTotalSpent(int $totalSpent): self
    {
        $self = clone $this;
        $self['totalSpent'] = $totalSpent;

        return $self;
    }

    /**
     * API key for the sub-account. Only returned on creation.
     */
    public function withAPIKey(string $apiKey): self
    {
        $self = clone $this;
        $self['apiKey'] = $apiKey;

        return $self;
    }

    /**
     * Spending cap in cents. When reached, messages from this sub-account will be blocked.
     */
    public function withCreditLimit(?int $creditLimit): self
    {
        $self = clone $this;
        $self['creditLimit'] = $creditLimit;

        return $self;
    }

    /**
     * External reference ID set by the parent account.
     */
    public function withExternalID(?string $externalID): self
    {
        $self = clone $this;
        $self['externalID'] = $externalID;

        return $self;
    }

    /**
     * @param array<string,mixed>|null $metadata
     */
    public function withMetadata(?array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }
}
