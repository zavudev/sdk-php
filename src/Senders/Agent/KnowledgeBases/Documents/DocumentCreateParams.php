<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\KnowledgeBases\Documents;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Add a document to a knowledge base. The document will be automatically processed for RAG.
 *
 * @see Zavudev\Services\Senders\Agent\KnowledgeBases\DocumentsService::create()
 *
 * @phpstan-type DocumentCreateParamsShape = array{
 *   senderID: string, content: string, title: string
 * }
 */
final class DocumentCreateParams implements BaseModel
{
    /** @use SdkModel<DocumentCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $senderID;

    #[Required]
    public string $content;

    #[Required]
    public string $title;

    /**
     * `new DocumentCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DocumentCreateParams::with(senderID: ..., content: ..., title: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DocumentCreateParams)->withSenderID(...)->withContent(...)->withTitle(...)
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
        string $content,
        string $title
    ): self {
        $self = new self;

        $self['senderID'] = $senderID;
        $self['content'] = $content;
        $self['title'] = $title;

        return $self;
    }

    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

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
