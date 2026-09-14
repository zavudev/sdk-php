<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Get the regulatory information needed to buy a phone number, for one specific number or for a country and number type. Prefer `phoneNumber`: the response is then exactly the list the purchase of that number validates against. Pass each `requirementTypes[].id` back as `requirementType` in `regulatoryRequirements` on `POST /v1/phone-numbers`.
 *
 * For `phoneNumber`, the requirements of that exact number are returned. When they cannot be resolved for the number itself, the list for its country and `type` is returned instead, and the purchase uses the same list. An empty `items` array means the number needs no regulatory information. If the requirements cannot be retrieved at all, the response is `502 requirements_unavailable`, never an empty list.
 *
 * URL-encode the `+` of `phoneNumber` as `%2B`. An unencoded `+` is also accepted.
 *
 * @see Zavudev\Services\PhoneNumbersService::requirements()
 *
 * @phpstan-type PhoneNumberRequirementsParamsShape = array{
 *   countryCode?: string|null,
 *   phoneNumber?: string|null,
 *   type?: null|PhoneNumberType|value-of<PhoneNumberType>,
 * }
 */
final class PhoneNumberRequirementsParams implements BaseModel
{
    /** @use SdkModel<PhoneNumberRequirementsParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Two-letter ISO country code. Required unless `phoneNumber` is given.
     */
    #[Optional]
    public ?string $countryCode;

    /**
     * E.164 number from `GET /v1/phone-numbers/available`, with `+` encoded as `%2B`. Returns the requirements the purchase of that number checks. Takes precedence over `countryCode`.
     */
    #[Optional]
    public ?string $phoneNumber;

    /**
     * Type of phone number (local, national, mobile, tollFree). Defaults to `local`. With `phoneNumber`, used only when the number's own requirements cannot be resolved and the country list is returned.
     *
     * @var value-of<PhoneNumberType>|null $type
     */
    #[Optional(enum: PhoneNumberType::class)]
    public ?string $type;

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
        ?string $countryCode = null,
        ?string $phoneNumber = null,
        PhoneNumberType|string|null $type = null,
    ): self {
        $self = new self;

        null !== $countryCode && $self['countryCode'] = $countryCode;
        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Two-letter ISO country code. Required unless `phoneNumber` is given.
     */
    public function withCountryCode(string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

        return $self;
    }

    /**
     * E.164 number from `GET /v1/phone-numbers/available`, with `+` encoded as `%2B`. Returns the requirements the purchase of that number checks. Takes precedence over `countryCode`.
     */
    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    /**
     * Type of phone number (local, national, mobile, tollFree). Defaults to `local`. With `phoneNumber`, used only when the number's own requirements cannot be resolved and the country list is returned.
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
