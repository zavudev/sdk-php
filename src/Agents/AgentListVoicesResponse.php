<?php

declare(strict_types=1);

namespace Zavudev\Agents;

use Zavudev\Agents\AgentListVoicesResponse\Item;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ItemShape from \Zavudev\Agents\AgentListVoicesResponse\Item
 *
 * @phpstan-type AgentListVoicesResponseShape = array{
 *   items: list<Item|ItemShape>, languages: list<string>, total?: int|null
 * }
 */
final class AgentListVoicesResponse implements BaseModel
{
    /** @use SdkModel<AgentListVoicesResponseShape> */
    use SdkModel;

    /** @var list<Item> $items */
    #[Required(list: Item::class)]
    public array $items;

    /**
     * Languages an agent can be pinned to. `auto` follows the caller.
     *
     * @var list<string> $languages
     */
    #[Required(list: 'string')]
    public array $languages;

    /**
     * Voices in the catalog, before filtering.
     */
    #[Optional]
    public ?int $total;

    /**
     * `new AgentListVoicesResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AgentListVoicesResponse::with(items: ..., languages: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AgentListVoicesResponse)->withItems(...)->withLanguages(...)
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
     * @param list<Item|ItemShape> $items
     * @param list<string> $languages
     */
    public static function with(
        array $items,
        array $languages,
        ?int $total = null
    ): self {
        $self = new self;

        $self['items'] = $items;
        $self['languages'] = $languages;

        null !== $total && $self['total'] = $total;

        return $self;
    }

    /**
     * @param list<Item|ItemShape> $items
     */
    public function withItems(array $items): self
    {
        $self = clone $this;
        $self['items'] = $items;

        return $self;
    }

    /**
     * Languages an agent can be pinned to. `auto` follows the caller.
     *
     * @param list<string> $languages
     */
    public function withLanguages(array $languages): self
    {
        $self = clone $this;
        $self['languages'] = $languages;

        return $self;
    }

    /**
     * Voices in the catalog, before filtering.
     */
    public function withTotal(int $total): self
    {
        $self = clone $this;
        $self['total'] = $total;

        return $self;
    }
}
