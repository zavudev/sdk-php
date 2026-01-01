<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\KnowledgeBases;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type AgentDocumentShape = array{
 *   id: string,
 *   chunkCount: int,
 *   contentLength: int,
 *   createdAt: \DateTimeInterface,
 *   isProcessed: bool,
 *   knowledgeBaseID: string,
 *   title: string,
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class AgentDocument implements BaseModel
{
    /** @use SdkModel<AgentDocumentShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * Number of chunks created from this document.
     */
    #[Required]
    public int $chunkCount;

    /**
     * Length of the document content in characters.
     */
    #[Required]
    public int $contentLength;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * Whether the document has been processed for RAG.
     */
    #[Required]
    public bool $isProcessed;

    #[Required('knowledgeBaseId')]
    public string $knowledgeBaseID;

    #[Required]
    public string $title;

    #[Required]
    public \DateTimeInterface $updatedAt;

    /**
     * `new AgentDocument()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AgentDocument::with(
     *   id: ...,
     *   chunkCount: ...,
     *   contentLength: ...,
     *   createdAt: ...,
     *   isProcessed: ...,
     *   knowledgeBaseID: ...,
     *   title: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AgentDocument)
     *   ->withID(...)
     *   ->withChunkCount(...)
     *   ->withContentLength(...)
     *   ->withCreatedAt(...)
     *   ->withIsProcessed(...)
     *   ->withKnowledgeBaseID(...)
     *   ->withTitle(...)
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
        int $chunkCount,
        int $contentLength,
        \DateTimeInterface $createdAt,
        bool $isProcessed,
        string $knowledgeBaseID,
        string $title,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['chunkCount'] = $chunkCount;
        $self['contentLength'] = $contentLength;
        $self['createdAt'] = $createdAt;
        $self['isProcessed'] = $isProcessed;
        $self['knowledgeBaseID'] = $knowledgeBaseID;
        $self['title'] = $title;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Number of chunks created from this document.
     */
    public function withChunkCount(int $chunkCount): self
    {
        $self = clone $this;
        $self['chunkCount'] = $chunkCount;

        return $self;
    }

    /**
     * Length of the document content in characters.
     */
    public function withContentLength(int $contentLength): self
    {
        $self = clone $this;
        $self['contentLength'] = $contentLength;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Whether the document has been processed for RAG.
     */
    public function withIsProcessed(bool $isProcessed): self
    {
        $self = clone $this;
        $self['isProcessed'] = $isProcessed;

        return $self;
    }

    public function withKnowledgeBaseID(string $knowledgeBaseID): self
    {
        $self = clone $this;
        $self['knowledgeBaseID'] = $knowledgeBaseID;

        return $self;
    }

    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
