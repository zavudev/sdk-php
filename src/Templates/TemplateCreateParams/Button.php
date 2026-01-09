<?php

declare(strict_types=1);

namespace Zavudev\Templates\TemplateCreateParams;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Templates\TemplateCreateParams\Button\OtpType;
use Zavudev\Templates\TemplateCreateParams\Button\Type;

/**
 * @phpstan-type ButtonShape = array{
 *   text: string,
 *   type: Type|value-of<Type>,
 *   otpType?: null|OtpType|value-of<OtpType>,
 *   packageName?: string|null,
 *   phoneNumber?: string|null,
 *   signatureHash?: string|null,
 *   url?: string|null,
 * }
 */
final class Button implements BaseModel
{
    /** @use SdkModel<ButtonShape> */
    use SdkModel;

    #[Required]
    public string $text;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Required when type is 'otp'. COPY_CODE shows copy button, ONE_TAP enables Android autofill.
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
    public ?string $url;

    /**
     * `new Button()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Button::with(text: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Button)->withText(...)->withType(...)
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
     * @param Type|value-of<Type> $type
     * @param OtpType|value-of<OtpType>|null $otpType
     */
    public static function with(
        string $text,
        Type|string $type,
        OtpType|string|null $otpType = null,
        ?string $packageName = null,
        ?string $phoneNumber = null,
        ?string $signatureHash = null,
        ?string $url = null,
    ): self {
        $self = new self;

        $self['text'] = $text;
        $self['type'] = $type;

        null !== $otpType && $self['otpType'] = $otpType;
        null !== $packageName && $self['packageName'] = $packageName;
        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;
        null !== $signatureHash && $self['signatureHash'] = $signatureHash;
        null !== $url && $self['url'] = $url;

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

    /**
     * Required when type is 'otp'. COPY_CODE shows copy button, ONE_TAP enables Android autofill.
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

    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
