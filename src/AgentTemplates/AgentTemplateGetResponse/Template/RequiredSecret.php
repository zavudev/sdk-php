<?php

declare(strict_types=1);

namespace Zavudev\AgentTemplates\AgentTemplateGetResponse\Template;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type RequiredSecretShape = array{hint: string, key: string}
 */
final class RequiredSecret implements BaseModel
{
    /** @use SdkModel<RequiredSecretShape> */
    use SdkModel;

    #[Required]
    public string $hint;

    #[Required]
    public string $key;

    /**
     * `new RequiredSecret()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RequiredSecret::with(hint: ..., key: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RequiredSecret)->withHint(...)->withKey(...)
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
    public static function with(string $hint, string $key): self
    {
        $self = new self;

        $self['hint'] = $hint;
        $self['key'] = $key;

        return $self;
    }

    public function withHint(string $hint): self
    {
        $self = clone $this;
        $self['hint'] = $hint;

        return $self;
    }

    public function withKey(string $key): self
    {
        $self = clone $this;
        $self['key'] = $key;

        return $self;
    }
}
