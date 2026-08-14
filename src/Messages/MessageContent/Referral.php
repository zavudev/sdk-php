<?php

declare(strict_types=1);

namespace Zavudev\Messages\MessageContent;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Messages\MessageContent\Referral\MediaType;
use Zavudev\Messages\MessageContent\Referral\SourceType;

/**
 * Click-to-WhatsApp (CTWA) ad attribution: where an inbound conversation came from.
 *
 * WhatsApp only. Present on the **first inbound message** of a conversation opened from a Meta ad or post, and on no message after it — so store it when it arrives rather than expecting it again. Organic conversations never carry it.
 *
 * Field names are camelCased to match the rest of this API; Meta sends them as snake_case (`ctwa_clid`, `source_id`, ...). Fields that do not apply are omitted: a `post` source has no click id, and an image ad has no `videoUrl`.
 *
 * @phpstan-type ReferralShape = array{
 *   body?: string|null,
 *   ctwaClid?: string|null,
 *   headline?: string|null,
 *   imageURL?: string|null,
 *   mediaType?: null|MediaType|value-of<MediaType>,
 *   sourceID?: string|null,
 *   sourceType?: null|SourceType|value-of<SourceType>,
 *   sourceURL?: string|null,
 *   thumbnailURL?: string|null,
 *   videoURL?: string|null,
 * }
 */
final class Referral implements BaseModel
{
    /** @use SdkModel<ReferralShape> */
    use SdkModel;

    /**
     * Body copy of the ad or post.
     */
    #[Optional]
    public ?string $body;

    /**
     * Click-to-WhatsApp click identifier. This is the value Meta's Conversions API needs to credit a conversion back to the ad that produced the conversation. Present on `ad` sources; a `post` source has none.
     */
    #[Optional]
    public ?string $ctwaClid;

    /**
     * Headline of the ad or post.
     */
    #[Optional]
    public ?string $headline;

    /**
     * Image of the ad. Present when `mediaType` is `image`.
     */
    #[Optional('imageUrl')]
    public ?string $imageURL;

    /**
     * Type of media on the ad, when it had any.
     *
     * @var value-of<MediaType>|null $mediaType
     */
    #[Optional(enum: MediaType::class)]
    public ?string $mediaType;

    /**
     * Identifier of the ad or post that produced the click.
     */
    #[Optional('sourceId')]
    public ?string $sourceID;

    /**
     * Where the click came from.
     *
     * @var value-of<SourceType>|null $sourceType
     */
    #[Optional(enum: SourceType::class)]
    public ?string $sourceType;

    /**
     * Meta permalink to the ad or post.
     */
    #[Optional('sourceUrl')]
    public ?string $sourceURL;

    /**
     * Thumbnail of the ad media.
     */
    #[Optional('thumbnailUrl')]
    public ?string $thumbnailURL;

    /**
     * Video of the ad. Present when `mediaType` is `video`.
     */
    #[Optional('videoUrl')]
    public ?string $videoURL;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param MediaType|value-of<MediaType>|null $mediaType
     * @param SourceType|value-of<SourceType>|null $sourceType
     */
    public static function with(
        ?string $body = null,
        ?string $ctwaClid = null,
        ?string $headline = null,
        ?string $imageURL = null,
        MediaType|string|null $mediaType = null,
        ?string $sourceID = null,
        SourceType|string|null $sourceType = null,
        ?string $sourceURL = null,
        ?string $thumbnailURL = null,
        ?string $videoURL = null,
    ): self {
        $self = new self;

        null !== $body && $self['body'] = $body;
        null !== $ctwaClid && $self['ctwaClid'] = $ctwaClid;
        null !== $headline && $self['headline'] = $headline;
        null !== $imageURL && $self['imageURL'] = $imageURL;
        null !== $mediaType && $self['mediaType'] = $mediaType;
        null !== $sourceID && $self['sourceID'] = $sourceID;
        null !== $sourceType && $self['sourceType'] = $sourceType;
        null !== $sourceURL && $self['sourceURL'] = $sourceURL;
        null !== $thumbnailURL && $self['thumbnailURL'] = $thumbnailURL;
        null !== $videoURL && $self['videoURL'] = $videoURL;

        return $self;
    }

    /**
     * Body copy of the ad or post.
     */
    public function withBody(string $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    /**
     * Click-to-WhatsApp click identifier. This is the value Meta's Conversions API needs to credit a conversion back to the ad that produced the conversation. Present on `ad` sources; a `post` source has none.
     */
    public function withCtwaClid(string $ctwaClid): self
    {
        $self = clone $this;
        $self['ctwaClid'] = $ctwaClid;

        return $self;
    }

    /**
     * Headline of the ad or post.
     */
    public function withHeadline(string $headline): self
    {
        $self = clone $this;
        $self['headline'] = $headline;

        return $self;
    }

    /**
     * Image of the ad. Present when `mediaType` is `image`.
     */
    public function withImageURL(string $imageURL): self
    {
        $self = clone $this;
        $self['imageURL'] = $imageURL;

        return $self;
    }

    /**
     * Type of media on the ad, when it had any.
     *
     * @param MediaType|value-of<MediaType> $mediaType
     */
    public function withMediaType(MediaType|string $mediaType): self
    {
        $self = clone $this;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    /**
     * Identifier of the ad or post that produced the click.
     */
    public function withSourceID(string $sourceID): self
    {
        $self = clone $this;
        $self['sourceID'] = $sourceID;

        return $self;
    }

    /**
     * Where the click came from.
     *
     * @param SourceType|value-of<SourceType> $sourceType
     */
    public function withSourceType(SourceType|string $sourceType): self
    {
        $self = clone $this;
        $self['sourceType'] = $sourceType;

        return $self;
    }

    /**
     * Meta permalink to the ad or post.
     */
    public function withSourceURL(string $sourceURL): self
    {
        $self = clone $this;
        $self['sourceURL'] = $sourceURL;

        return $self;
    }

    /**
     * Thumbnail of the ad media.
     */
    public function withThumbnailURL(string $thumbnailURL): self
    {
        $self = clone $this;
        $self['thumbnailURL'] = $thumbnailURL;

        return $self;
    }

    /**
     * Video of the ad. Present when `mediaType` is `video`.
     */
    public function withVideoURL(string $videoURL): self
    {
        $self = clone $this;
        $self['videoURL'] = $videoURL;

        return $self;
    }
}
