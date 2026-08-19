<?php

declare(strict_types=1);

namespace Zavudev\Agents;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * The voices an agent can speak with, for `voice.ttsVoiceId`. Filter by `language` to get the ones that speak it; a voice can still be used with `language: auto`, where the agent follows the caller and keeps the chosen voice.
 *
 * @see Zavudev\Services\AgentsService::listVoices()
 *
 * @phpstan-type AgentListVoicesParamsShape = array{language?: string|null}
 */
final class AgentListVoicesParams implements BaseModel
{
    /** @use SdkModel<AgentListVoicesParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * BCP-47 tag (`en`, `es`, `pt-BR`). Omit, or pass `auto`, for every voice.
     */
    #[Optional]
    public ?string $language;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $language = null): self
    {
        $self = new self;

        null !== $language && $self['language'] = $language;

        return $self;
    }

    /**
     * BCP-47 tag (`en`, `es`, `pt-BR`). Omit, or pass `auto`, for every voice.
     */
    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }
}
