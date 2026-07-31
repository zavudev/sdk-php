<?php

declare(strict_types=1);

namespace Zavudev\Invitations;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Invitations\Invitation\ConnectedAccount;
use Zavudev\Invitations\Invitation\ConnectionType;
use Zavudev\Invitations\Invitation\Status;

/**
 * @phpstan-import-type ConnectedAccountShape from \Zavudev\Invitations\Invitation\ConnectedAccount
 *
 * @phpstan-type InvitationShape = array{
 *   id: string,
 *   token: string,
 *   createdAt: \DateTimeInterface,
 *   expiresAt: \DateTimeInterface,
 *   status: Status|value-of<Status>,
 *   updatedAt: \DateTimeInterface,
 *   url: string,
 *   clientEmail?: string|null,
 *   clientName?: string|null,
 *   clientPhone?: string|null,
 *   completedAt?: \DateTimeInterface|null,
 *   connectedAccount?: null|ConnectedAccount|ConnectedAccountShape,
 *   connectionType?: null|ConnectionType|value-of<ConnectionType>,
 *   failedAt?: \DateTimeInterface|null,
 *   failureReason?: string|null,
 *   phoneNumberID?: string|null,
 *   senderID?: string|null,
 *   startedAt?: \DateTimeInterface|null,
 *   viewedAt?: \DateTimeInterface|null,
 * }
 */
final class Invitation implements BaseModel
{
    /** @use SdkModel<InvitationShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * Unique invitation token.
     */
    #[Required]
    public string $token;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public \DateTimeInterface $expiresAt;

    /**
     * Current status of the partner invitation.
     *
     * `failed` means the client started the connection and it did not finish (they cancelled Meta's dialog, denied a permission, or abandoned the tab). A failed invitation is still usable: the same link can be retried, and it moves back to `in_progress` when the client tries again.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    #[Required]
    public \DateTimeInterface $updatedAt;

    /**
     * Full URL to share with the client.
     */
    #[Required]
    public string $url;

    #[Optional(nullable: true)]
    public ?string $clientEmail;

    #[Optional(nullable: true)]
    public ?string $clientName;

    #[Optional(nullable: true)]
    public ?string $clientPhone;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $completedAt;

    /**
     * The account the client linked, populated once the invitation is `completed`. Null before that. Use it to show the partner what was connected without fetching the sender.
     */
    #[Optional(nullable: true)]
    public ?ConnectedAccount $connectedAccount;

    /**
     * Which Meta channel the client connects: `whatsapp_waba` (official WhatsApp Cloud API via embedded signup) or `messenger` (a Facebook Page's Messenger inbox, including Marketplace chats).
     *
     * @var value-of<ConnectionType>|null $connectionType
     */
    #[Optional(enum: ConnectionType::class)]
    public ?string $connectionType;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $failedAt;

    /**
     * Stable code for why the last attempt failed, present when `status` is `failed`. Values include `fb_cancelled` (client closed Meta's dialog), `fb_not_authorized` (permission denied), `signup_abandoned` (started but never finished), `meta_no_pages` (the client administers no Facebook Page), and `internal_error`. Treat unknown codes as a generic failure.
     */
    #[Optional(nullable: true)]
    public ?string $failureReason;

    /**
     * ID of a pre-assigned Zavu phone number for WhatsApp registration. Always null for `messenger` invitations.
     */
    #[Optional('phoneNumberId', nullable: true)]
    public ?string $phoneNumberID;

    /**
     * ID of the sender created when invitation is completed.
     */
    #[Optional('senderId', nullable: true)]
    public ?string $senderID;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $startedAt;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $viewedAt;

    /**
     * `new Invitation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Invitation::with(
     *   id: ...,
     *   token: ...,
     *   createdAt: ...,
     *   expiresAt: ...,
     *   status: ...,
     *   updatedAt: ...,
     *   url: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Invitation)
     *   ->withID(...)
     *   ->withToken(...)
     *   ->withCreatedAt(...)
     *   ->withExpiresAt(...)
     *   ->withStatus(...)
     *   ->withUpdatedAt(...)
     *   ->withURL(...)
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
     * @param Status|value-of<Status> $status
     * @param ConnectedAccount|ConnectedAccountShape|null $connectedAccount
     * @param ConnectionType|value-of<ConnectionType>|null $connectionType
     */
    public static function with(
        string $id,
        string $token,
        \DateTimeInterface $createdAt,
        \DateTimeInterface $expiresAt,
        Status|string $status,
        \DateTimeInterface $updatedAt,
        string $url,
        ?string $clientEmail = null,
        ?string $clientName = null,
        ?string $clientPhone = null,
        ?\DateTimeInterface $completedAt = null,
        ConnectedAccount|array|null $connectedAccount = null,
        ConnectionType|string|null $connectionType = null,
        ?\DateTimeInterface $failedAt = null,
        ?string $failureReason = null,
        ?string $phoneNumberID = null,
        ?string $senderID = null,
        ?\DateTimeInterface $startedAt = null,
        ?\DateTimeInterface $viewedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['token'] = $token;
        $self['createdAt'] = $createdAt;
        $self['expiresAt'] = $expiresAt;
        $self['status'] = $status;
        $self['updatedAt'] = $updatedAt;
        $self['url'] = $url;

        null !== $clientEmail && $self['clientEmail'] = $clientEmail;
        null !== $clientName && $self['clientName'] = $clientName;
        null !== $clientPhone && $self['clientPhone'] = $clientPhone;
        null !== $completedAt && $self['completedAt'] = $completedAt;
        null !== $connectedAccount && $self['connectedAccount'] = $connectedAccount;
        null !== $connectionType && $self['connectionType'] = $connectionType;
        null !== $failedAt && $self['failedAt'] = $failedAt;
        null !== $failureReason && $self['failureReason'] = $failureReason;
        null !== $phoneNumberID && $self['phoneNumberID'] = $phoneNumberID;
        null !== $senderID && $self['senderID'] = $senderID;
        null !== $startedAt && $self['startedAt'] = $startedAt;
        null !== $viewedAt && $self['viewedAt'] = $viewedAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Unique invitation token.
     */
    public function withToken(string $token): self
    {
        $self = clone $this;
        $self['token'] = $token;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    /**
     * Current status of the partner invitation.
     *
     * `failed` means the client started the connection and it did not finish (they cancelled Meta's dialog, denied a permission, or abandoned the tab). A failed invitation is still usable: the same link can be retried, and it moves back to `in_progress` when the client tries again.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Full URL to share with the client.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    public function withClientEmail(?string $clientEmail): self
    {
        $self = clone $this;
        $self['clientEmail'] = $clientEmail;

        return $self;
    }

    public function withClientName(?string $clientName): self
    {
        $self = clone $this;
        $self['clientName'] = $clientName;

        return $self;
    }

    public function withClientPhone(?string $clientPhone): self
    {
        $self = clone $this;
        $self['clientPhone'] = $clientPhone;

        return $self;
    }

    public function withCompletedAt(?\DateTimeInterface $completedAt): self
    {
        $self = clone $this;
        $self['completedAt'] = $completedAt;

        return $self;
    }

    /**
     * The account the client linked, populated once the invitation is `completed`. Null before that. Use it to show the partner what was connected without fetching the sender.
     *
     * @param ConnectedAccount|ConnectedAccountShape|null $connectedAccount
     */
    public function withConnectedAccount(
        ConnectedAccount|array|null $connectedAccount
    ): self {
        $self = clone $this;
        $self['connectedAccount'] = $connectedAccount;

        return $self;
    }

    /**
     * Which Meta channel the client connects: `whatsapp_waba` (official WhatsApp Cloud API via embedded signup) or `messenger` (a Facebook Page's Messenger inbox, including Marketplace chats).
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

    public function withFailedAt(?\DateTimeInterface $failedAt): self
    {
        $self = clone $this;
        $self['failedAt'] = $failedAt;

        return $self;
    }

    /**
     * Stable code for why the last attempt failed, present when `status` is `failed`. Values include `fb_cancelled` (client closed Meta's dialog), `fb_not_authorized` (permission denied), `signup_abandoned` (started but never finished), `meta_no_pages` (the client administers no Facebook Page), and `internal_error`. Treat unknown codes as a generic failure.
     */
    public function withFailureReason(?string $failureReason): self
    {
        $self = clone $this;
        $self['failureReason'] = $failureReason;

        return $self;
    }

    /**
     * ID of a pre-assigned Zavu phone number for WhatsApp registration. Always null for `messenger` invitations.
     */
    public function withPhoneNumberID(?string $phoneNumberID): self
    {
        $self = clone $this;
        $self['phoneNumberID'] = $phoneNumberID;

        return $self;
    }

    /**
     * ID of the sender created when invitation is completed.
     */
    public function withSenderID(?string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }

    public function withStartedAt(?\DateTimeInterface $startedAt): self
    {
        $self = clone $this;
        $self['startedAt'] = $startedAt;

        return $self;
    }

    public function withViewedAt(?\DateTimeInterface $viewedAt): self
    {
        $self = clone $this;
        $self['viewedAt'] = $viewedAt;

        return $self;
    }
}
