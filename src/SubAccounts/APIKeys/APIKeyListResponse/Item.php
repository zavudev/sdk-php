<?php

declare(strict_types=1);

namespace Zavudev\SubAccounts\APIKeys\APIKeyListResponse;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\SubAccounts\APIKeys\APIKeyListResponse\Item\Environment;

/**
 * @phpstan-type ItemShape = array{
 *   id: string,
 *   createdAt: float,
 *   environment: Environment|value-of<Environment>,
 *   keyPrefix: string,
 *   name: string,
 *   key?: string|null,
 *   lastUsedAt?: float|null,
 *   permissions?: list<string>|null,
 *   revokedAt?: float|null,
 * }
 */
final class Item implements BaseModel
{
    /** @use SdkModel<ItemShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public float $createdAt;

    /** @var value-of<Environment> $environment */
    #[Required(enum: Environment::class)]
    public string $environment;

    /**
     * First characters of the key for identification.
     */
    #[Required]
    public string $keyPrefix;

    #[Required]
    public string $name;

    /**
     * Full API key. Only returned on creation.
     */
    #[Optional]
    public ?string $key;

    #[Optional(nullable: true)]
    public ?float $lastUsedAt;

    /** @var list<string>|null $permissions */
    #[Optional(list: 'string')]
    public ?array $permissions;

    #[Optional(nullable: true)]
    public ?float $revokedAt;

    /**
     * `new Item()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Item::with(id: ..., createdAt: ..., environment: ..., keyPrefix: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Item)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withEnvironment(...)
     *   ->withKeyPrefix(...)
     *   ->withName(...)
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
     * @param Environment|value-of<Environment> $environment
     * @param list<string>|null $permissions
     */
    public static function with(
        string $id,
        float $createdAt,
        Environment|string $environment,
        string $keyPrefix,
        string $name,
        ?string $key = null,
        ?float $lastUsedAt = null,
        ?array $permissions = null,
        ?float $revokedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['environment'] = $environment;
        $self['keyPrefix'] = $keyPrefix;
        $self['name'] = $name;

        null !== $key && $self['key'] = $key;
        null !== $lastUsedAt && $self['lastUsedAt'] = $lastUsedAt;
        null !== $permissions && $self['permissions'] = $permissions;
        null !== $revokedAt && $self['revokedAt'] = $revokedAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(float $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * @param Environment|value-of<Environment> $environment
     */
    public function withEnvironment(Environment|string $environment): self
    {
        $self = clone $this;
        $self['environment'] = $environment;

        return $self;
    }

    /**
     * First characters of the key for identification.
     */
    public function withKeyPrefix(string $keyPrefix): self
    {
        $self = clone $this;
        $self['keyPrefix'] = $keyPrefix;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Full API key. Only returned on creation.
     */
    public function withKey(string $key): self
    {
        $self = clone $this;
        $self['key'] = $key;

        return $self;
    }

    public function withLastUsedAt(?float $lastUsedAt): self
    {
        $self = clone $this;
        $self['lastUsedAt'] = $lastUsedAt;

        return $self;
    }

    /**
     * @param list<string> $permissions
     */
    public function withPermissions(array $permissions): self
    {
        $self = clone $this;
        $self['permissions'] = $permissions;

        return $self;
    }

    public function withRevokedAt(?float $revokedAt): self
    {
        $self = clone $this;
        $self['revokedAt'] = $revokedAt;

        return $self;
    }
}
