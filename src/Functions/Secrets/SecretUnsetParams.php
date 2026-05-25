<?php

declare(strict_types=1);

namespace Zavudev\Functions\Secrets;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Remove a secret from a function. Doesn't take effect on the running Lambda until the next deploy.
 *
 * @see Zavudev\Services\Functions\SecretsService::unset()
 *
 * @phpstan-type SecretUnsetParamsShape = array{functionID: string}
 */
final class SecretUnsetParams implements BaseModel
{
    /** @use SdkModel<SecretUnsetParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $functionID;

    /**
     * `new SecretUnsetParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SecretUnsetParams::with(functionID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SecretUnsetParams)->withFunctionID(...)
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
    public static function with(string $functionID): self
    {
        $self = new self;

        $self['functionID'] = $functionID;

        return $self;
    }

    public function withFunctionID(string $functionID): self
    {
        $self = clone $this;
        $self['functionID'] = $functionID;

        return $self;
    }
}
