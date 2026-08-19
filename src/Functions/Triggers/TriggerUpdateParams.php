<?php

declare(strict_types=1);

namespace Zavudev\Functions\Triggers;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Enable or disable a trigger.
 *
 * @see Zavudev\Services\Functions\TriggersService::update()
 *
 * @phpstan-type TriggerUpdateParamsShape = array{active: bool}
 */
final class TriggerUpdateParams implements BaseModel
{
    /** @use SdkModel<TriggerUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public bool $active;

    /**
     * `new TriggerUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TriggerUpdateParams::with(active: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TriggerUpdateParams)->withActive(...)
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
    public static function with(bool $active): self
    {
        $self = new self;

        $self['active'] = $active;

        return $self;
    }

    public function withActive(bool $active): self
    {
        $self = clone $this;
        $self['active'] = $active;

        return $self;
    }
}
