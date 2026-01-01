<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Get regulatory requirements for purchasing phone numbers in a specific country. Some countries require additional documentation (addresses, identity documents) before phone numbers can be activated.
 *
 * @see Zavudev\Services\PhoneNumbersService::requirements()
 *
 * @phpstan-type PhoneNumberRequirementsParamsShape = array{
 *   countryCode: string, type?: null|PhoneNumberType|value-of<PhoneNumberType>
 * }
 */
final class PhoneNumberRequirementsParams implements BaseModel
{
    /** @use SdkModel<PhoneNumberRequirementsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Two-letter ISO country code.
     */
    #[Required]
    public string $countryCode;

    /**
     * Type of phone number (local, mobile, tollFree).
     *
     * @var value-of<PhoneNumberType>|null $type
     */
    #[Optional(enum: PhoneNumberType::class)]
    public ?string $type;

    /**
     * `new PhoneNumberRequirementsParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PhoneNumberRequirementsParams::with(countryCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PhoneNumberRequirementsParams)->withCountryCode(...)
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
     * @param PhoneNumberType|value-of<PhoneNumberType>|null $type
     */
    public static function with(
        string $countryCode,
        PhoneNumberType|string|null $type = null
    ): self {
        $self = new self;

        $self['countryCode'] = $countryCode;

        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Two-letter ISO country code.
     */
    public function withCountryCode(string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

        return $self;
    }

    /**
     * Type of phone number (local, mobile, tollFree).
     *
     * @param PhoneNumberType|value-of<PhoneNumberType> $type
     */
    public function withType(PhoneNumberType|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
