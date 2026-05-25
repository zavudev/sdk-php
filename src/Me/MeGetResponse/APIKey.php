<?php

declare(strict_types=1);

namespace Zavudev\Me\MeGetResponse;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type APIKeyShape = array{id: string}
 */
final class APIKey implements BaseModel
{
    /** @use SdkModel<APIKeyShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * `new APIKey()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * APIKey::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new APIKey)->withID(...)
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
    public static function with(string $id): self
    {
        $self = new self;

        $self['id'] = $id;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }
}
