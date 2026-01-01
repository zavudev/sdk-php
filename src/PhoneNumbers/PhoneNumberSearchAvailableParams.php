<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Search for available phone numbers to purchase by country and type.
 *
 * @see Zavudev\Services\PhoneNumbersService::searchAvailable()
 *
 * @phpstan-type PhoneNumberSearchAvailableParamsShape = array{
 *   countryCode: string,
 *   contains?: string|null,
 *   limit?: int|null,
 *   type?: null|PhoneNumberType|value-of<PhoneNumberType>,
 * }
 */
final class PhoneNumberSearchAvailableParams implements BaseModel
{
    /** @use SdkModel<PhoneNumberSearchAvailableParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Two-letter ISO country code.
     */
    #[Required]
    public string $countryCode;

    /**
     * Search for numbers containing this string.
     */
    #[Optional]
    public ?string $contains;

    /**
     * Maximum number of results to return.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Type of phone number to search for.
     *
     * @var value-of<PhoneNumberType>|null $type
     */
    #[Optional(enum: PhoneNumberType::class)]
    public ?string $type;

    /**
     * `new PhoneNumberSearchAvailableParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PhoneNumberSearchAvailableParams::with(countryCode: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PhoneNumberSearchAvailableParams)->withCountryCode(...)
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
        ?string $contains = null,
        ?int $limit = null,
        PhoneNumberType|string|null $type = null,
    ): self {
        $self = new self;

        $self['countryCode'] = $countryCode;

        null !== $contains && $self['contains'] = $contains;
        null !== $limit && $self['limit'] = $limit;
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
     * Search for numbers containing this string.
     */
    public function withContains(string $contains): self
    {
        $self = clone $this;
        $self['contains'] = $contains;

        return $self;
    }

    /**
     * Maximum number of results to return.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Type of phone number to search for.
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
