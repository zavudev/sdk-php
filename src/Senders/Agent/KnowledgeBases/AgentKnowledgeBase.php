<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\KnowledgeBases;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type AgentKnowledgeBaseShape = array{
 *   id: string,
 *   agentID: string,
 *   createdAt: \DateTimeInterface,
 *   documentCount: int,
 *   name: string,
 *   totalChunks: int,
 *   updatedAt: \DateTimeInterface,
 *   description?: string|null,
 * }
 */
final class AgentKnowledgeBase implements BaseModel
{
    /** @use SdkModel<AgentKnowledgeBaseShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required('agentId')]
    public string $agentID;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public int $documentCount;

    #[Required]
    public string $name;

    #[Required]
    public int $totalChunks;

    #[Required]
    public \DateTimeInterface $updatedAt;

    #[Optional(nullable: true)]
    public ?string $description;

    /**
     * `new AgentKnowledgeBase()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AgentKnowledgeBase::with(
     *   id: ...,
     *   agentID: ...,
     *   createdAt: ...,
     *   documentCount: ...,
     *   name: ...,
     *   totalChunks: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AgentKnowledgeBase)
     *   ->withID(...)
     *   ->withAgentID(...)
     *   ->withCreatedAt(...)
     *   ->withDocumentCount(...)
     *   ->withName(...)
     *   ->withTotalChunks(...)
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
     */
    public static function with(
        string $id,
        string $agentID,
        \DateTimeInterface $createdAt,
        int $documentCount,
        string $name,
        int $totalChunks,
        \DateTimeInterface $updatedAt,
        ?string $description = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['agentID'] = $agentID;
        $self['createdAt'] = $createdAt;
        $self['documentCount'] = $documentCount;
        $self['name'] = $name;
        $self['totalChunks'] = $totalChunks;
        $self['updatedAt'] = $updatedAt;

        null !== $description && $self['description'] = $description;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withAgentID(string $agentID): self
    {
        $self = clone $this;
        $self['agentID'] = $agentID;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    public function withDocumentCount(int $documentCount): self
    {
        $self = clone $this;
        $self['documentCount'] = $documentCount;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withTotalChunks(int $totalChunks): self
    {
        $self = clone $this;
        $self['totalChunks'] = $totalChunks;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }
}
