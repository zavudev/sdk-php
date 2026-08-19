<?php

declare(strict_types=1);

namespace Zavudev\Introspect\IntrospectValidateEmailResponse;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type SummaryShape = array{
 *   deliverable: int, risky: int, total: int, undeliverable: int
 * }
 */
final class Summary implements BaseModel
{
    /** @use SdkModel<SummaryShape> */
    use SdkModel;

    #[Required]
    public int $deliverable;

    #[Required]
    public int $risky;

    #[Required]
    public int $total;

    #[Required]
    public int $undeliverable;

    /**
     * `new Summary()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Summary::with(deliverable: ..., risky: ..., total: ..., undeliverable: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Summary)
     *   ->withDeliverable(...)
     *   ->withRisky(...)
     *   ->withTotal(...)
     *   ->withUndeliverable(...)
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
        int $deliverable,
        int $risky,
        int $total,
        int $undeliverable
    ): self {
        $self = new self;

        $self['deliverable'] = $deliverable;
        $self['risky'] = $risky;
        $self['total'] = $total;
        $self['undeliverable'] = $undeliverable;

        return $self;
    }

    public function withDeliverable(int $deliverable): self
    {
        $self = clone $this;
        $self['deliverable'] = $deliverable;

        return $self;
    }

    public function withRisky(int $risky): self
    {
        $self = clone $this;
        $self['risky'] = $risky;

        return $self;
    }

    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }

    public function withUndeliverable(int $undeliverable): self
    {
        $self = clone $this;
        $self['undeliverable'] = $undeliverable;

        return $self;
    }
}
