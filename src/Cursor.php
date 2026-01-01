<?php

namespace Zavudev;

use Psr\Http\Message\ResponseInterface;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkPage;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Core\Contracts\BasePage;
use Zavudev\Core\Conversion;
use Zavudev\Core\Conversion\Contracts\Converter;
use Zavudev\Core\Conversion\Contracts\ConverterSource;
use Zavudev\Core\Conversion\ListOf;

/**
 * @phpstan-type CursorShape = array{
 *   items?: list<array<string,mixed>>|null, nextCursor?: string|null
 * }
 *
 * @template TItem
 *
 * @implements BasePage<TItem>
 */
final class Cursor implements BaseModel, BasePage
{
    /** @use SdkModel<CursorShape> */
    use SdkModel;

    /** @use SdkPage<TItem> */
    use SdkPage;

    /** @var list<TItem>|null $items */
    #[Optional(list: 'mixed')]
    public ?array $items;

    #[Optional]
    public ?string $nextCursor;

    /**
     * @internal
     *
     * @param array{
     *   method: string,
     *   path: string,
     *   query: array<string,mixed>,
     *   headers: array<string,string|list<string>|null>,
     *   body: mixed,
     * } $requestInfo
     */
    public function __construct(
        private string|Converter|ConverterSource $convert,
        private Client $client,
        private array $requestInfo,
        private RequestOptions $options,
        private ResponseInterface $response,
        private mixed $parsedBody,
    ) {
        $this->initialize();

        if (!is_array($this->parsedBody)) {
            return;
        }

        // @phpstan-ignore-next-line argument.type
        self::__unserialize($this->parsedBody);

        if (is_array($items = $this->offsetGet('items'))) {
            $parsed = Conversion::coerce(new ListOf($convert), value: $items);
            // @phpstan-ignore-next-line
            $this->offsetSet('items', value: $parsed);
        }
    }

    /** @return list<TItem> */
    public function getItems(): array
    {
        // @phpstan-ignore-next-line return.type
        return $this->offsetGet('items') ?? [];
    }

    /**
     * @internal
     *
     * @return array{
     *   array{
     *     method: string,
     *     path: string,
     *     query: array<string,mixed>,
     *     headers: array<string,string|list<string>|null>,
     *     body: mixed,
     *   },
     *   RequestOptions,
     * }|null
     */
    public function nextRequest(): ?array
    {
        if (!count($this->getItems())) {
            return null;
        }

        if (!($next = $this->nextCursor ?? null)) {
            return null;
        }

        $nextRequest = array_merge_recursive(
            $this->requestInfo,
            ['query' => ['cursor' => $next]]
        );

        // @phpstan-ignore-next-line return.type
        return [$nextRequest, $this->options];
    }
}
