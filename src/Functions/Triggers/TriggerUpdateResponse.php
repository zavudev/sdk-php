<?php

declare(strict_types=1);

namespace Zavudev\Functions\Triggers;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type TriggerUpdateResponseShape = array{active: bool, ok: bool}
 */
final class TriggerUpdateResponse implements BaseModel
{
    /** @use SdkModel<TriggerUpdateResponseShape> */
    use SdkModel;

    #[Required]
    public bool $active;

    #[Required]
    public bool $ok;

    /**
     * `new TriggerUpdateResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TriggerUpdateResponse::with(active: ..., ok: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TriggerUpdateResponse)->withActive(...)->withOk(...)
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
    public static function with(bool $active, bool $ok): self
    {
        $self = new self;

        $self['active'] = $active;
        $self['ok'] = $ok;

        return $self;
    }

    public function withActive(bool $active): self
    {
        $self = clone $this;
        $self['active'] = $active;

        return $self;
    }

    public function withOk(bool $ok): self
    {
        $self = clone $this;
        $self['ok'] = $ok;

        return $self;
    }
}
