<?php

declare(strict_types=1);

namespace Zavudev\RegulatoryDocuments;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type RegulatoryDocumentShape from \Zavudev\RegulatoryDocuments\RegulatoryDocument
 *
 * @phpstan-type RegulatoryDocumentNewResponseShape = array{
 *   document: RegulatoryDocument|RegulatoryDocumentShape
 * }
 */
final class RegulatoryDocumentNewResponse implements BaseModel
{
    /** @use SdkModel<RegulatoryDocumentNewResponseShape> */
    use SdkModel;

    /**
     * A regulatory document for phone number requirements.
     */
    #[Required]
    public RegulatoryDocument $document;

    /**
     * `new RegulatoryDocumentNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RegulatoryDocumentNewResponse::with(document: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RegulatoryDocumentNewResponse)->withDocument(...)
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
     * @param RegulatoryDocument|RegulatoryDocumentShape $document
     */
    public static function with(RegulatoryDocument|array $document): self
    {
        $self = new self;

        $self['document'] = $document;

        return $self;
    }

    /**
     * A regulatory document for phone number requirements.
     *
     * @param RegulatoryDocument|RegulatoryDocumentShape $document
     */
    public function withDocument(RegulatoryDocument|array $document): self
    {
        $self = clone $this;
        $self['document'] = $document;

        return $self;
    }
}
