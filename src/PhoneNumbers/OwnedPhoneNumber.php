<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\PhoneNumbers\OwnedPhoneNumber\RegulatoryStatus;

/**
 * @phpstan-import-type OwnedPhoneNumberPricingShape from \Zavudev\PhoneNumbers\OwnedPhoneNumberPricing
 *
 * @phpstan-type OwnedPhoneNumberShape = array{
 *   id: string,
 *   capabilities: list<string>,
 *   createdAt: \DateTimeInterface,
 *   phoneNumber: string,
 *   pricing: OwnedPhoneNumberPricing|OwnedPhoneNumberPricingShape,
 *   regulatoryStatus: RegulatoryStatus|value-of<RegulatoryStatus>,
 *   status: PhoneNumberStatus|value-of<PhoneNumberStatus>,
 *   name?: string|null,
 *   nextRenewalDate?: \DateTimeInterface|null,
 *   senderID?: string|null,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class OwnedPhoneNumber implements BaseModel
{
    /** @use SdkModel<OwnedPhoneNumberShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /** @var list<string> $capabilities */
    #[Required(list: 'string')]
    public array $capabilities;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public string $phoneNumber;

    #[Required]
    public OwnedPhoneNumberPricing $pricing;

    /**
     * Regulatory review state. Numbers that need no review are `approved` immediately. A number bought with regulatory information is owned and billed from purchase and starts `pending_review`; it cannot send messages or place calls until this is `approved`. The state is re-checked every 6 hours: poll `GET /v1/phone-numbers/{phoneNumberId}` to follow it.
     *
     * Assign it to a sender with `PATCH /v1/phone-numbers/{phoneNumberId}` (`senderId`) before or after approval. A number assigned while under review is recorded and connected to that sender when it is approved; the connection is retried until it succeeds. A sender created over the API is set up for SMS as part of the assignment. `rejected` means review refused the information: the number cannot be assigned to a sender. A number that stays `pending_review` may be waiting on information the API cannot supply; contact support.
     *
     * @var value-of<RegulatoryStatus> $regulatoryStatus
     */
    #[Required(enum: RegulatoryStatus::class)]
    public string $regulatoryStatus;

    /**
     * Billing state of an owned number, separate from `regulatoryStatus`. `pending` is legacy and is not written to numbers today. The SDKs carry `active`, `suspended` and `pending` only; `releasing` and `released` are returned by the REST API until their next release.
     *
     * @var value-of<PhoneNumberStatus> $status
     */
    #[Required(enum: PhoneNumberStatus::class)]
    public string $status;

    /**
     * Optional custom name for the phone number.
     */
    #[Optional]
    public ?string $name;

    #[Optional]
    public ?\DateTimeInterface $nextRenewalDate;

    /**
     * Sender ID if the phone number is assigned to a sender.
     */
    #[Optional('senderId')]
    public ?string $senderID;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * `new OwnedPhoneNumber()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OwnedPhoneNumber::with(
     *   id: ...,
     *   capabilities: ...,
     *   createdAt: ...,
     *   phoneNumber: ...,
     *   pricing: ...,
     *   regulatoryStatus: ...,
     *   status: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OwnedPhoneNumber)
     *   ->withID(...)
     *   ->withCapabilities(...)
     *   ->withCreatedAt(...)
     *   ->withPhoneNumber(...)
     *   ->withPricing(...)
     *   ->withRegulatoryStatus(...)
     *   ->withStatus(...)
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
     * @param list<string> $capabilities
     * @param OwnedPhoneNumberPricing|OwnedPhoneNumberPricingShape $pricing
     * @param RegulatoryStatus|value-of<RegulatoryStatus> $regulatoryStatus
     * @param PhoneNumberStatus|value-of<PhoneNumberStatus> $status
     */
    public static function with(
        string $id,
        array $capabilities,
        \DateTimeInterface $createdAt,
        string $phoneNumber,
        OwnedPhoneNumberPricing|array $pricing,
        RegulatoryStatus|string $regulatoryStatus,
        PhoneNumberStatus|string $status,
        ?string $name = null,
        ?\DateTimeInterface $nextRenewalDate = null,
        ?string $senderID = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['capabilities'] = $capabilities;
        $self['createdAt'] = $createdAt;
        $self['phoneNumber'] = $phoneNumber;
        $self['pricing'] = $pricing;
        $self['regulatoryStatus'] = $regulatoryStatus;
        $self['status'] = $status;

        null !== $name && $self['name'] = $name;
        null !== $nextRenewalDate && $self['nextRenewalDate'] = $nextRenewalDate;
        null !== $senderID && $self['senderID'] = $senderID;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param list<string> $capabilities
     */
    public function withCapabilities(array $capabilities): self
    {
        $self = clone $this;
        $self['capabilities'] = $capabilities;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    /**
     * @param OwnedPhoneNumberPricing|OwnedPhoneNumberPricingShape $pricing
     */
    public function withPricing(OwnedPhoneNumberPricing|array $pricing): self
    {
        $self = clone $this;
        $self['pricing'] = $pricing;

        return $self;
    }

    /**
     * Regulatory review state. Numbers that need no review are `approved` immediately. A number bought with regulatory information is owned and billed from purchase and starts `pending_review`; it cannot send messages or place calls until this is `approved`. The state is re-checked every 6 hours: poll `GET /v1/phone-numbers/{phoneNumberId}` to follow it.
     *
     * Assign it to a sender with `PATCH /v1/phone-numbers/{phoneNumberId}` (`senderId`) before or after approval. A number assigned while under review is recorded and connected to that sender when it is approved; the connection is retried until it succeeds. A sender created over the API is set up for SMS as part of the assignment. `rejected` means review refused the information: the number cannot be assigned to a sender. A number that stays `pending_review` may be waiting on information the API cannot supply; contact support.
     *
     * @param RegulatoryStatus|value-of<RegulatoryStatus> $regulatoryStatus
     */
    public function withRegulatoryStatus(
        RegulatoryStatus|string $regulatoryStatus
    ): self {
        $self = clone $this;
        $self['regulatoryStatus'] = $regulatoryStatus;

        return $self;
    }

    /**
     * Billing state of an owned number, separate from `regulatoryStatus`. `pending` is legacy and is not written to numbers today. The SDKs carry `active`, `suspended` and `pending` only; `releasing` and `released` are returned by the REST API until their next release.
     *
     * @param PhoneNumberStatus|value-of<PhoneNumberStatus> $status
     */
    public function withStatus(PhoneNumberStatus|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * Optional custom name for the phone number.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withNextRenewalDate(
        \DateTimeInterface $nextRenewalDate
    ): self {
        $self = clone $this;
        $self['nextRenewalDate'] = $nextRenewalDate;

        return $self;
    }

    /**
     * Sender ID if the phone number is assigned to a sender.
     */
    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
