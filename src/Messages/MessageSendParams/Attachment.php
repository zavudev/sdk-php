<?php

declare(strict_types=1);

namespace Zavudev\Messages\MessageSendParams;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Email attachment. Provide either `content` (base64) or `path` (URL), not both.
 *
 * @phpstan-type AttachmentShape = array{
 *   filename: string,
 *   content?: string|null,
 *   contentID?: string|null,
 *   contentType?: string|null,
 *   path?: string|null,
 * }
 */
final class Attachment implements BaseModel
{
    /** @use SdkModel<AttachmentShape> */
    use SdkModel;

    /**
     * Name of the attached file.
     */
    #[Required]
    public string $filename;

    /**
     * Content of the attached file as a Base64-encoded string.
     */
    #[Optional]
    public ?string $content;

    /**
     * Content ID for inline images. Reference in HTML as `<img src="cid:your_content_id">`.
     */
    #[Optional('content_id')]
    public ?string $contentID;

    /**
     * MIME type of the attachment. If not set, will be derived from the filename.
     */
    #[Optional('content_type')]
    public ?string $contentType;

    /**
     * URL where the attachment file is hosted. The server will fetch the file.
     */
    #[Optional]
    public ?string $path;

    /**
     * `new Attachment()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Attachment::with(filename: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Attachment)->withFilename(...)
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
        string $filename,
        ?string $content = null,
        ?string $contentID = null,
        ?string $contentType = null,
        ?string $path = null,
    ): self {
        $self = new self;

        $self['filename'] = $filename;

        null !== $content && $self['content'] = $content;
        null !== $contentID && $self['contentID'] = $contentID;
        null !== $contentType && $self['contentType'] = $contentType;
        null !== $path && $self['path'] = $path;

        return $self;
    }

    /**
     * Name of the attached file.
     */
    public function withFilename(string $filename): self
    {
        $self = clone $this;
        $self['filename'] = $filename;

        return $self;
    }

    /**
     * Content of the attached file as a Base64-encoded string.
     */
    public function withContent(string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * Content ID for inline images. Reference in HTML as `<img src="cid:your_content_id">`.
     */
    public function withContentID(string $contentID): self
    {
        $self = clone $this;
        $self['contentID'] = $contentID;

        return $self;
    }

    /**
     * MIME type of the attachment. If not set, will be derived from the filename.
     */
    public function withContentType(string $contentType): self
    {
        $self = clone $this;
        $self['contentType'] = $contentType;

        return $self;
    }

    /**
     * URL where the attachment file is hosted. The server will fetch the file.
     */
    public function withPath(string $path): self
    {
        $self = clone $this;
        $self['path'] = $path;

        return $self;
    }
}
