<?php

declare(strict_types=1);

namespace Zavudev\SubAccounts\APIKeys;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\SubAccounts\APIKeys\APIKeyListResponse\Item;

/**
 * @phpstan-import-type ItemShape from \Zavudev\SubAccounts\APIKeys\APIKeyListResponse\Item
 *
 * @phpstan-type APIKeyListResponseShape = array{items: list<Item|ItemShape>}
 */
final class APIKeyListResponse implements BaseModel
{
    /** @use SdkModel<APIKeyListResponseShape> */
    use SdkModel;

    /** @var list<Item> $items */
    #[Required(list: Item::class)]
    public array $items;

    /**
     * `new APIKeyListResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * APIKeyListResponse::with(items: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new APIKeyListResponse)->withItems(...)
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
