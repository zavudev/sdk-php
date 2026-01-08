<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts\Contacts;

use Zavudev\Broadcasts\Contacts\ContactAddParams\Contact;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Add contacts to a broadcast in batch. Maximum 1000 contacts per request.
 *
 * @see Zavudev\Services\Broadcasts\ContactsService::add()
 *
 * @phpstan-import-type ContactShape from \Zavudev\Broadcasts\Contacts\ContactAddParams\Contact
 *
 * @phpstan-type ContactAddParamsShape = array{
 *   contacts: list<Contact|ContactShape>
 * }
 */
final class ContactAddParams implements BaseModel
{
    /** @use SdkModel<ContactAddParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * List of contacts to add (max 1000 per request).
     *
     * @var list<Contact> $contacts
     */
    #[Required(list: Contact::class)]
    public array $contacts;

    /**
     * `new ContactAddParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ContactAddParams::with(contacts: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ContactAddParams)->withContacts(...)
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
     * @param list<Contact|ContactShape> $contacts
     */
    public static function with(array $contacts): self
    {
        $self = new self;

        $self['contacts'] = $contacts;

        return $self;
    }

    /**
     * List of contacts to add (max 1000 per request).
     *
     * @param list<Contact|ContactShape> $contacts
     */
    public function withContacts(array $contacts): self
    {
        $self = clone $this;
        $self['contacts'] = $contacts;

        return $self;
    }
}
