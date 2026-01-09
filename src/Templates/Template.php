<?php

declare(strict_types=1);

namespace Zavudev\Templates;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Templates\Template\Button;
use Zavudev\Templates\Template\Status;
use Zavudev\Templates\Template\Whatsapp;

/**
 * @phpstan-import-type ButtonShape from \Zavudev\Templates\Template\Button
 * @phpstan-import-type WhatsappShape from \Zavudev\Templates\Template\Whatsapp
 *
 * @phpstan-type TemplateShape = array{
 *   id: string,
 *   body: string,
 *   category: WhatsappCategory|value-of<WhatsappCategory>,
 *   language: string,
 *   name: string,
 *   addSecurityRecommendation?: bool|null,
 *   buttons?: list<Button|ButtonShape>|null,
 *   codeExpirationMinutes?: int|null,
 *   createdAt?: \DateTimeInterface|null,
 *   footer?: string|null,
 *   headerContent?: string|null,
 *   headerType?: string|null,
 *   status?: null|Status|value-of<Status>,
 *   updatedAt?: \DateTimeInterface|null,
 *   variables?: list<string>|null,
 *   whatsapp?: null|Whatsapp|WhatsappShape,
 * }
 */
final class Template implements BaseModel
{
    /** @use SdkModel<TemplateShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * Template body with variables: {{1}}, {{2}}, etc.
     */
    #[Required]
    public string $body;

    /**
     * WhatsApp template category.
     *
     * @var value-of<WhatsappCategory> $category
     */
    #[Required(enum: WhatsappCategory::class)]
    public string $category;

    /**
     * Language code.
     */
    #[Required]
    public string $language;

    /**
     * Template name (must match WhatsApp template name).
     */
    #[Required]
    public string $name;

    /**
     * Add 'Do not share this code' disclaimer. Only for AUTHENTICATION templates.
     */
    #[Optional]
    public ?bool $addSecurityRecommendation;

    /**
     * Template buttons.
     *
     * @var list<Button>|null $buttons
     */
    #[Optional(list: Button::class)]
    public ?array $buttons;

    /**
     * Code expiration time in minutes. Only for AUTHENTICATION templates.
     */
    #[Optional]
    public ?int $codeExpirationMinutes;

    #[Optional]
    public ?\DateTimeInterface $createdAt;

    /**
     * Footer text for the template.
     */
    #[Optional]
    public ?string $footer;

    /**
     * Header content (text or media URL).
     */
    #[Optional]
    public ?string $headerContent;

    /**
     * Type of header (text, image, video, document).
     */
    #[Optional]
    public ?string $headerType;

    /** @var value-of<Status>|null $status */
    #[Optional(enum: Status::class)]
    public ?string $status;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * List of variable names for documentation.
     *
     * @var list<string>|null $variables
     */
    #[Optional(list: 'string')]
    public ?array $variables;

    /**
     * WhatsApp-specific template information.
     */
    #[Optional]
    public ?Whatsapp $whatsapp;

    /**
     * `new Template()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Template::with(id: ..., body: ..., category: ..., language: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Template)
     *   ->withID(...)
     *   ->withBody(...)
     *   ->withCategory(...)
     *   ->withLanguage(...)
     *   ->withName(...)
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
     * @param WhatsappCategory|value-of<WhatsappCategory> $category
     * @param list<Button|ButtonShape>|null $buttons
     * @param Status|value-of<Status>|null $status
     * @param list<string>|null $variables
     * @param Whatsapp|WhatsappShape|null $whatsapp
     */
    public static function with(
        string $id,
        string $body,
        WhatsappCategory|string $category,
        string $language,
        string $name,
        ?bool $addSecurityRecommendation = null,
        ?array $buttons = null,
        ?int $codeExpirationMinutes = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $footer = null,
        ?string $headerContent = null,
        ?string $headerType = null,
        Status|string|null $status = null,
        ?\DateTimeInterface $updatedAt = null,
        ?array $variables = null,
        Whatsapp|array|null $whatsapp = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['body'] = $body;
        $self['category'] = $category;
        $self['language'] = $language;
        $self['name'] = $name;

        null !== $addSecurityRecommendation && $self['addSecurityRecommendation'] = $addSecurityRecommendation;
        null !== $buttons && $self['buttons'] = $buttons;
        null !== $codeExpirationMinutes && $self['codeExpirationMinutes'] = $codeExpirationMinutes;
        null !== $createdAt && $self['createdAt'] = $createdAt;
        null !== $footer && $self['footer'] = $footer;
        null !== $headerContent && $self['headerContent'] = $headerContent;
        null !== $headerType && $self['headerType'] = $headerType;
        null !== $status && $self['status'] = $status;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;
        null !== $variables && $self['variables'] = $variables;
        null !== $whatsapp && $self['whatsapp'] = $whatsapp;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Template body with variables: {{1}}, {{2}}, etc.
     */
    public function withBody(string $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    /**
     * WhatsApp template category.
     *
     * @param WhatsappCategory|value-of<WhatsappCategory> $category
     */
    public function withCategory(WhatsappCategory|string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }

    /**
     * Language code.
     */
    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * Template name (must match WhatsApp template name).
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Add 'Do not share this code' disclaimer. Only for AUTHENTICATION templates.
     */
    public function withAddSecurityRecommendation(
        bool $addSecurityRecommendation
    ): self {
        $self = clone $this;
        $self['addSecurityRecommendation'] = $addSecurityRecommendation;

        return $self;
    }

    /**
     * Template buttons.
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
     * Code expiration time in minutes. Only for AUTHENTICATION templates.
     */
    public function withCodeExpirationMinutes(int $codeExpirationMinutes): self
    {
        $self = clone $this;
        $self['codeExpirationMinutes'] = $codeExpirationMinutes;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Footer text for the template.
     */
    public function withFooter(string $footer): self
    {
        $self = clone $this;
        $self['footer'] = $footer;

        return $self;
    }

    /**
     * Header content (text or media URL).
     */
    public function withHeaderContent(string $headerContent): self
    {
        $self = clone $this;
        $self['headerContent'] = $headerContent;

        return $self;
    }

    /**
     * Type of header (text, image, video, document).
     */
    public function withHeaderType(string $headerType): self
    {
        $self = clone $this;
        $self['headerType'] = $headerType;

        return $self;
    }

    /**
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * List of variable names for documentation.
     *
     * @param list<string> $variables
     */
    public function withVariables(array $variables): self
    {
        $self = clone $this;
        $self['variables'] = $variables;

        return $self;
    }

    /**
     * WhatsApp-specific template information.
     *
     * @param Whatsapp|WhatsappShape $whatsapp
     */
    public function withWhatsapp(Whatsapp|array $whatsapp): self
    {
        $self = clone $this;
        $self['whatsapp'] = $whatsapp;

        return $self;
    }
}
