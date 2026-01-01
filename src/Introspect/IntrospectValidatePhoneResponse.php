<?php

declare(strict_types=1);

namespace Zavudev\Introspect;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Introspect\IntrospectValidatePhoneResponse\Carrier;

/**
 * @phpstan-import-type CarrierShape from \Zavudev\Introspect\IntrospectValidatePhoneResponse\Carrier
 *
 * @phpstan-type IntrospectValidatePhoneResponseShape = array{
 *   countryCode: string,
 *   phoneNumber: string,
 *   validNumber: bool,
 *   availableChannels?: list<string>|null,
 *   carrier?: null|Carrier|CarrierShape,
 *   lineType?: null|LineType|value-of<LineType>,
 *   nationalFormat?: string|null,
 * }
 */
final class IntrospectValidatePhoneResponse implements BaseModel
{
    /** @use SdkModel<IntrospectValidatePhoneResponseShape> */
    use SdkModel;

    #[Required]
    public string $countryCode;

    #[Required]
    public string $phoneNumber;

    #[Required]
    public bool $validNumber;

    /**
     * List of available messaging channels for this phone number.
     *
     * @var list<string>|null $availableChannels
     */
    #[Optional(list: 'string')]
    public ?array $availableChannels;

    /**
     * Carrier information for the phone number.
     */
    #[Optional]
    public ?Carrier $carrier;

    /**
     * Type of phone line.
     *
     * @var value-of<LineType>|null $lineType
     */
    #[Optional(enum: LineType::class)]
    public ?string $lineType;

    /**
     * Phone number in national format.
     */
    #[Optional]
    public ?string $nationalFormat;

    /**
     * `new IntrospectValidatePhoneResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * IntrospectValidatePhoneResponse::with(
     *   countryCode: ..., phoneNumber: ..., validNumber: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new IntrospectValidatePhoneResponse)
     *   ->withCountryCode(...)
     *   ->withPhoneNumber(...)
     *   ->withValidNumber(...)
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
     * @param list<string>|null $availableChannels
     * @param Carrier|CarrierShape|null $carrier
     * @param LineType|value-of<LineType>|null $lineType
     */
    public static function with(
        string $countryCode,
        string $phoneNumber,
        bool $validNumber,
        ?array $availableChannels = null,
        Carrier|array|null $carrier = null,
        LineType|string|null $lineType = null,
        ?string $nationalFormat = null,
    ): self {
        $self = new self;

        $self['countryCode'] = $countryCode;
        $self['phoneNumber'] = $phoneNumber;
        $self['validNumber'] = $validNumber;

        null !== $availableChannels && $self['availableChannels'] = $availableChannels;
        null !== $carrier && $self['carrier'] = $carrier;
        null !== $lineType && $self['lineType'] = $lineType;
        null !== $nationalFormat && $self['nationalFormat'] = $nationalFormat;

        return $self;
    }

    public function withCountryCode(string $countryCode): self
    {
        $self = clone $this;
        $self['countryCode'] = $countryCode;

        return $self;
    }

    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    public function withValidNumber(bool $validNumber): self
    {
        $self = clone $this;
        $self['validNumber'] = $validNumber;

        return $self;
    }

    /**
     * List of available messaging channels for this phone number.
     *
     * @param list<string> $availableChannels
     */
    public function withAvailableChannels(array $availableChannels): self
    {
        $self = clone $this;
        $self['availableChannels'] = $availableChannels;

        return $self;
    }

    /**
     * Carrier information for the phone number.
     *
     * @param Carrier|CarrierShape $carrier
     */
    public function withCarrier(Carrier|array $carrier): self
    {
        $self = clone $this;
        $self['carrier'] = $carrier;

        return $self;
    }

    /**
     * Type of phone line.
     *
     * @param LineType|value-of<LineType> $lineType
     */
    public function withLineType(LineType|string $lineType): self
    {
        $self = clone $this;
        $self['lineType'] = $lineType;

        return $self;
    }

    /**
     * Phone number in national format.
     */
    public function withNationalFormat(string $nationalFormat): self
    {
        $self = clone $this;
        $self['nationalFormat'] = $nationalFormat;

        return $self;
    }
}
