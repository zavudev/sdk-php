<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\KnowledgeBases;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Get a specific knowledge base.
 *
 * @see Zavudev\Services\Senders\Agent\KnowledgeBasesService::retrieve()
 *
 * @phpstan-type KnowledgeBaseRetrieveParamsShape = array{senderID: string}
 */
final class KnowledgeBaseRetrieveParams implements BaseModel
{
    /** @use SdkModel<KnowledgeBaseRetrieveParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $senderID;

    /**
     * `new KnowledgeBaseRetrieveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * KnowledgeBaseRetrieveParams::with(senderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new KnowledgeBaseRetrieveParams)->withSenderID(...)
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
    public static function with(string $senderID): self
    {
        $self = new self;

        $self['senderID'] = $senderID;

        return $self;
    }

    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }
}
