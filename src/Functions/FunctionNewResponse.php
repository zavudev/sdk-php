<?php

declare(strict_types=1);

namespace Zavudev\Functions;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Functions\FunctionNewResponse\Function_;

/**
 * @phpstan-import-type FunctionShape from \Zavudev\Functions\FunctionNewResponse\Function_
 *
 * @phpstan-type FunctionNewResponseShape = array{
 *   function: Function_|FunctionShape
 * }
 */
final class FunctionNewResponse implements BaseModel
{
    /** @use SdkModel<FunctionNewResponseShape> */
    use SdkModel;

    /**
     * A Zavu Function — user-supplied TypeScript that runs in Zavu Cloud and reacts to messaging events or HTTP requests.
     */
    #[Required]
    public Function_ $function;

    /**
     * `new FunctionNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FunctionNewResponse::with(function: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FunctionNewResponse)->withFunction(...)
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
     * @param Function_|FunctionShape $function
     */
    public static function with(Function_|array $function): self
    {
        $self = new self;

        $self['function'] = $function;

        return $self;
    }

    /**
     * A Zavu Function — user-supplied TypeScript that runs in Zavu Cloud and reacts to messaging events or HTTP requests.
     *
     * @param Function_|FunctionShape $function
     */
    public function withFunction(Function_|array $function): self
    {
        $self = clone $this;
        $self['function'] = $function;

        return $self;
    }
}
