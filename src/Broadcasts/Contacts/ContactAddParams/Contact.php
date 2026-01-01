<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts\Contacts\ContactAddParams;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type ContactShape = array{
 *   recipient: string, templateVariables?: array<string,string>|null
 * }
 */
final class Contact implements BaseModel
{
    /** @use SdkModel<ContactShape> */
    use SdkModel;

    /**
     * Phone number (E.164) or email address.
     */
    #[Required]
    public string $recipient;

    /**
     * Per-contact template variables to personalize the message.
     *
     * @var array<string,string>|null $templateVariables
     */
    #[Optional(map: 'string')]
    public ?array $templateVariables;

    /**
     * `new Contact()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Contact::with(recipient: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Contact)->withRecipient(...)
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
     * @param array<string,string>|null $templateVariables
     */
    public static function with(
        string $recipient,
        ?array $templateVariables = null
    ): self {
        $self = new self;

        $self['recipient'] = $recipient;

        null !== $templateVariables && $self['templateVariables'] = $templateVariables;

        return $self;
    }

    /**
     * Phone number (E.164) or email address.
     */
    public function withRecipient(string $recipient): self
    {
        $self = clone $this;
        $self['recipient'] = $recipient;

        return $self;
    }

    /**
     * Per-contact template variables to personalize the message.
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
