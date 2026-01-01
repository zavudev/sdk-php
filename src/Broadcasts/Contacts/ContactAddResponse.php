<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts\Contacts;

use Zavudev\Broadcasts\Contacts\ContactAddResponse\Error;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ErrorShape from \Zavudev\Broadcasts\Contacts\ContactAddResponse\Error
 *
 * @phpstan-type ContactAddResponseShape = array{
 *   added: int, duplicates: int, invalid: int, errors?: list<ErrorShape>|null
 * }
 */
final class ContactAddResponse implements BaseModel
{
    /** @use SdkModel<ContactAddResponseShape> */
    use SdkModel;

    /**
     * Number of contacts successfully added.
     */
    #[Required]
    public int $added;

    /**
     * Number of duplicate contacts skipped.
     */
    #[Required]
    public int $duplicates;

    /**
     * Number of invalid contacts rejected.
     */
    #[Required]
    public int $invalid;

    /**
     * Details about invalid contacts.
     *
     * @var list<Error>|null $errors
     */
    #[Optional(list: Error::class)]
    public ?array $errors;

    /**
     * `new ContactAddResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ContactAddResponse::with(added: ..., duplicates: ..., invalid: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ContactAddResponse)->withAdded(...)->withDuplicates(...)->withInvalid(...)
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
     * @param list<ErrorShape>|null $errors
     */
    public static function with(
        int $added,
        int $duplicates,
        int $invalid,
        ?array $errors = null
    ): self {
        $self = new self;

        $self['added'] = $added;
        $self['duplicates'] = $duplicates;
        $self['invalid'] = $invalid;

        null !== $errors && $self['errors'] = $errors;

        return $self;
    }

    /**
     * Number of contacts successfully added.
     */
    public function withAdded(int $added): self
    {
        $self = clone $this;
        $self['added'] = $added;

        return $self;
    }

    /**
     * Number of duplicate contacts skipped.
     */
    public function withDuplicates(int $duplicates): self
    {
        $self = clone $this;
        $self['duplicates'] = $duplicates;

        return $self;
    }

    /**
     * Number of invalid contacts rejected.
     */
    public function withInvalid(int $invalid): self
    {
        $self = clone $this;
        $self['invalid'] = $invalid;

        return $self;
    }

    /**
     * Details about invalid contacts.
     *
     * @param list<ErrorShape> $errors
     */
    public function withErrors(array $errors): self
    {
        $self = clone $this;
        $self['errors'] = $errors;

        return $self;
    }
}
