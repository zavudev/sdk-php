<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Campaigns;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Update a 10DLC campaign in draft status. Cannot update after submission.
 *
 * @see Zavudev\Services\Number10dlc\CampaignsService::update()
 *
 * @phpstan-type CampaignUpdateParamsShape = array{
 *   description?: string|null,
 *   helpMessage?: string|null,
 *   messageFlow?: string|null,
 *   name?: string|null,
 *   optInKeywords?: list<string>|null,
 *   optOutKeywords?: list<string>|null,
 *   sampleMessages?: list<string>|null,
 * }
 */
final class CampaignUpdateParams implements BaseModel
{
    /** @use SdkModel<CampaignUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Optional]
    public ?string $description;

    #[Optional]
    public ?string $helpMessage;

    #[Optional]
    public ?string $messageFlow;

    #[Optional]
    public ?string $name;

    /** @var list<string>|null $optInKeywords */
    #[Optional(list: 'string')]
    public ?array $optInKeywords;

    /** @var list<string>|null $optOutKeywords */
    #[Optional(list: 'string')]
    public ?array $optOutKeywords;

    /** @var list<string>|null $sampleMessages */
    #[Optional(list: 'string')]
    public ?array $sampleMessages;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $optInKeywords
     * @param list<string>|null $optOutKeywords
     * @param list<string>|null $sampleMessages
     */
    public static function with(
        ?string $description = null,
        ?string $helpMessage = null,
        ?string $messageFlow = null,
        ?string $name = null,
        ?array $optInKeywords = null,
        ?array $optOutKeywords = null,
        ?array $sampleMessages = null,
    ): self {
        $self = new self;

        null !== $description && $self['description'] = $description;
        null !== $helpMessage && $self['helpMessage'] = $helpMessage;
        null !== $messageFlow && $self['messageFlow'] = $messageFlow;
        null !== $name && $self['name'] = $name;
        null !== $optInKeywords && $self['optInKeywords'] = $optInKeywords;
        null !== $optOutKeywords && $self['optOutKeywords'] = $optOutKeywords;
        null !== $sampleMessages && $self['sampleMessages'] = $sampleMessages;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

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

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

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
     * @param list<string> $sampleMessages
     */
    public function withSampleMessages(array $sampleMessages): self
    {
        $self = clone $this;
        $self['sampleMessages'] = $sampleMessages;

        return $self;
    }
}
