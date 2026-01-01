<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\KnowledgeBases\Documents;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * List documents in a knowledge base.
 *
 * @see Zavudev\Services\Senders\Agent\KnowledgeBases\DocumentsService::list()
 *
 * @phpstan-type DocumentListParamsShape = array{
 *   senderID: string, cursor?: string|null, limit?: int|null
 * }
 */
final class DocumentListParams implements BaseModel
{
    /** @use SdkModel<DocumentListParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $senderID;

    #[Optional]
    public ?string $cursor;

    #[Optional]
    public ?int $limit;

    /**
     * `new DocumentListParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DocumentListParams::with(senderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DocumentListParams)->withSenderID(...)
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
        ?string $cursor = null,
        ?int $limit = null
    ): self {
        $self = new self;

        $self['senderID'] = $senderID;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $limit && $self['limit'] = $limit;

        return $self;
    }

    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }

    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }
}
