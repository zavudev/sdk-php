<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type PhoneNumberCapabilitiesShape = array{
 *   mms?: bool|null, sms?: bool|null, voice?: bool|null
 * }
 */
final class PhoneNumberCapabilities implements BaseModel
{
    /** @use SdkModel<PhoneNumberCapabilitiesShape> */
    use SdkModel;

    #[Optional]
    public ?bool $mms;

    #[Optional]
    public ?bool $sms;

    #[Optional]
    public ?bool $voice;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?bool $mms = null,
        ?bool $sms = null,
        ?bool $voice = null
    ): self {
        $self = new self;

        null !== $mms && $self['mms'] = $mms;
        null !== $sms && $self['sms'] = $sms;
        null !== $voice && $self['voice'] = $voice;

        return $self;
    }

    public function withMms(bool $mms): self
    {
        $self = clone $this;
        $self['mms'] = $mms;

        return $self;
    }

    public function withSMS(bool $sms): self
    {
        $self = clone $this;
        $self['sms'] = $sms;

        return $self;
    }

    public function withVoice(bool $voice): self
    {
        $self = clone $this;
        $self['voice'] = $voice;

        return $self;
    }
}
