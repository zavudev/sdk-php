<?php

declare(strict_types=1);

namespace Zavudev\Templates\Template;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Templates\Template\Button\OtpType;
use Zavudev\Templates\Template\Button\Type;

/**
 * @phpstan-type ButtonShape = array{
 *   example?: string|null,
 *   otpType?: null|OtpType|value-of<OtpType>,
 *   packageName?: string|null,
 *   phoneNumber?: string|null,
 *   signatureHash?: string|null,
 *   text?: string|null,
 *   type?: null|Type|value-of<Type>,
 *   url?: string|null,
 * }
 */
final class Button implements BaseModel
{
    /** @use SdkModel<ButtonShape> */
    use SdkModel;

    /**
     * Sample value used to substitute `{{1}}` in the URL when submitting the template to Meta for review. Only present for dynamic URL buttons.
     */
    #[Optional]
    public ?string $example;

    /**
     * OTP button type. Required when type is 'otp'.
     *
     * @var value-of<OtpType>|null $otpType
     */
    #[Optional(enum: OtpType::class)]
    public ?string $otpType;

    /**
     * Android package name. Required for ONE_TAP buttons.
     */
    #[Optional]
    public ?string $packageName;

    #[Optional]
    public ?string $phoneNumber;

    /**
     * Android app signature hash. Required for ONE_TAP buttons.
     */
    #[Optional]
    public ?string $signatureHash;

    #[Optional]
    public ?string $text;

    /** @var value-of<Type>|null $type */
    #[Optional(enum: Type::class)]
    public ?string $type;

    #[Optional]
    public ?string $url;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param OtpType|value-of<OtpType>|null $otpType
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        ?string $example = null,
        OtpType|string|null $otpType = null,
        ?string $packageName = null,
        ?string $phoneNumber = null,
        ?string $signatureHash = null,
        ?string $text = null,
        Type|string|null $type = null,
        ?string $url = null,
    ): self {
        $self = new self;

        null !== $example && $self['example'] = $example;
        null !== $otpType && $self['otpType'] = $otpType;
        null !== $packageName && $self['packageName'] = $packageName;
        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;
        null !== $signatureHash && $self['signatureHash'] = $signatureHash;
        null !== $text && $self['text'] = $text;
        null !== $type && $self['type'] = $type;
        null !== $url && $self['url'] = $url;

        return $self;
    }

    /**
     * Sample value used to substitute `{{1}}` in the URL when submitting the template to Meta for review. Only present for dynamic URL buttons.
     */
    public function withExample(string $example): self
    {
        $self = clone $this;
        $self['example'] = $example;

        return $self;
    }

    /**
     * OTP button type. Required when type is 'otp'.
     *
     * @param OtpType|value-of<OtpType> $otpType
     */
    public function withOtpType(OtpType|string $otpType): self
    {
        $self = clone $this;
        $self['otpType'] = $otpType;

        return $self;
    }

    /**
     * Android package name. Required for ONE_TAP buttons.
     */
    public function withPackageName(string $packageName): self
    {
        $self = clone $this;
        $self['packageName'] = $packageName;

        return $self;
    }

    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    /**
     * Android app signature hash. Required for ONE_TAP buttons.
     */
    public function withSignatureHash(string $signatureHash): self
    {
        $self = clone $this;
        $self['signatureHash'] = $signatureHash;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
