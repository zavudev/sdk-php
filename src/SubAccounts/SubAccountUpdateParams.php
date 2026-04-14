<?php

declare(strict_types=1);

namespace Zavudev\SubAccounts;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\SubAccounts\SubAccountUpdateParams\Status;

/**
 * Update sub-account.
 *
 * @see Zavudev\Services\SubAccountsService::update()
 *
 * @phpstan-type SubAccountUpdateParamsShape = array{
 *   creditLimit?: int|null,
 *   externalID?: string|null,
 *   metadata?: array<string,mixed>|null,
 *   name?: string|null,
 *   status?: null|Status|value-of<Status>,
 * }
 */
final class SubAccountUpdateParams implements BaseModel
{
    /** @use SdkModel<SubAccountUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional(nullable: true)]
    public ?int $creditLimit;

    #[Optional('externalId')]
    public ?string $externalID;

    /** @var array<string,mixed>|null $metadata */
    #[Optional(map: 'mixed')]
    public ?array $metadata;

    #[Optional]
    public ?string $name;

    /** @var value-of<Status>|null $status */
    #[Optional(enum: Status::class)]
    public ?string $status;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,mixed>|null $metadata
     * @param Status|value-of<Status>|null $status
     */
    public static function with(
        ?int $creditLimit = null,
        ?string $externalID = null,
        ?array $metadata = null,
        ?string $name = null,
        Status|string|null $status = null,
    ): self {
        $self = new self;

        null !== $creditLimit && $self['creditLimit'] = $creditLimit;
        null !== $externalID && $self['externalID'] = $externalID;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $name && $self['name'] = $name;
        null !== $status && $self['status'] = $status;

        return $self;
    }

    public function withCreditLimit(?int $creditLimit): self
    {
        $self = clone $this;
        $self['creditLimit'] = $creditLimit;

        return $self;
    }

    public function withExternalID(string $externalID): self
    {
        $self = clone $this;
        $self['externalID'] = $externalID;

        return $self;
    }

    /**
     * @param array<string,mixed> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

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
}
