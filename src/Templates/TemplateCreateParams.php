<?php

declare(strict_types=1);

namespace Zavudev\Templates;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Templates\TemplateCreateParams\Button;

/**
 * Create a WhatsApp message template. Note: Templates must be approved by Meta before use.
 *
 * @see Zavudev\Services\TemplatesService::create()
 *
 * @phpstan-import-type ButtonShape from \Zavudev\Templates\TemplateCreateParams\Button
 *
 * @phpstan-type TemplateCreateParamsShape = array{
 *   body: string,
 *   language: string,
 *   name: string,
 *   addSecurityRecommendation?: bool|null,
 *   buttons?: list<Button|ButtonShape>|null,
 *   codeExpirationMinutes?: int|null,
 *   variables?: list<string>|null,
 *   whatsappCategory?: null|WhatsappCategory|value-of<WhatsappCategory>,
 * }
 */
final class TemplateCreateParams implements BaseModel
{
    /** @use SdkModel<TemplateCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $body;

    #[Required]
    public string $language;

    #[Required]
    public string $name;

    /**
     * Add 'Do not share this code' disclaimer. Only for AUTHENTICATION templates.
     */
    #[Optional]
    public ?bool $addSecurityRecommendation;

    /**
     * Template buttons (max 3).
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

    /** @var list<string>|null $variables */
    #[Optional(list: 'string')]
    public ?array $variables;

    /**
     * WhatsApp template category.
     *
     * @var value-of<WhatsappCategory>|null $whatsappCategory
     */
    #[Optional(enum: WhatsappCategory::class)]
    public ?string $whatsappCategory;

    /**
     * `new TemplateCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TemplateCreateParams::with(body: ..., language: ..., name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TemplateCreateParams)->withBody(...)->withLanguage(...)->withName(...)
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
     * @param list<Button|ButtonShape>|null $buttons
     * @param list<string>|null $variables
     * @param WhatsappCategory|value-of<WhatsappCategory>|null $whatsappCategory
     */
    public static function with(
        string $body,
        string $name,
        string $language = 'en',
        ?bool $addSecurityRecommendation = null,
        ?array $buttons = null,
        ?int $codeExpirationMinutes = null,
        ?array $variables = null,
        WhatsappCategory|string|null $whatsappCategory = null,
    ): self {
        $self = new self;

        $self['body'] = $body;
        $self['language'] = $language;
        $self['name'] = $name;

        null !== $addSecurityRecommendation && $self['addSecurityRecommendation'] = $addSecurityRecommendation;
        null !== $buttons && $self['buttons'] = $buttons;
        null !== $codeExpirationMinutes && $self['codeExpirationMinutes'] = $codeExpirationMinutes;
        null !== $variables && $self['variables'] = $variables;
        null !== $whatsappCategory && $self['whatsappCategory'] = $whatsappCategory;

        return $self;
    }

    public function withBody(string $body): self
    {
        $self = clone $this;
        $self['body'] = $body;

        return $self;
    }

    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

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
     * Template buttons (max 3).
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

    /**
     * @param list<string> $variables
     */
    public function withVariables(array $variables): self
    {
        $self = clone $this;
        $self['variables'] = $variables;

        return $self;
    }

    /**
     * WhatsApp template category.
     *
     * @param WhatsappCategory|value-of<WhatsappCategory> $whatsappCategory
     */
    public function withWhatsappCategory(
        WhatsappCategory|string $whatsappCategory
    ): self {
        $self = clone $this;
        $self['whatsappCategory'] = $whatsappCategory;

        return $self;
    }
}
