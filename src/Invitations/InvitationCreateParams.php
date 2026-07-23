<?php

declare(strict_types=1);

namespace Zavudev\Invitations;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Invitations\InvitationCreateParams\ConnectionType;

/**
 * Create a partner invitation link for a client to connect WhatsApp. The client opens the returned `url` and completes Meta's embedded signup, linking an official WhatsApp Business Account. The resulting sender is created in your project when the client completes the flow, and the invitation transitions to `completed`.
 *
 * @see Zavudev\Services\InvitationsService::create()
 *
 * @phpstan-type InvitationCreateParamsShape = array{
 *   allowedPhoneCountries?: list<string>|null,
 *   clientEmail?: string|null,
 *   clientName?: string|null,
 *   clientPhone?: string|null,
 *   connectionType?: null|ConnectionType|value-of<ConnectionType>,
 *   expiresInDays?: int|null,
 *   phoneNumberID?: string|null,
 * }
 */
final class InvitationCreateParams implements BaseModel
{
    /** @use SdkModel<InvitationCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ISO country codes for allowed phone numbers.
     *
     * @var list<string>|null $allowedPhoneCountries
     */
    #[Optional(list: 'string')]
    public ?array $allowedPhoneCountries;

    /**
     * Email of the client being invited.
     */
    #[Optional]
    public ?string $clientEmail;

    /**
     * Name of the client being invited.
     */
    #[Optional]
    public ?string $clientName;

    /**
     * Phone number of the client in E.164 format.
     */
    #[Optional]
    public ?string $clientPhone;

    /**
     * How the client connects WhatsApp. `whatsapp_waba` (default) runs Meta's embedded signup to link an official WhatsApp Business Account.
     *
     * @var value-of<ConnectionType>|null $connectionType
     */
    #[Optional(enum: ConnectionType::class)]
    public ?string $connectionType;

    /**
     * Number of days until the invitation expires.
     */
    #[Optional]
    public ?int $expiresInDays;

    /**
     * ID of a Zavu phone number to pre-assign for WhatsApp registration. If provided, the client will use this number instead of their own.
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
     * @param list<string>|null $allowedPhoneCountries
     * @param ConnectionType|value-of<ConnectionType>|null $connectionType
     */
    public static function with(
        ?array $allowedPhoneCountries = null,
        ?string $clientEmail = null,
        ?string $clientName = null,
        ?string $clientPhone = null,
        ConnectionType|string|null $connectionType = null,
        ?int $expiresInDays = null,
        ?string $phoneNumberID = null,
    ): self {
        $self = new self;

        null !== $allowedPhoneCountries && $self['allowedPhoneCountries'] = $allowedPhoneCountries;
        null !== $clientEmail && $self['clientEmail'] = $clientEmail;
        null !== $clientName && $self['clientName'] = $clientName;
        null !== $clientPhone && $self['clientPhone'] = $clientPhone;
        null !== $connectionType && $self['connectionType'] = $connectionType;
        null !== $expiresInDays && $self['expiresInDays'] = $expiresInDays;
        null !== $phoneNumberID && $self['phoneNumberID'] = $phoneNumberID;

        return $self;
    }

    /**
     * ISO country codes for allowed phone numbers.
     *
     * @param list<string> $allowedPhoneCountries
     */
    public function withAllowedPhoneCountries(
        array $allowedPhoneCountries
    ): self {
        $self = clone $this;
        $self['allowedPhoneCountries'] = $allowedPhoneCountries;

        return $self;
    }

    /**
     * Email of the client being invited.
     */
    public function withClientEmail(string $clientEmail): self
    {
        $self = clone $this;
        $self['clientEmail'] = $clientEmail;

        return $self;
    }

    /**
     * Name of the client being invited.
     */
    public function withClientName(string $clientName): self
    {
        $self = clone $this;
        $self['clientName'] = $clientName;

        return $self;
    }

    /**
     * Phone number of the client in E.164 format.
     */
    public function withClientPhone(string $clientPhone): self
    {
        $self = clone $this;
        $self['clientPhone'] = $clientPhone;

        return $self;
    }

    /**
     * How the client connects WhatsApp. `whatsapp_waba` (default) runs Meta's embedded signup to link an official WhatsApp Business Account.
     *
     * @param ConnectionType|value-of<ConnectionType> $connectionType
     */
    public function withConnectionType(
        ConnectionType|string $connectionType
    ): self {
        $self = clone $this;
        $self['connectionType'] = $connectionType;

        return $self;
    }

    /**
     * Number of days until the invitation expires.
     */
    public function withExpiresInDays(int $expiresInDays): self
    {
        $self = clone $this;
        $self['expiresInDays'] = $expiresInDays;

        return $self;
    }

    /**
     * ID of a Zavu phone number to pre-assign for WhatsApp registration. If provided, the client will use this number instead of their own.
     */
    public function withPhoneNumberID(string $phoneNumberID): self
    {
        $self = clone $this;
        $self['phoneNumberID'] = $phoneNumberID;

        return $self;
    }
}
