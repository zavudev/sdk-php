<?php

declare(strict_types=1);

namespace Zavudev\Contacts;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * List contacts with their communication channels.
 *
 * @see Zavudev\Services\ContactsService::list()
 *
 * @phpstan-type ContactListParamsShape = array{
 *   cursor?: string|null,
 *   limit?: int|null,
 *   phoneNumber?: string|null,
 *   search?: string|null,
 *   tag?: list<string>|null,
 * }
 */
final class ContactListParams implements BaseModel
{
    /** @use SdkModel<ContactListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Opaque cursor from a previous response's `nextCursor`. Do not construct it.
     */
    #[Optional]
    public ?string $cursor;

    #[Optional]
    public ?int $limit;

    /**
     * Exact match on the contact's primary phone number, in E.164.
     */
    #[Optional]
    public ?string $phoneNumber;

    /**
     * Free-text match over the contact's name (`displayName` and the WhatsApp profile name), phone numbers and email addresses. Case- and accent-insensitive. A phone number matches on a trailing fragment too, so `5551234` finds `+14155551234`.
     *
     * Contacts created automatically from an inbound message have no `displayName` — they are matched by their identifier until you set one with `PATCH /v1/contacts/{contactId}`.
     *
     * Results come back in relevance order rather than newest-first. `cursor` is opaque in both modes; pass back exactly what the previous response returned, and start a new pagination run when the search term changes.
     */
    #[Optional]
    public ?string $search;

    /**
     * Tag name. Repeatable: `?tag=vip&tag=chile` returns contacts carrying **every** tag given, not any of them — the same rule the dashboard filter applies.
     *
     * Tags are matched by name, case-insensitively. An unknown tag returns 400 rather than being ignored, because a typo that silently matched every contact would be a worse answer than an error.
     *
     * @var list<string>|null $tag
     */
    #[Optional(list: 'string')]
    public ?array $tag;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $tag
     */
    public static function with(
        ?string $cursor = null,
        ?int $limit = null,
        ?string $phoneNumber = null,
        ?string $search = null,
        ?array $tag = null,
    ): self {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $limit && $self['limit'] = $limit;
        null !== $phoneNumber && $self['phoneNumber'] = $phoneNumber;
        null !== $search && $self['search'] = $search;
        null !== $tag && $self['tag'] = $tag;

        return $self;
    }

    /**
     * Opaque cursor from a previous response's `nextCursor`. Do not construct it.
     */
    public function withCursor(string $cursor): self
    {
        $self = clone $this;
        $self['cursor'] = $cursor;

        return $self;
    }

    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Exact match on the contact's primary phone number, in E.164.
     */
    public function withPhoneNumber(string $phoneNumber): self
    {
        $self = clone $this;
        $self['phoneNumber'] = $phoneNumber;

        return $self;
    }

    /**
     * Free-text match over the contact's name (`displayName` and the WhatsApp profile name), phone numbers and email addresses. Case- and accent-insensitive. A phone number matches on a trailing fragment too, so `5551234` finds `+14155551234`.
     *
     * Contacts created automatically from an inbound message have no `displayName` — they are matched by their identifier until you set one with `PATCH /v1/contacts/{contactId}`.
     *
     * Results come back in relevance order rather than newest-first. `cursor` is opaque in both modes; pass back exactly what the previous response returned, and start a new pagination run when the search term changes.
     */
    public function withSearch(string $search): self
    {
        $self = clone $this;
        $self['search'] = $search;

        return $self;
    }

    /**
     * Tag name. Repeatable: `?tag=vip&tag=chile` returns contacts carrying **every** tag given, not any of them — the same rule the dashboard filter applies.
     *
     * Tags are matched by name, case-insensitively. An unknown tag returns 400 rather than being ignored, because a typo that silently matched every contact would be a worse answer than an error.
     *
     * @param list<string> $tag
     */
    public function withTag(array $tag): self
    {
        $self = clone $this;
        $self['tag'] = $tag;

        return $self;
    }
}
