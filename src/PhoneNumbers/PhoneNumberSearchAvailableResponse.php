<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type AvailablePhoneNumberShape from \Zavudev\PhoneNumbers\AvailablePhoneNumber
 *
 * @phpstan-type PhoneNumberSearchAvailableResponseShape = array{
 *   items: list<AvailablePhoneNumberShape>
 * }
 */
final class PhoneNumberSearchAvailableResponse implements BaseModel
{
    /** @use SdkModel<PhoneNumberSearchAvailableResponseShape> */
    use SdkModel;

    /** @var list<AvailablePhoneNumber> $items */
    #[Required(list: AvailablePhoneNumber::class)]
    public array $items;

    /**
     * `new PhoneNumberSearchAvailableResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PhoneNumberSearchAvailableResponse::with(items: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PhoneNumberSearchAvailableResponse)->withItems(...)
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
     * @param list<AvailablePhoneNumberShape> $items
     */
    public static function with(array $items): self
    {
        $self = new self;

        $self['items'] = $items;

        return $self;
    }

    /**
     * @param list<AvailablePhoneNumberShape> $items
     */
    public function withItems(array $items): self
    {
        $self = clone $this;
        $self['items'] = $items;

        return $self;
    }
}
