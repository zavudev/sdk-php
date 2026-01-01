<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Update a broadcast in draft status.
 *
 * @see Zavudev\Services\BroadcastsService::update()
 *
 * @phpstan-import-type BroadcastContentShape from \Zavudev\Broadcasts\BroadcastContent
 *
 * @phpstan-type BroadcastUpdateParamsShape = array{
 *   content?: null|BroadcastContent|BroadcastContentShape,
 *   emailHTMLBody?: string|null,
 *   emailSubject?: string|null,
 *   metadata?: array<string,string>|null,
 *   name?: string|null,
 *   text?: string|null,
 * }
 */
final class BroadcastUpdateParams implements BaseModel
{
    /** @use SdkModel<BroadcastUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Content for non-text broadcast message types.
     */
    #[Optional]
    public ?BroadcastContent $content;

    #[Optional('emailHtmlBody')]
    public ?string $emailHTMLBody;

    #[Optional]
    public ?string $emailSubject;

    /** @var array<string,string>|null $metadata */
    #[Optional(map: 'string')]
    public ?array $metadata;

    #[Optional]
    public ?string $name;

    #[Optional]
    public ?string $text;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BroadcastContent|BroadcastContentShape|null $content
     * @param array<string,string>|null $metadata
     */
    public static function with(
        BroadcastContent|array|null $content = null,
        ?string $emailHTMLBody = null,
        ?string $emailSubject = null,
        ?array $metadata = null,
        ?string $name = null,
        ?string $text = null,
    ): self {
        $self = new self;

        null !== $content && $self['content'] = $content;
        null !== $emailHTMLBody && $self['emailHTMLBody'] = $emailHTMLBody;
        null !== $emailSubject && $self['emailSubject'] = $emailSubject;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $name && $self['name'] = $name;
        null !== $text && $self['text'] = $text;

        return $self;
    }

    /**
     * Content for non-text broadcast message types.
     *
     * @param BroadcastContent|BroadcastContentShape $content
     */
    public function withContent(BroadcastContent|array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    public function withEmailHTMLBody(string $emailHTMLBody): self
    {
        $self = clone $this;
        $self['emailHTMLBody'] = $emailHTMLBody;

        return $self;
    }

    public function withEmailSubject(string $emailSubject): self
    {
        $self = clone $this;
        $self['emailSubject'] = $emailSubject;

        return $self;
    }

    /**
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
