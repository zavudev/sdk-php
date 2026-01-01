<?php

declare(strict_types=1);

namespace Zavudev\Introspect;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Validate a phone number and check if a WhatsApp conversation window is open.
 *
 * @see Zavudev\Services\IntrospectService::validatePhone()
 *
 * @phpstan-type IntrospectValidatePhoneParamsShape = array{phoneNumber: string}
 */
final class IntrospectValidatePhoneParams implements BaseModel
{
    /** @use SdkModel<IntrospectValidatePhoneParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $phoneNumber;

    /**
     * `new IntrospectValidatePhoneParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * IntrospectValidatePhoneParams::with(phoneNumber: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new IntrospectValidatePhoneParams)->withPhoneNumber(...)
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
    public static function with(string $phoneNumber): self
    {
        $self = new self;

        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }
}
