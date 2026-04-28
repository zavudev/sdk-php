<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Campaigns;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Create a 10DLC campaign under an existing brand. The campaign starts in draft status. Submit it for carrier review using the submit endpoint.
 *
 * @see Zavudev\Services\Number10dlc\CampaignsService::create()
 *
 * @phpstan-type CampaignCreateParamsShape = array{
 *   affiliateMarketing: bool,
 *   ageGated: bool,
 *   brandID: string,
 *   description: string,
 *   directLending: bool,
 *   embeddedLink: bool,
 *   embeddedPhone: bool,
 *   name: string,
 *   numberPooling: bool,
 *   sampleMessages: list<string>,
 *   subscriberHelp: bool,
 *   subscriberOptIn: bool,
 *   subscriberOptOut: bool,
 *   useCase: string,
 *   helpMessage?: string|null,
 *   messageFlow?: string|null,
 *   optInKeywords?: list<string>|null,
 *   optOutKeywords?: list<string>|null,
 *   subUseCases?: list<string>|null,
 * }
 */
final class CampaignCreateParams implements BaseModel
{
    /** @use SdkModel<CampaignCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public bool $affiliateMarketing;

    #[Required]
    public bool $ageGated;

    /**
     * ID of the brand to create this campaign under.
     */
    #[Required('brandId')]
    public string $brandID;

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

    /** @var list<string> $sampleMessages */
    #[Required(list: 'string')]
    public array $sampleMessages;

    #[Required]
    public bool $subscriberHelp;

    #[Required]
    public bool $subscriberOptIn;

    #[Required]
    public bool $subscriberOptOut;

    /**
     * Campaign use case (e.g., ACCOUNT_NOTIFICATION, MARKETING, 2FA).
     */
    #[Required]
    public string $useCase;

    #[Optional]
    public ?string $helpMessage;

    #[Optional]
    public ?string $messageFlow;

    /** @var list<string>|null $optInKeywords */
    #[Optional(list: 'string')]
    public ?array $optInKeywords;

    /** @var list<string>|null $optOutKeywords */
    #[Optional(list: 'string')]
    public ?array $optOutKeywords;

    /** @var list<string>|null $subUseCases */
    #[Optional(list: 'string')]
    public ?array $subUseCases;

    /**
     * `new CampaignCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CampaignCreateParams::with(
     *   affiliateMarketing: ...,
     *   ageGated: ...,
     *   brandID: ...,
     *   description: ...,
     *   directLending: ...,
     *   embeddedLink: ...,
     *   embeddedPhone: ...,
     *   name: ...,
     *   numberPooling: ...,
     *   sampleMessages: ...,
     *   subscriberHelp: ...,
     *   subscriberOptIn: ...,
     *   subscriberOptOut: ...,
     *   useCase: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CampaignCreateParams)
     *   ->withAffiliateMarketing(...)
     *   ->withAgeGated(...)
     *   ->withBrandID(...)
     *   ->withDescription(...)
     *   ->withDirectLending(...)
     *   ->withEmbeddedLink(...)
     *   ->withEmbeddedPhone(...)
     *   ->withName(...)
     *   ->withNumberPooling(...)
     *   ->withSampleMessages(...)
     *   ->withSubscriberHelp(...)
     *   ->withSubscriberOptIn(...)
     *   ->withSubscriberOptOut(...)
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
     * @param list<string>|null $optInKeywords
     * @param list<string>|null $optOutKeywords
     * @param list<string>|null $subUseCases
     */
    public static function with(
        bool $affiliateMarketing,
        bool $ageGated,
        string $brandID,
        string $description,
        bool $directLending,
        bool $embeddedLink,
        bool $embeddedPhone,
        string $name,
        bool $numberPooling,
        array $sampleMessages,
        bool $subscriberHelp,
        bool $subscriberOptIn,
        bool $subscriberOptOut,
        string $useCase,
        ?string $helpMessage = null,
        ?string $messageFlow = null,
        ?array $optInKeywords = null,
        ?array $optOutKeywords = null,
        ?array $subUseCases = null,
    ): self {
        $self = new self;

        $self['affiliateMarketing'] = $affiliateMarketing;
        $self['ageGated'] = $ageGated;
        $self['brandID'] = $brandID;
        $self['description'] = $description;
        $self['directLending'] = $directLending;
        $self['embeddedLink'] = $embeddedLink;
        $self['embeddedPhone'] = $embeddedPhone;
        $self['name'] = $name;
        $self['numberPooling'] = $numberPooling;
        $self['sampleMessages'] = $sampleMessages;
        $self['subscriberHelp'] = $subscriberHelp;
        $self['subscriberOptIn'] = $subscriberOptIn;
        $self['subscriberOptOut'] = $subscriberOptOut;
        $self['useCase'] = $useCase;

        null !== $helpMessage && $self['helpMessage'] = $helpMessage;
        null !== $messageFlow && $self['messageFlow'] = $messageFlow;
        null !== $optInKeywords && $self['optInKeywords'] = $optInKeywords;
        null !== $optOutKeywords && $self['optOutKeywords'] = $optOutKeywords;
        null !== $subUseCases && $self['subUseCases'] = $subUseCases;

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
     * ID of the brand to create this campaign under.
     */
    public function withBrandID(string $brandID): self
    {
        $self = clone $this;
        $self['brandID'] = $brandID;

        return $self;
    }

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
     * @param list<string> $sampleMessages
     */
    public function withSampleMessages(array $sampleMessages): self
    {
        $self = clone $this;
        $self['sampleMessages'] = $sampleMessages;

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

    /**
     * Campaign use case (e.g., ACCOUNT_NOTIFICATION, MARKETING, 2FA).
     */
    public function withUseCase(string $useCase): self
    {
        $self = clone $this;
        $self['useCase'] = $useCase;

        return $self;
    }

    public function withHelpMessage(string $helpMessage): self
    {
        $self = clone $this;
        $self['helpMessage'] = $helpMessage;

        return $self;
    }

    public function withMessageFlow(string $messageFlow): self
    {
        $self = clone $this;
        $self['messageFlow'] = $messageFlow;

        return $self;
    }

    /**
     * @param list<string> $optInKeywords
     */
    public function withOptInKeywords(array $optInKeywords): self
    {
        $self = clone $this;
        $self['optInKeywords'] = $optInKeywords;

        return $self;
    }

    /**
     * @param list<string> $optOutKeywords
     */
    public function withOptOutKeywords(array $optOutKeywords): self
    {
        $self = clone $this;
        $self['optOutKeywords'] = $optOutKeywords;

        return $self;
    }

    /**
     * @param list<string> $subUseCases
     */
    public function withSubUseCases(array $subUseCases): self
    {
        $self = clone $this;
        $self['subUseCases'] = $subUseCases;

        return $self;
    }
}
