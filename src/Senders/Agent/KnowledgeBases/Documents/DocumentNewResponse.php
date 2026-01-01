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
 * @phpstan-type DocumentNewResponseShape = array{
 *   document: AgentDocument|AgentDocumentShape
 * }
 */
final class DocumentNewResponse implements BaseModel
{
    /** @use SdkModel<DocumentNewResponseShape> */
    use SdkModel;

    #[Required]
    public AgentDocument $document;

    /**
     * `new DocumentNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DocumentNewResponse::with(document: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DocumentNewResponse)->withDocument(...)
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
