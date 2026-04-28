<?php

declare(strict_types=1);

namespace Zavudev\Invitations;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Invitations\Invitation\Status;

/**
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
     * ID of a pre-assigned Zavu phone number for WhatsApp registration.
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
     * ID of a pre-assigned Zavu phone number for WhatsApp registration.
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
