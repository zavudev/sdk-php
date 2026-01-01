<?php

declare(strict_types=1);

namespace Zavudev\Senders\Sender;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\Sender\Whatsapp\PaymentStatus;

/**
 * WhatsApp Business Account information. Only present if a WABA is connected.
 *
 * @phpstan-import-type PaymentStatusShape from \Zavudev\Senders\Sender\Whatsapp\PaymentStatus
 *
 * @phpstan-type WhatsappShape = array{
 *   displayPhoneNumber?: string|null,
 *   paymentStatus?: null|PaymentStatus|PaymentStatusShape,
 *   phoneNumberID?: string|null,
 * }
 */
final class Whatsapp implements BaseModel
{
    /** @use SdkModel<WhatsappShape> */
    use SdkModel;

    /**
     * Display phone number.
     */
    #[Optional]
    public ?string $displayPhoneNumber;

    /**
     * Payment configuration status from Meta.
     */
    #[Optional]
    public ?PaymentStatus $paymentStatus;

    /**
     * WhatsApp phone number ID from Meta.
     */
    #[Optional('phoneNumberId')]
    public ?string $phoneNumberID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param PaymentStatus|PaymentStatusShape|null $paymentStatus
     */
    public static function with(
        ?string $displayPhoneNumber = null,
        PaymentStatus|array|null $paymentStatus = null,
        ?string $phoneNumberID = null,
    ): self {
        $self = new self;

        null !== $displayPhoneNumber && $self['displayPhoneNumber'] = $displayPhoneNumber;
        null !== $paymentStatus && $self['paymentStatus'] = $paymentStatus;
        null !== $phoneNumberID && $self['phoneNumberID'] = $phoneNumberID;

        return $self;
    }

    /**
     * Display phone number.
     */
    public function withDisplayPhoneNumber(string $displayPhoneNumber): self
    {
        $self = clone $this;
        $self['displayPhoneNumber'] = $displayPhoneNumber;

        return $self;
    }

    /**
     * Payment configuration status from Meta.
     *
     * @param PaymentStatus|PaymentStatusShape $paymentStatus
     */
    public function withPaymentStatus(PaymentStatus|array $paymentStatus): self
    {
        $self = clone $this;
        $self['paymentStatus'] = $paymentStatus;

        return $self;
    }

    /**
     * WhatsApp phone number ID from Meta.
     */
    public function withPhoneNumberID(string $phoneNumberID): self
    {
        $self = clone $this;
        $self['phoneNumberID'] = $phoneNumberID;

        return $self;
    }
}
