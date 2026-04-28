<?php

declare(strict_types=1);

namespace Zavudev\SubAccounts;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Create a new sub-account (project) with its own API key. All charges are billed to the parent team's balance. Use creditLimit to set a spending cap. The sub-account's API key is returned only in the creation response. Requires a parent project API key; sub-account API keys receive HTTP 403.
 *
 * @see Zavudev\Services\SubAccountsService::create()
 *
 * @phpstan-type SubAccountCreateParamsShape = array{
 *   name: string,
 *   creditLimit?: int|null,
 *   externalID?: string|null,
 *   metadata?: array<string,mixed>|null,
 * }
 */
final class SubAccountCreateParams implements BaseModel
{
    /** @use SdkModel<SubAccountCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Name of the sub-account.
     */
    #[Required]
    public string $name;

    /**
     * Spending cap in cents. When reached, messages from this sub-account will be blocked. Omit or set to 0 for no limit.
     */
    #[Optional]
    public ?int $creditLimit;

    /**
     * External reference ID for your own tracking.
     */
    #[Optional('externalId')]
    public ?string $externalID;

    /** @var array<string,mixed>|null $metadata */
    #[Optional(map: 'mixed')]
    public ?array $metadata;

    /**
     * `new SubAccountCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SubAccountCreateParams::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SubAccountCreateParams)->withName(...)
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
     * @param array<string,mixed>|null $metadata
     */
    public static function with(
        string $name,
        ?int $creditLimit = null,
        ?string $externalID = null,
        ?array $metadata = null,
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $creditLimit && $self['creditLimit'] = $creditLimit;
        null !== $externalID && $self['externalID'] = $externalID;
        null !== $metadata && $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Name of the sub-account.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Spending cap in cents. When reached, messages from this sub-account will be blocked. Omit or set to 0 for no limit.
     */
    public function withCreditLimit(int $creditLimit): self
    {
        $self = clone $this;
        $self['creditLimit'] = $creditLimit;

        return $self;
    }

    /**
     * External reference ID for your own tracking.
     */
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
}
