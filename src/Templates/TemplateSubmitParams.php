<?php

declare(strict_types=1);

namespace Zavudev\Templates;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Submit a WhatsApp template to Meta for approval. The template must be in draft status and associated with a sender that has a WhatsApp Business Account configured.
 *
 * @see Zavudev\Services\TemplatesService::submit()
 *
 * @phpstan-type TemplateSubmitParamsShape = array{
 *   senderID: string, category?: null|WhatsappCategory|value-of<WhatsappCategory>
 * }
 */
final class TemplateSubmitParams implements BaseModel
{
    /** @use SdkModel<TemplateSubmitParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The sender ID with the WhatsApp Business Account to submit the template to.
     */
    #[Required('senderId')]
    public string $senderID;

    /**
     * Template category. If not provided, uses the category set on the template.
     *
     * @var value-of<WhatsappCategory>|null $category
     */
    #[Optional(enum: WhatsappCategory::class)]
    public ?string $category;

    /**
     * `new TemplateSubmitParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TemplateSubmitParams::with(senderID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TemplateSubmitParams)->withSenderID(...)
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
     * @param WhatsappCategory|value-of<WhatsappCategory>|null $category
     */
    public static function with(
        string $senderID,
        WhatsappCategory|string|null $category = null
    ): self {
        $self = new self;

        $self['senderID'] = $senderID;

        null !== $category && $self['category'] = $category;

        return $self;
    }

    /**
     * The sender ID with the WhatsApp Business Account to submit the template to.
     */
    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }

    /**
     * Template category. If not provided, uses the category set on the template.
     *
     * @param WhatsappCategory|value-of<WhatsappCategory> $category
     */
    public function withCategory(WhatsappCategory|string $category): self
    {
        $self = clone $this;
        $self['category'] = $category;

        return $self;
    }
}
