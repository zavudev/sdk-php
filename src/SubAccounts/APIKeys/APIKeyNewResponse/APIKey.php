<?php

declare(strict_types=1);

namespace Zavudev\SubAccounts\APIKeys\APIKeyNewResponse;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\SubAccounts\APIKeys\APIKeyNewResponse\APIKey\Environment;

/**
 * @phpstan-type APIKeyShape = array{
 *   id: string,
 *   environment: Environment|value-of<Environment>,
 *   key: string,
 *   name: string,
 * }
 */
final class APIKey implements BaseModel
{
    /** @use SdkModel<APIKeyShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /** @var value-of<Environment> $environment */
    #[Required(enum: Environment::class)]
    public string $environment;

    #[Required]
    public string $key;

    #[Required]
    public string $name;

    /**
     * `new APIKey()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * APIKey::with(id: ..., environment: ..., key: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new APIKey)->withID(...)->withEnvironment(...)->withKey(...)->withName(...)
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
     */
    public static function with(
        string $id,
        Environment|string $environment,
        string $key,
        string $name
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['environment'] = $environment;
        $self['key'] = $key;
        $self['name'] = $name;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

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

    public function withKey(string $key): self
    {
        $self = clone $this;
        $self['key'] = $key;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
