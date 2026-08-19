<?php

declare(strict_types=1);

namespace Zavudev\Messages\MessageListAttachmentsResponse;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * A stored file attachment for an email message (inbound or outbound).
 *
 * @phpstan-type ItemShape = array{
 *   id: string,
 *   contentID: string|null,
 *   createdAt: \DateTimeInterface,
 *   downloadURL: string|null,
 *   filename: string,
 *   isInline: bool,
 *   mimeType: string,
 *   size: int,
 * }
 */
final class Item implements BaseModel
{
    /** @use SdkModel<ItemShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * Content-ID for inline attachments (referenced in the HTML body as `cid:<contentId>`). Null for regular attachments.
     */
    #[Required('contentId')]
    public ?string $contentID;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * Short-lived signed URL to download the attachment bytes. Freshly generated on each request and expires; do not cache it. Null if the stored file is no longer available.
     */
    #[Required('downloadUrl')]
    public ?string $downloadURL;

    #[Required]
    public string $filename;

    /**
     * Whether the attachment is inline (embedded in the HTML body) rather than a regular attachment.
     */
    #[Required]
    public bool $isInline;

    /**
     * MIME type of the attachment.
     */
    #[Required]
    public string $mimeType;

    /**
     * Size of the attachment in bytes.
     */
    #[Required]
    public int $size;

    /**
     * `new Item()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Item::with(
     *   id: ...,
     *   contentID: ...,
     *   createdAt: ...,
     *   downloadURL: ...,
     *   filename: ...,
     *   isInline: ...,
     *   mimeType: ...,
     *   size: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Item)
     *   ->withID(...)
     *   ->withContentID(...)
     *   ->withCreatedAt(...)
     *   ->withDownloadURL(...)
     *   ->withFilename(...)
     *   ->withIsInline(...)
     *   ->withMimeType(...)
     *   ->withSize(...)
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
        ?string $contentID,
        \DateTimeInterface $createdAt,
        ?string $downloadURL,
        string $filename,
        bool $isInline,
        string $mimeType,
        int $size,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['contentID'] = $contentID;
        $self['createdAt'] = $createdAt;
        $self['downloadURL'] = $downloadURL;
        $self['filename'] = $filename;
        $self['isInline'] = $isInline;
        $self['mimeType'] = $mimeType;
        $self['size'] = $size;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Content-ID for inline attachments (referenced in the HTML body as `cid:<contentId>`). Null for regular attachments.
     */
    public function withContentID(?string $contentID): self
    {
        $self = clone $this;
        $self['contentID'] = $contentID;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Short-lived signed URL to download the attachment bytes. Freshly generated on each request and expires; do not cache it. Null if the stored file is no longer available.
     */
    public function withDownloadURL(?string $downloadURL): self
    {
        $self = clone $this;
        $self['downloadURL'] = $downloadURL;

        return $self;
    }

    public function withFilename(string $filename): self
    {
        $self = clone $this;
        $self['filename'] = $filename;

        return $self;
    }

    /**
     * Whether the attachment is inline (embedded in the HTML body) rather than a regular attachment.
     */
    public function withIsInline(bool $isInline): self
    {
        $self = clone $this;
        $self['isInline'] = $isInline;

        return $self;
    }

    /**
     * MIME type of the attachment.
     */
    public function withMimeType(string $mimeType): self
    {
        $self = clone $this;
        $self['mimeType'] = $mimeType;

        return $self;
    }

    /**
     * Size of the attachment in bytes.
     */
    public function withSize(int $size): self
    {
        $self = clone $this;
        $self['size'] = $size;

        return $self;
    }
}
