<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Content for non-text broadcast message types.
 *
 * @phpstan-type BroadcastContentShape = array{
 *   filename?: string|null,
 *   mediaID?: string|null,
 *   mediaURL?: string|null,
 *   mimeType?: string|null,
 *   templateButtonVariables?: array<string,string>|null,
 *   templateID?: string|null,
 *   templateVariables?: array<string,string>|null,
 * }
 */
final class BroadcastContent implements BaseModel
{
    /** @use SdkModel<BroadcastContentShape> */
    use SdkModel;

    /**
     * Filename for documents.
     */
    #[Optional]
    public ?string $filename;

    /**
     * Media ID if already uploaded.
     */
    #[Optional('mediaId')]
    public ?string $mediaID;

    /**
     * URL of the media file.
     */
    #[Optional('mediaUrl')]
    public ?string $mediaURL;

    /**
     * MIME type of the media.
     */
    #[Optional]
    public ?string $mimeType;

    /**
     * Default button variables for dynamic URL/OTP buttons. Keys are the button index (0, 1, 2). Per-contact values override these.
     *
     * @var array<string,string>|null $templateButtonVariables
     */
    #[Optional(map: 'string')]
    public ?array $templateButtonVariables;

    /**
     * Template ID for template messages.
     */
    #[Optional('templateId')]
    public ?string $templateID;

    /**
     * Default body variables (can be overridden per contact). Keys are positions (1, 2, ...).
     *
     * @var array<string,string>|null $templateVariables
     */
    #[Optional(map: 'string')]
    public ?array $templateVariables;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,string>|null $templateButtonVariables
     * @param array<string,string>|null $templateVariables
     */
    public static function with(
        ?string $filename = null,
        ?string $mediaID = null,
        ?string $mediaURL = null,
        ?string $mimeType = null,
        ?array $templateButtonVariables = null,
        ?string $templateID = null,
        ?array $templateVariables = null,
    ): self {
        $self = new self;

        null !== $filename && $self['filename'] = $filename;
        null !== $mediaID && $self['mediaID'] = $mediaID;
        null !== $mediaURL && $self['mediaURL'] = $mediaURL;
        null !== $mimeType && $self['mimeType'] = $mimeType;
        null !== $templateButtonVariables && $self['templateButtonVariables'] = $templateButtonVariables;
        null !== $templateID && $self['templateID'] = $templateID;
        null !== $templateVariables && $self['templateVariables'] = $templateVariables;

        return $self;
    }

    /**
     * Filename for documents.
     */
    public function withFilename(string $filename): self
    {
        $self = clone $this;
        $self['filename'] = $filename;

        return $self;
    }

    /**
     * Media ID if already uploaded.
     */
    public function withMediaID(string $mediaID): self
    {
        $self = clone $this;
        $self['mediaID'] = $mediaID;

        return $self;
    }

    /**
     * URL of the media file.
     */
    public function withMediaURL(string $mediaURL): self
    {
        $self = clone $this;
        $self['mediaURL'] = $mediaURL;

        return $self;
    }

    /**
     * MIME type of the media.
     */
    public function withMimeType(string $mimeType): self
    {
        $self = clone $this;
        $self['mimeType'] = $mimeType;

        return $self;
    }

    /**
     * Default button variables for dynamic URL/OTP buttons. Keys are the button index (0, 1, 2). Per-contact values override these.
     *
     * @param array<string,string> $templateButtonVariables
     */
    public function withTemplateButtonVariables(
        array $templateButtonVariables
    ): self {
        $self = clone $this;
        $self['templateButtonVariables'] = $templateButtonVariables;

        return $self;
    }

    /**
     * Template ID for template messages.
     */
    public function withTemplateID(string $templateID): self
    {
        $self = clone $this;
        $self['templateID'] = $templateID;

        return $self;
    }

    /**
     * Default body variables (can be overridden per contact). Keys are positions (1, 2, ...).
     *
     * @param array<string,string> $templateVariables
     */
    public function withTemplateVariables(array $templateVariables): self
    {
        $self = clone $this;
        $self['templateVariables'] = $templateVariables;

        return $self;
    }
}
