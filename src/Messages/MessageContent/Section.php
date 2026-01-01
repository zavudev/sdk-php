<?php

declare(strict_types=1);

namespace Zavudev\Messages\MessageContent;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Messages\MessageContent\Section\Row;

/**
 * @phpstan-import-type RowShape from \Zavudev\Messages\MessageContent\Section\Row
 *
 * @phpstan-type SectionShape = array{rows: list<RowShape>, title: string}
 */
final class Section implements BaseModel
{
    /** @use SdkModel<SectionShape> */
    use SdkModel;

    /** @var list<Row> $rows */
    #[Required(list: Row::class)]
    public array $rows;

    #[Required]
    public string $title;

    /**
     * `new Section()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Section::with(rows: ..., title: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Section)->withRows(...)->withTitle(...)
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
     * @param list<RowShape> $rows
     */
    public static function with(array $rows, string $title): self
    {
        $self = new self;

        $self['rows'] = $rows;
        $self['title'] = $title;

        return $self;
    }

    /**
     * @param list<RowShape> $rows
     */
    public function withRows(array $rows): self
    {
        $self = clone $this;
        $self['rows'] = $rows;

        return $self;
    }

    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }
}
