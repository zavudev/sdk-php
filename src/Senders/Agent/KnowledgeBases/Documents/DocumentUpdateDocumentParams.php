<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\KnowledgeBases\Documents;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Update a document's title or content. Updating content reprocesses the document for RAG.
 *
 * @see Zavudev\Services\Senders\Agent\KnowledgeBases\DocumentsService::updateDocument()
 *
 * @phpstan-type DocumentUpdateDocumentParamsShape = array{
 *   senderID: string, kbID: string, content?: string|null, title?: string|null
 * }
 */
final class DocumentUpdateDocumentParams implements BaseModel
{
    /** @use SdkModel<DocumentUpdateDocumentParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $senderID;

    #[Required]
    public string $kbID;

    #[Optional]
    public ?string $content;

    #[Optional]
    public ?string $title;

    /**
     * `new DocumentUpdateDocumentParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DocumentUpdateDocumentParams::with(senderID: ..., kbID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DocumentUpdateDocumentParams)->withSenderID(...)->withKBID(...)
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
        string $senderID,
        string $kbID,
        ?string $content = null,
        ?string $title = null
    ): self {
        $self = new self;

        $self['senderID'] = $senderID;
        $self['kbID'] = $kbID;

        null !== $content && $self['content'] = $content;
        null !== $title && $self['title'] = $title;

        return $self;
    }

    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }

    public function withKBID(string $kbID): self
    {
        $self = clone $this;
        $self['kbID'] = $kbID;

        return $self;
    }

    public function withContent(string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }
}
