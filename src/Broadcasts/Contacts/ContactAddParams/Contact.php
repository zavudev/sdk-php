<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts\Contacts\ContactAddParams;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type ContactShape = array{
 *   recipient: string,
 *   templateButtonVariables?: array<string,string>|null,
 *   templateVariables?: array<string,string>|null,
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
     * Per-contact button variables for dynamic URL/OTP buttons. Keys are the button index (0, 1, 2).
     *
     * @var array<string,string>|null $templateButtonVariables
     */
    #[Optional(map: 'string')]
    public ?array $templateButtonVariables;

    /**
     * Per-contact body variables. Keys are positions (1, 2, ...) matching the order placeholders appear in the template body.
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
     * @param array<string,string>|null $templateButtonVariables
     * @param array<string,string>|null $templateVariables
     */
    public static function with(
        string $recipient,
        ?array $templateButtonVariables = null,
        ?array $templateVariables = null,
    ): self {
        $self = new self;

        $self['recipient'] = $recipient;

        null !== $templateButtonVariables && $self['templateButtonVariables'] = $templateButtonVariables;
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
     * Per-contact button variables for dynamic URL/OTP buttons. Keys are the button index (0, 1, 2).
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
     * Per-contact body variables. Keys are positions (1, 2, ...) matching the order placeholders appear in the template body.
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
