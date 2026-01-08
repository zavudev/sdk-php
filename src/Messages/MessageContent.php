<?php

declare(strict_types=1);

namespace Zavudev\Messages;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Messages\MessageContent\Button;
use Zavudev\Messages\MessageContent\Contact;
use Zavudev\Messages\MessageContent\Section;

/**
 * Content for non-text message types (WhatsApp only).
 *
 * @phpstan-import-type ButtonShape from \Zavudev\Messages\MessageContent\Button
 * @phpstan-import-type ContactShape from \Zavudev\Messages\MessageContent\Contact
 * @phpstan-import-type SectionShape from \Zavudev\Messages\MessageContent\Section
 *
 * @phpstan-type MessageContentShape = array{
 *   buttons?: list<Button|ButtonShape>|null,
 *   contacts?: list<Contact|ContactShape>|null,
 *   emoji?: string|null,
 *   filename?: string|null,
 *   latitude?: float|null,
 *   listButton?: string|null,
 *   locationAddress?: string|null,
 *   locationName?: string|null,
 *   longitude?: float|null,
 *   mediaID?: string|null,
 *   mediaURL?: string|null,
 *   mimeType?: string|null,
 *   reactToMessageID?: string|null,
 *   sections?: list<Section|SectionShape>|null,
 *   templateID?: string|null,
 *   templateVariables?: array<string,string>|null,
 * }
 */
final class MessageContent implements BaseModel
{
    /** @use SdkModel<MessageContentShape> */
    use SdkModel;

    /**
     * Interactive buttons (max 3).
     *
     * @var list<Button>|null $buttons
     */
    #[Optional(list: Button::class)]
    public ?array $buttons;

    /**
     * Contact cards for contact messages.
     *
     * @var list<Contact>|null $contacts
     */
    #[Optional(list: Contact::class)]
    public ?array $contacts;

    /**
     * Emoji for reaction messages.
     */
    #[Optional]
    public ?string $emoji;

    /**
     * Filename for documents.
     */
    #[Optional]
    public ?string $filename;

    /**
     * Latitude for location messages.
     */
    #[Optional]
    public ?float $latitude;

    /**
     * Button text for list messages.
     */
    #[Optional]
    public ?string $listButton;

    /**
     * Address of the location.
     */
    #[Optional]
    public ?string $locationAddress;

    /**
     * Name of the location.
     */
    #[Optional]
    public ?string $locationName;

    /**
     * Longitude for location messages.
     */
    #[Optional]
    public ?float $longitude;

    /**
     * WhatsApp media ID if already uploaded.
     */
    #[Optional('mediaId')]
    public ?string $mediaID;

    /**
     * URL of the media file (for image, video, audio, document, sticker).
     */
    #[Optional('mediaUrl')]
    public ?string $mediaURL;

    /**
     * MIME type of the media.
     */
    #[Optional]
    public ?string $mimeType;

    /**
     * Message ID to react to.
     */
    #[Optional('reactToMessageId')]
    public ?string $reactToMessageID;

    /**
     * Sections for list messages.
     *
     * @var list<Section>|null $sections
     */
    #[Optional(list: Section::class)]
    public ?array $sections;

    /**
     * Template ID for template messages.
     */
    #[Optional('templateId')]
    public ?string $templateID;

    /**
     * Variables for template rendering. Keys are variable positions (1, 2, 3...).
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
     * @param list<Button|ButtonShape>|null $buttons
     * @param list<Contact|ContactShape>|null $contacts
     * @param list<Section|SectionShape>|null $sections
     * @param array<string,string>|null $templateVariables
     */
    public static function with(
        ?array $buttons = null,
        ?array $contacts = null,
        ?string $emoji = null,
        ?string $filename = null,
        ?float $latitude = null,
        ?string $listButton = null,
        ?string $locationAddress = null,
        ?string $locationName = null,
        ?float $longitude = null,
        ?string $mediaID = null,
        ?string $mediaURL = null,
        ?string $mimeType = null,
        ?string $reactToMessageID = null,
        ?array $sections = null,
        ?string $templateID = null,
        ?array $templateVariables = null,
    ): self {
        $self = new self;

        null !== $buttons && $self['buttons'] = $buttons;
        null !== $contacts && $self['contacts'] = $contacts;
        null !== $emoji && $self['emoji'] = $emoji;
        null !== $filename && $self['filename'] = $filename;
        null !== $latitude && $self['latitude'] = $latitude;
        null !== $listButton && $self['listButton'] = $listButton;
        null !== $locationAddress && $self['locationAddress'] = $locationAddress;
        null !== $locationName && $self['locationName'] = $locationName;
        null !== $longitude && $self['longitude'] = $longitude;
        null !== $mediaID && $self['mediaID'] = $mediaID;
        null !== $mediaURL && $self['mediaURL'] = $mediaURL;
        null !== $mimeType && $self['mimeType'] = $mimeType;
        null !== $reactToMessageID && $self['reactToMessageID'] = $reactToMessageID;
        null !== $sections && $self['sections'] = $sections;
        null !== $templateID && $self['templateID'] = $templateID;
        null !== $templateVariables && $self['templateVariables'] = $templateVariables;

        return $self;
    }

    /**
     * Interactive buttons (max 3).
     *
     * @param list<Button|ButtonShape> $buttons
     */
    public function withButtons(array $buttons): self
    {
        $self = clone $this;
        $self['buttons'] = $buttons;

        return $self;
    }

    /**
     * Contact cards for contact messages.
     *
     * @param list<Contact|ContactShape> $contacts
     */
    public function withContacts(array $contacts): self
    {
        $self = clone $this;
        $self['contacts'] = $contacts;

        return $self;
    }

    /**
     * Emoji for reaction messages.
     */
    public function withEmoji(string $emoji): self
    {
        $self = clone $this;
        $self['emoji'] = $emoji;

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
     * Latitude for location messages.
     */
    public function withLatitude(float $latitude): self
    {
        $self = clone $this;
        $self['latitude'] = $latitude;

        return $self;
    }

    /**
     * Button text for list messages.
     */
    public function withListButton(string $listButton): self
    {
        $self = clone $this;
        $self['listButton'] = $listButton;

        return $self;
    }

    /**
     * Address of the location.
     */
    public function withLocationAddress(string $locationAddress): self
    {
        $self = clone $this;
        $self['locationAddress'] = $locationAddress;

        return $self;
    }

    /**
     * Name of the location.
     */
    public function withLocationName(string $locationName): self
    {
        $self = clone $this;
        $self['locationName'] = $locationName;

        return $self;
    }

    /**
     * Longitude for location messages.
     */
    public function withLongitude(float $longitude): self
    {
        $self = clone $this;
        $self['longitude'] = $longitude;

        return $self;
    }

    /**
     * WhatsApp media ID if already uploaded.
     */
    public function withMediaID(string $mediaID): self
    {
        $self = clone $this;
        $self['mediaID'] = $mediaID;

        return $self;
    }

    /**
     * URL of the media file (for image, video, audio, document, sticker).
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
     * Message ID to react to.
     */
    public function withReactToMessageID(string $reactToMessageID): self
    {
        $self = clone $this;
        $self['reactToMessageID'] = $reactToMessageID;

        return $self;
    }

    /**
     * Sections for list messages.
     *
     * @param list<Section|SectionShape> $sections
     */
    public function withSections(array $sections): self
    {
        $self = clone $this;
        $self['sections'] = $sections;

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
     * Variables for template rendering. Keys are variable positions (1, 2, 3...).
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
