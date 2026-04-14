<?php

declare(strict_types=1);

namespace Zavudev\SubAccounts\APIKeys;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\SubAccounts\APIKeys\APIKeyCreateParams\Environment;

/**
 * Create sub-account API key.
 *
 * @see Zavudev\Services\SubAccounts\APIKeysService::create()
 *
 * @phpstan-type APIKeyCreateParamsShape = array{
 *   name: string,
 *   environment?: null|Environment|value-of<Environment>,
 *   permissions?: list<string>|null,
 * }
 */
final class APIKeyCreateParams implements BaseModel
{
    /** @use SdkModel<APIKeyCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $name;

    /** @var value-of<Environment>|null $environment */
    #[Optional(enum: Environment::class)]
    public ?string $environment;

    /** @var list<string>|null $permissions */
    #[Optional(list: 'string')]
    public ?array $permissions;

    /**
     * `new APIKeyCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * APIKeyCreateParams::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new APIKeyCreateParams)->withName(...)
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
     * @param Environment|value-of<Environment>|null $environment
     * @param list<string>|null $permissions
     */
    public static function with(
        string $name,
        Environment|string|null $environment = null,
        ?array $permissions = null,
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $environment && $self['environment'] = $environment;
        null !== $permissions && $self['permissions'] = $permissions;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

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
     * @param list<string> $permissions
     */
    public function withPermissions(array $permissions): self
    {
        $self = clone $this;
        $self['permissions'] = $permissions;

        return $self;
    }
}
