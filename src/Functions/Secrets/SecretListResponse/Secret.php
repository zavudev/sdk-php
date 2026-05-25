<?php

declare(strict_types=1);

namespace Zavudev\Functions\Secrets\SecretListResponse;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type SecretShape = array{
 *   id: string,
 *   key: string,
 *   valueLast4: string,
 *   createdAt?: float|null,
 *   syncedToAws?: bool|null,
 *   updatedAt?: float|null,
 * }
 */
final class Secret implements BaseModel
{
    /** @use SdkModel<SecretShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public string $key;

    #[Required]
    public string $valueLast4;

    #[Optional]
    public ?float $createdAt;

    #[Optional]
    public ?bool $syncedToAws;

    #[Optional]
    public ?float $updatedAt;

    /**
     * `new Secret()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Secret::with(id: ..., key: ..., valueLast4: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Secret)->withID(...)->withKey(...)->withValueLast4(...)
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
        string $id,
        string $key,
        string $valueLast4,
        ?float $createdAt = null,
        ?bool $syncedToAws = null,
        ?float $updatedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['key'] = $key;
        $self['valueLast4'] = $valueLast4;

        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $syncedToAws && $self['syncedToAws'] = $syncedToAws;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withKey(string $key): self
    {
        $self = clone $this;
        $self['key'] = $key;

        return $self;
    }

    public function withValueLast4(string $valueLast4): self
    {
        $self = clone $this;
        $self['valueLast4'] = $valueLast4;

        return $self;
    }

    public function withCreatedAt(float $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withSyncedToAws(bool $syncedToAws): self
    {
        $self = clone $this;
        $self['syncedToAws'] = $syncedToAws;

        return $self;
    }

    public function withUpdatedAt(float $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
