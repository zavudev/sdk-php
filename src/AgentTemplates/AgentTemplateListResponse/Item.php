<?php

declare(strict_types=1);

namespace Zavudev\AgentTemplates\AgentTemplateListResponse;

use Zavudev\AgentTemplates\AgentTemplateListResponse\Item\Category;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Compact catalog entry for a factory agent.
 *
 * @phpstan-type ItemShape = array{
 *   id: string,
 *   category: Category|value-of<Category>,
 *   name: string,
 *   summary: string,
 *   toolCount: int,
 *   voice: bool,
 * }
 */
final class Item implements BaseModel
{
    /** @use SdkModel<ItemShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /** @var value-of<Category> $category */
    #[Required(enum: Category::class)]
    public string $category;

    #[Required]
    public string $name;

    #[Required]
    public string $summary;

    #[Required]
    public int $toolCount;

    /**
     * Whether this agent answers phone calls.
     */
    #[Required]
    public bool $voice;

    /**
     * `new Item()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Item::with(
     *   id: ..., category: ..., name: ..., summary: ..., toolCount: ..., voice: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Item)
     *   ->withID(...)
     *   ->withCategory(...)
     *   ->withName(...)
     *   ->withSummary(...)
     *   ->withToolCount(...)
     *   ->withVoice(...)
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
     * @param Category|value-of<Category> $category
     */
    public static function with(
        string $id,
        Category|string $category,
        string $name,
        string $summary,
        int $toolCount,
        bool $voice,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['category'] = $category;
        $self['name'] = $name;
        $self['summary'] = $summary;
        $self['toolCount'] = $toolCount;
        $self['voice'] = $voice;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param Category|value-of<Category> $category
     */
    public function withCategory(Category|string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withSummary(string $summary): self
    {
        $self = clone $this;
        $self['summary'] = $summary;

        return $self;
    }

    public function withToolCount(int $toolCount): self
    {
        $self = clone $this;
        $self['toolCount'] = $toolCount;

        return $self;
    }

    /**
     * Whether this agent answers phone calls.
     */
    public function withVoice(bool $voice): self
    {
        $self = clone $this;
        $self['voice'] = $voice;

        return $self;
    }
}
