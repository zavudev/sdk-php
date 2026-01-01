<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\KnowledgeBases\Documents;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Delete a document from a knowledge base.
 *
 * @see Zavudev\Services\Senders\Agent\KnowledgeBases\DocumentsService::delete()
 *
 * @phpstan-type DocumentDeleteParamsShape = array{senderID: string, kbID: string}
 */
final class DocumentDeleteParams implements BaseModel
{
    /** @use SdkModel<DocumentDeleteParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $senderID;

    #[Required]
    public string $kbID;

    /**
     * `new DocumentDeleteParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DocumentDeleteParams::with(senderID: ..., kbID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DocumentDeleteParams)->withSenderID(...)->withKBID(...)
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
    public static function with(string $senderID, string $kbID): self
    {
        $self = new self;

        $self['senderID'] = $senderID;
        $self['kbID'] = $kbID;

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
}
