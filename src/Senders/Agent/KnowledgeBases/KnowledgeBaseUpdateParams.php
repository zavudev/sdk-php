<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\KnowledgeBases;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Update a knowledge base.
 *
 * @see Zavudev\Services\Senders\Agent\KnowledgeBasesService::update()
 *
 * @phpstan-type KnowledgeBaseUpdateParamsShape = array{
 *   senderID: string, description?: string|null, name?: string|null
 * }
 */
final class KnowledgeBaseUpdateParams implements BaseModel
{
    /** @use SdkModel<KnowledgeBaseUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $senderID;

    #[Optional(nullable: true)]
    public ?string $description;

    #[Optional]
    public ?string $name;

    /**
     * `new KnowledgeBaseUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * KnowledgeBaseUpdateParams::with(senderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new KnowledgeBaseUpdateParams)->withSenderID(...)
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
        ?string $description = null,
        ?string $name = null
    ): self {
        $self = new self;

        $self['senderID'] = $senderID;

        null !== $description && $self['description'] = $description;
        null !== $name && $self['name'] = $name;

        return $self;
    }

    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }

    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
