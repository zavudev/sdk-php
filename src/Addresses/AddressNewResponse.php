<?php

declare(strict_types=1);

namespace Zavudev\Addresses;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type AddressShape from \Zavudev\Addresses\Address
 *
 * @phpstan-type AddressNewResponseShape = array{address: Address|AddressShape}
 */
final class AddressNewResponse implements BaseModel
{
    /** @use SdkModel<AddressNewResponseShape> */
    use SdkModel;

    /**
     * A regulatory address for phone number requirements.
     */
    #[Required]
    public Address $address;

    /**
     * `new AddressNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AddressNewResponse::with(address: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AddressNewResponse)->withAddress(...)
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
     * @param Address|AddressShape $address
     */
    public static function with(Address|array $address): self
    {
        $self = new self;

        $self['address'] = $address;

        return $self;
    }

    /**
     * A regulatory address for phone number requirements.
     *
     * @param Address|AddressShape $address
     */
    public function withAddress(Address|array $address): self
    {
        $self = clone $this;
        $self['address'] = $address;

        return $self;
    }
}
