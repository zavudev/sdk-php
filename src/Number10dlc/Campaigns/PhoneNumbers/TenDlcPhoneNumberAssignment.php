<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Campaigns\PhoneNumbers;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Number10dlc\Campaigns\PhoneNumbers\TenDlcPhoneNumberAssignment\Status;

/**
 * @phpstan-type TenDlcPhoneNumberAssignmentShape = array{
 *   id: string,
 *   campaignID: string,
 *   createdAt: \DateTimeInterface,
 *   phoneNumberID: string,
 *   status: Status|value-of<Status>,
 *   updatedAt: \DateTimeInterface,
 *   assignedAt?: \DateTimeInterface|null,
 *   failureReason?: string|null,
 * }
 */
final class TenDlcPhoneNumberAssignment implements BaseModel
{
    /** @use SdkModel<TenDlcPhoneNumberAssignmentShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required('campaignId')]
    public string $campaignID;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required('phoneNumberId')]
    public string $phoneNumberID;

    /**
     * Assignment status.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    #[Required]
    public \DateTimeInterface $updatedAt;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $assignedAt;

    #[Optional(nullable: true)]
    public ?string $failureReason;

    /**
     * `new TenDlcPhoneNumberAssignment()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TenDlcPhoneNumberAssignment::with(
     *   id: ...,
     *   campaignID: ...,
     *   createdAt: ...,
     *   phoneNumberID: ...,
     *   status: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TenDlcPhoneNumberAssignment)
     *   ->withID(...)
     *   ->withCampaignID(...)
     *   ->withCreatedAt(...)
     *   ->withPhoneNumberID(...)
     *   ->withStatus(...)
     *   ->withUpdatedAt(...)
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
        string $campaignID,
        \DateTimeInterface $createdAt,
        string $phoneNumberID,
        Status|string $status,
        \DateTimeInterface $updatedAt,
        ?\DateTimeInterface $assignedAt = null,
        ?string $failureReason = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['campaignID'] = $campaignID;
        $self['createdAt'] = $createdAt;
        $self['phoneNumberID'] = $phoneNumberID;
        $self['status'] = $status;
        $self['updatedAt'] = $updatedAt;

        null !== $assignedAt && $self['assignedAt'] = $assignedAt;
        null !== $failureReason && $self['failureReason'] = $failureReason;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCampaignID(string $campaignID): self
    {
        $self = clone $this;
        $self['campaignID'] = $campaignID;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withPhoneNumberID(string $phoneNumberID): self
    {
        $self = clone $this;
        $self['phoneNumberID'] = $phoneNumberID;

        return $self;
    }

    /**
     * Assignment status.
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

    public function withAssignedAt(?\DateTimeInterface $assignedAt): self
    {
        $self = clone $this;
        $self['assignedAt'] = $assignedAt;

        return $self;
    }

    public function withFailureReason(?string $failureReason): self
    {
        $self = clone $this;
        $self['failureReason'] = $failureReason;

        return $self;
    }
}
