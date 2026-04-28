<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Campaigns;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Number10dlc\Campaigns\TenDlcCampaign\Status;

/**
 * @phpstan-type TenDlcCampaignShape = array{
 *   id: string,
 *   affiliateMarketing: bool,
 *   ageGated: bool,
 *   brandID: string,
 *   createdAt: \DateTimeInterface,
 *   description: string,
 *   directLending: bool,
 *   embeddedLink: bool,
 *   embeddedPhone: bool,
 *   name: string,
 *   numberPooling: bool,
 *   sampleMessages: list<string>,
 *   status: Status|value-of<Status>,
 *   subscriberHelp: bool,
 *   subscriberOptIn: bool,
 *   subscriberOptOut: bool,
 *   updatedAt: \DateTimeInterface,
 *   useCase: string,
 *   approvedAt?: \DateTimeInterface|null,
 *   dailyLimit?: int|null,
 *   failureReason?: string|null,
 *   helpMessage?: string|null,
 *   messageFlow?: string|null,
 *   monthlyFeeCents?: int|null,
 *   optInKeywords?: list<string>|null,
 *   optOutKeywords?: list<string>|null,
 *   registrationCostCents?: int|null,
 *   submittedAt?: \DateTimeInterface|null,
 *   subUseCases?: list<string>|null,
 * }
 */
final class TenDlcCampaign implements BaseModel
{
    /** @use SdkModel<TenDlcCampaignShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public bool $affiliateMarketing;

    #[Required]
    public bool $ageGated;

    /**
     * ID of the brand this campaign belongs to.
     */
    #[Required('brandId')]
    public string $brandID;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * Description of the messaging campaign.
     */
    #[Required]
    public string $description;

    #[Required]
    public bool $directLending;

    #[Required]
    public bool $embeddedLink;

    #[Required]
    public bool $embeddedPhone;

    #[Required]
    public string $name;

    #[Required]
    public bool $numberPooling;

    /**
     * Sample messages representative of campaign content.
     *
     * @var list<string> $sampleMessages
     */
    #[Required(list: 'string')]
    public array $sampleMessages;

    /**
     * Status of a 10DLC campaign registration.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    #[Required]
    public bool $subscriberHelp;

    #[Required]
    public bool $subscriberOptIn;

    #[Required]
    public bool $subscriberOptOut;

    #[Required]
    public \DateTimeInterface $updatedAt;

    /**
     * Campaign use case type.
     */
    #[Required]
    public string $useCase;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $approvedAt;

    /**
     * Daily message limit based on brand trust score.
     */
    #[Optional(nullable: true)]
    public ?int $dailyLimit;

    #[Optional(nullable: true)]
    public ?string $failureReason;

    #[Optional(nullable: true)]
    public ?string $helpMessage;

    #[Optional(nullable: true)]
    public ?string $messageFlow;

    /**
     * Recurring monthly fee in cents.
     */
    #[Optional(nullable: true)]
    public ?int $monthlyFeeCents;

    /** @var list<string>|null $optInKeywords */
    #[Optional(list: 'string', nullable: true)]
    public ?array $optInKeywords;

    /** @var list<string>|null $optOutKeywords */
    #[Optional(list: 'string', nullable: true)]
    public ?array $optOutKeywords;

    /**
     * One-time registration cost in cents.
     */
    #[Optional(nullable: true)]
    public ?int $registrationCostCents;

    #[Optional(nullable: true)]
    public ?\DateTimeInterface $submittedAt;

    /** @var list<string>|null $subUseCases */
    #[Optional(list: 'string', nullable: true)]
    public ?array $subUseCases;

    /**
     * `new TenDlcCampaign()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TenDlcCampaign::with(
     *   id: ...,
     *   affiliateMarketing: ...,
     *   ageGated: ...,
     *   brandID: ...,
     *   createdAt: ...,
     *   description: ...,
     *   directLending: ...,
     *   embeddedLink: ...,
     *   embeddedPhone: ...,
     *   name: ...,
     *   numberPooling: ...,
     *   sampleMessages: ...,
     *   status: ...,
     *   subscriberHelp: ...,
     *   subscriberOptIn: ...,
     *   subscriberOptOut: ...,
     *   updatedAt: ...,
     *   useCase: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TenDlcCampaign)
     *   ->withID(...)
     *   ->withAffiliateMarketing(...)
     *   ->withAgeGated(...)
     *   ->withBrandID(...)
     *   ->withCreatedAt(...)
     *   ->withDescription(...)
     *   ->withDirectLending(...)
     *   ->withEmbeddedLink(...)
     *   ->withEmbeddedPhone(...)
     *   ->withName(...)
     *   ->withNumberPooling(...)
     *   ->withSampleMessages(...)
     *   ->withStatus(...)
     *   ->withSubscriberHelp(...)
     *   ->withSubscriberOptIn(...)
     *   ->withSubscriberOptOut(...)
     *   ->withUpdatedAt(...)
     *   ->withUseCase(...)
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
     * @param list<string> $sampleMessages
     * @param Status|value-of<Status> $status
     * @param list<string>|null $optInKeywords
     * @param list<string>|null $optOutKeywords
     * @param list<string>|null $subUseCases
     */
    public static function with(
        string $id,
        bool $affiliateMarketing,
        bool $ageGated,
        string $brandID,
        \DateTimeInterface $createdAt,
        string $description,
        bool $directLending,
        bool $embeddedLink,
        bool $embeddedPhone,
        string $name,
        bool $numberPooling,
        array $sampleMessages,
        Status|string $status,
        bool $subscriberHelp,
        bool $subscriberOptIn,
        bool $subscriberOptOut,
        \DateTimeInterface $updatedAt,
        string $useCase,
        ?\DateTimeInterface $approvedAt = null,
        ?int $dailyLimit = null,
        ?string $failureReason = null,
        ?string $helpMessage = null,
        ?string $messageFlow = null,
        ?int $monthlyFeeCents = null,
        ?array $optInKeywords = null,
        ?array $optOutKeywords = null,
        ?int $registrationCostCents = null,
        ?\DateTimeInterface $submittedAt = null,
        ?array $subUseCases = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['affiliateMarketing'] = $affiliateMarketing;
        $self['ageGated'] = $ageGated;
        $self['brandID'] = $brandID;
        $self['createdAt'] = $createdAt;
        $self['description'] = $description;
        $self['directLending'] = $directLending;
        $self['embeddedLink'] = $embeddedLink;
        $self['embeddedPhone'] = $embeddedPhone;
        $self['name'] = $name;
        $self['numberPooling'] = $numberPooling;
        $self['sampleMessages'] = $sampleMessages;
        $self['status'] = $status;
        $self['subscriberHelp'] = $subscriberHelp;
        $self['subscriberOptIn'] = $subscriberOptIn;
        $self['subscriberOptOut'] = $subscriberOptOut;
        $self['updatedAt'] = $updatedAt;
        $self['useCase'] = $useCase;

        null !== $approvedAt && $self['approvedAt'] = $approvedAt;
        null !== $dailyLimit && $self['dailyLimit'] = $dailyLimit;
        null !== $failureReason && $self['failureReason'] = $failureReason;
        null !== $helpMessage && $self['helpMessage'] = $helpMessage;
        null !== $messageFlow && $self['messageFlow'] = $messageFlow;
        null !== $monthlyFeeCents && $self['monthlyFeeCents'] = $monthlyFeeCents;
        null !== $optInKeywords && $self['optInKeywords'] = $optInKeywords;
        null !== $optOutKeywords && $self['optOutKeywords'] = $optOutKeywords;
        null !== $registrationCostCents && $self['registrationCostCents'] = $registrationCostCents;
        null !== $submittedAt && $self['submittedAt'] = $submittedAt;
        null !== $subUseCases && $self['subUseCases'] = $subUseCases;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withAffiliateMarketing(bool $affiliateMarketing): self
    {
        $self = clone $this;
        $self['affiliateMarketing'] = $affiliateMarketing;

        return $self;
    }

    public function withAgeGated(bool $ageGated): self
    {
        $self = clone $this;
        $self['ageGated'] = $ageGated;

        return $self;
    }

    /**
     * ID of the brand this campaign belongs to.
     */
    public function withBrandID(string $brandID): self
    {
        $self = clone $this;
        $self['brandID'] = $brandID;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Description of the messaging campaign.
     */
    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withDirectLending(bool $directLending): self
    {
        $self = clone $this;
        $self['directLending'] = $directLending;

        return $self;
    }

    public function withEmbeddedLink(bool $embeddedLink): self
    {
        $self = clone $this;
        $self['embeddedLink'] = $embeddedLink;

        return $self;
    }

    public function withEmbeddedPhone(bool $embeddedPhone): self
    {
        $self = clone $this;
        $self['embeddedPhone'] = $embeddedPhone;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withNumberPooling(bool $numberPooling): self
    {
        $self = clone $this;
        $self['numberPooling'] = $numberPooling;

        return $self;
    }

    /**
     * Sample messages representative of campaign content.
     *
     * @param list<string> $sampleMessages
     */
    public function withSampleMessages(array $sampleMessages): self
    {
        $self = clone $this;
        $self['sampleMessages'] = $sampleMessages;

        return $self;
    }

    /**
     * Status of a 10DLC campaign registration.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withSubscriberHelp(bool $subscriberHelp): self
    {
        $self = clone $this;
        $self['subscriberHelp'] = $subscriberHelp;

        return $self;
    }

    public function withSubscriberOptIn(bool $subscriberOptIn): self
    {
        $self = clone $this;
        $self['subscriberOptIn'] = $subscriberOptIn;

        return $self;
    }

    public function withSubscriberOptOut(bool $subscriberOptOut): self
    {
        $self = clone $this;
        $self['subscriberOptOut'] = $subscriberOptOut;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Campaign use case type.
     */
    public function withUseCase(string $useCase): self
    {
        $self = clone $this;
        $self['useCase'] = $useCase;

        return $self;
    }

    public function withApprovedAt(?\DateTimeInterface $approvedAt): self
    {
        $self = clone $this;
        $self['approvedAt'] = $approvedAt;

        return $self;
    }

    /**
     * Daily message limit based on brand trust score.
     */
    public function withDailyLimit(?int $dailyLimit): self
    {
        $self = clone $this;
        $self['dailyLimit'] = $dailyLimit;

        return $self;
    }

    public function withFailureReason(?string $failureReason): self
    {
        $self = clone $this;
        $self['failureReason'] = $failureReason;

        return $self;
    }

    public function withHelpMessage(?string $helpMessage): self
    {
        $self = clone $this;
        $self['helpMessage'] = $helpMessage;

        return $self;
    }

    public function withMessageFlow(?string $messageFlow): self
    {
        $self = clone $this;
        $self['messageFlow'] = $messageFlow;

        return $self;
    }

    /**
     * Recurring monthly fee in cents.
     */
    public function withMonthlyFeeCents(?int $monthlyFeeCents): self
    {
        $self = clone $this;
        $self['monthlyFeeCents'] = $monthlyFeeCents;

        return $self;
    }

    /**
     * @param list<string>|null $optInKeywords
     */
    public function withOptInKeywords(?array $optInKeywords): self
    {
        $self = clone $this;
        $self['optInKeywords'] = $optInKeywords;

        return $self;
    }

    /**
     * @param list<string>|null $optOutKeywords
     */
    public function withOptOutKeywords(?array $optOutKeywords): self
    {
        $self = clone $this;
        $self['optOutKeywords'] = $optOutKeywords;

        return $self;
    }

    /**
     * One-time registration cost in cents.
     */
    public function withRegistrationCostCents(?int $registrationCostCents): self
    {
        $self = clone $this;
        $self['registrationCostCents'] = $registrationCostCents;

        return $self;
    }

    public function withSubmittedAt(?\DateTimeInterface $submittedAt): self
    {
        $self = clone $this;
        $self['submittedAt'] = $submittedAt;

        return $self;
    }

    /**
     * @param list<string>|null $subUseCases
     */
    public function withSubUseCases(?array $subUseCases): self
    {
        $self = clone $this;
        $self['subUseCases'] = $subUseCases;

        return $self;
    }
}
