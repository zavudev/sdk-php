<?php

declare(strict_types=1);

namespace Zavudev\Agents\AgentListVoicesResponse;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type ItemShape = array{id: string, language: string, name: string}
 */
final class Item implements BaseModel
{
    /** @use SdkModel<ItemShape> */
    use SdkModel;

    /**
     * Value for `voice.ttsVoiceId`.
     */
    #[Required]
    public string $id;

    #[Required]
    public string $language;

    #[Required]
    public string $name;

    /**
     * `new Item()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Item::with(id: ..., language: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Item)->withID(...)->withLanguage(...)->withName(...)
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
        string $id,
        string $language,
        string $name
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['language'] = $language;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Value for `voice.ttsVoiceId`.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }
}
