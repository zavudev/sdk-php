<?php

declare(strict_types=1);

namespace Zavudev\Functions\Secrets;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Create or update a secret on a function. Marks the function out-of-sync; the next `POST /deploy` re-publishes the Lambda with the new env. Keys must match `[A-Z_][A-Z0-9_]*` (uppercase env-var style) and cannot start with reserved prefixes (AWS_, LAMBDA_, etc).
 *
 * @see Zavudev\Services\Functions\SecretsService::set()
 *
 * @phpstan-type SecretSetParamsShape = array{functionID: string, value: string}
 */
final class SecretSetParams implements BaseModel
{
    /** @use SdkModel<SecretSetParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $functionID;

    #[Required]
    public string $value;

    /**
     * `new SecretSetParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SecretSetParams::with(functionID: ..., value: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SecretSetParams)->withFunctionID(...)->withValue(...)
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
    public static function with(string $functionID, string $value): self
    {
        $self = new self;

        $self['functionID'] = $functionID;
        $self['value'] = $value;

        return $self;
    }

    public function withFunctionID(string $functionID): self
    {
        $self = clone $this;
        $self['functionID'] = $functionID;

        return $self;
    }

    public function withValue(string $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }
}
