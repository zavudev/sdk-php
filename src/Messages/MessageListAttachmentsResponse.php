<?php

declare(strict_types=1);

namespace Zavudev\Messages;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Messages\MessageListAttachmentsResponse\Item;

/**
 * @phpstan-import-type ItemShape from \Zavudev\Messages\MessageListAttachmentsResponse\Item
 *
 * @phpstan-type MessageListAttachmentsResponseShape = array{
 *   items: list<Item|ItemShape>
 * }
 */
final class MessageListAttachmentsResponse implements BaseModel
{
    /** @use SdkModel<MessageListAttachmentsResponseShape> */
    use SdkModel;

    /** @var list<Item> $items */
    #[Required(list: Item::class)]
    public array $items;

    /**
     * `new MessageListAttachmentsResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageListAttachmentsResponse::with(items: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageListAttachmentsResponse)->withItems(...)
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
     */
    public static function with(array $items): self
    {
        $self = new self;

        $self['items'] = $items;

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
}
