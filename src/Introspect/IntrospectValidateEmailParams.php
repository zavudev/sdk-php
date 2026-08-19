<?php

declare(strict_types=1);

namespace Zavudev\Introspect;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Heuristic email validation to run before sending: catches invalid syntax, dead domains (no MX/A records), disposable inboxes, role-based addresses (info@, contacto@, sales@), and addresses already on your project's suppression list. Use it to clean a list before a broadcast and keep your bounce rate low.
 *
 * No mailbox-level (SMTP) probe is performed, so a `deliverable` verdict is not a delivery guarantee — it means no negative signal was found. Treat `risky` addresses with care and drop `undeliverable` ones.
 *
 * Accepts a single `email` or an `emails` batch (max 100 per request).
 *
 * @see Zavudev\Services\IntrospectService::validateEmail()
 *
 * @phpstan-type IntrospectValidateEmailParamsShape = array{
 *   email?: string|null, emails?: list<string>|null
 * }
 */
final class IntrospectValidateEmailParams implements BaseModel
{
    /** @use SdkModel<IntrospectValidateEmailParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Single email address to validate.
     */
    #[Optional]
    public ?string $email;

    /**
     * Batch of email addresses to validate (max 100).
     *
     * @var list<string>|null $emails
     */
    #[Optional(list: 'string')]
    public ?array $emails;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $emails
     */
    public static function with(
        ?string $email = null,
        ?array $emails = null
    ): self {
        $self = new self;

        null !== $email && $self['email'] = $email;
        null !== $emails && $self['emails'] = $emails;

        return $self;
    }

    /**
     * Single email address to validate.
     */
    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * Batch of email addresses to validate (max 100).
     *
     * @param list<string> $emails
     */
    public function withEmails(array $emails): self
    {
        $self = clone $this;
        $self['emails'] = $emails;

        return $self;
    }
}
