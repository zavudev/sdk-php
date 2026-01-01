<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\KnowledgeBases;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Create a new knowledge base for an agent.
 *
 * @see Zavudev\Services\Senders\Agent\KnowledgeBasesService::create()
 *
 * @phpstan-type KnowledgeBaseCreateParamsShape = array{
 *   name: string, description?: string|null
 * }
 */
final class KnowledgeBaseCreateParams implements BaseModel
{
    /** @use SdkModel<KnowledgeBaseCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $name;

    #[Optional]
    public ?string $description;

    /**
     * `new KnowledgeBaseCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * KnowledgeBaseCreateParams::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new KnowledgeBaseCreateParams)->withName(...)
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
    public static function with(string $name, ?string $description = null): self
    {
        $self = new self;

        $self['name'] = $name;

        null !== $description && $self['description'] = $description;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withDescription(string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }
}
