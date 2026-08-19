<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\KnowledgeBases\Documents;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Senders\Agent\KnowledgeBases\AgentDocument;

/**
 * @phpstan-import-type AgentDocumentShape from \Zavudev\Senders\Agent\KnowledgeBases\AgentDocument
 *
 * @phpstan-type DocumentGetDocumentResponseShape = array{
 *   document: AgentDocument|AgentDocumentShape
 * }
 */
final class DocumentGetDocumentResponse implements BaseModel
{
    /** @use SdkModel<DocumentGetDocumentResponseShape> */
    use SdkModel;

    #[Required]
    public AgentDocument $document;

    /**
     * `new DocumentGetDocumentResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DocumentGetDocumentResponse::with(document: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DocumentGetDocumentResponse)->withDocument(...)
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
     * @param AgentDocument|AgentDocumentShape $document
     */
    public static function with(AgentDocument|array $document): self
    {
        $self = new self;

        $self['document'] = $document;

        return $self;
    }

    /**
     * @param AgentDocument|AgentDocumentShape $document
     */
    public function withDocument(AgentDocument|array $document): self
    {
        $self = clone $this;
        $self['document'] = $document;

        return $self;
    }
}
