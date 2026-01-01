<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\KnowledgeBases;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type AgentKnowledgeBaseShape from \Zavudev\Senders\Agent\KnowledgeBases\AgentKnowledgeBase
 *
 * @phpstan-type KnowledgeBaseUpdateResponseShape = array{
 *   knowledgeBase: AgentKnowledgeBase|AgentKnowledgeBaseShape
 * }
 */
final class KnowledgeBaseUpdateResponse implements BaseModel
{
    /** @use SdkModel<KnowledgeBaseUpdateResponseShape> */
    use SdkModel;

    #[Required]
    public AgentKnowledgeBase $knowledgeBase;

    /**
     * `new KnowledgeBaseUpdateResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * KnowledgeBaseUpdateResponse::with(knowledgeBase: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new KnowledgeBaseUpdateResponse)->withKnowledgeBase(...)
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
     * @param AgentKnowledgeBase|AgentKnowledgeBaseShape $knowledgeBase
     */
    public static function with(AgentKnowledgeBase|array $knowledgeBase): self
    {
        $self = new self;

        $self['knowledgeBase'] = $knowledgeBase;

        return $self;
    }

    /**
     * @param AgentKnowledgeBase|AgentKnowledgeBaseShape $knowledgeBase
     */
    public function withKnowledgeBase(
        AgentKnowledgeBase|array $knowledgeBase
    ): self {
        $self = clone $this;
        $self['knowledgeBase'] = $knowledgeBase;

        return $self;
    }
}
