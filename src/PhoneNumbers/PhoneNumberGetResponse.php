<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type OwnedPhoneNumberShape from \Zavudev\PhoneNumbers\OwnedPhoneNumber
 *
 * @phpstan-type PhoneNumberGetResponseShape = array{
 *   phoneNumber: OwnedPhoneNumber|OwnedPhoneNumberShape
 * }
 */
final class PhoneNumberGetResponse implements BaseModel
{
    /** @use SdkModel<PhoneNumberGetResponseShape> */
    use SdkModel;

    #[Required]
    public OwnedPhoneNumber $phoneNumber;

    /**
     * `new PhoneNumberGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PhoneNumberGetResponse::with(phoneNumber: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PhoneNumberGetResponse)->withPhoneNumber(...)
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
     * @param OwnedPhoneNumber|OwnedPhoneNumberShape $phoneNumber
     */
    public static function with(OwnedPhoneNumber|array $phoneNumber): self
    {
        $self = new self;

        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    /**
     * @param OwnedPhoneNumber|OwnedPhoneNumberShape $phoneNumber
     */
    public function withPhoneNumber(OwnedPhoneNumber|array $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }
}
