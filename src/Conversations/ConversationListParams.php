<?php

declare(strict_types=1);

namespace Zavudev\Conversations;

use Zavudev\Conversations\ConversationListParams\Channel;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * List inbox threads, most recently active first. A conversation groups every message with one contact across channels, which is what you need to build an inbox: `GET /v1/messages` returns a flat log with no thread to hang it on.
 *
 * Use `senderId` to scope the list to a single number, and `channel` to keep only threads that have carried that channel.
 *
 * @see Zavudev\Services\ConversationsService::list()
 *
 * @phpstan-type ConversationListParamsShape = array{
 *   channel?: null|Channel|value-of<Channel>,
 *   cursor?: string|null,
 *   limit?: int|null,
 *   search?: string|null,
 *   senderID?: string|null,
 * }
 */
final class ConversationListParams implements BaseModel
{
    /** @use SdkModel<ConversationListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Keep only threads that have carried this channel.
     *
     * @var value-of<Channel>|null $channel
     */
    #[Optional(enum: Channel::class)]
    public ?string $channel;

    /**
     * Opaque cursor from a previous response's `nextCursor`. Do not construct it.
     */
    #[Optional]
    public ?string $cursor;

    #[Optional]
    public ?int $limit;

    /**
     * Search threads by identity: phone number (any format — `+1 (555) 123-4567` and `15551234567` both match), email address (full or local part), WhatsApp group subject, WhatsApp username, or BSUID. Matching is by whole word, with prefix matching on the last term, so `mar` finds `maria@example.com` and `+1555` finds `+15551234567`; a fragment from the middle or end of a number (`4567`) does not match.
     *
     * It does **not** search message bodies — only who the thread is with.
     *
     * Results come back ranked by relevance rather than by recency, so the usual "most recently active first" ordering does not apply while `q` is set. `senderId` and `channel` still narrow the results, and `cursor` paginates them as usual. An empty or whitespace-only `q` returns no items rather than the full list.
     */
    #[Optional]
    public ?string $search;

    /**
     * Keep only threads last handled by this sender.
     */
    #[Optional]
    public ?string $senderID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Channel|value-of<Channel>|null $channel
     */
    public static function with(
        Channel|string|null $channel = null,
        ?string $cursor = null,
        ?int $limit = null,
        ?string $search = null,
        ?string $senderID = null,
    ): self {
        $self = new self;

        null !== $channel && $self['channel'] = $channel;
        null !== $cursor && $self['cursor'] = $cursor;
        null !== $limit && $self['limit'] = $limit;
        null !== $search && $self['search'] = $search;
        null !== $senderID && $self['senderID'] = $senderID;

        return $self;
    }

    /**
     * Keep only threads that have carried this channel.
     *
     * @param Channel|value-of<Channel> $channel
     */
    public function withChannel(Channel|string $channel): self
    {
        $self = clone $this;
        $self['channel'] = $channel;

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
     * Search threads by identity: phone number (any format — `+1 (555) 123-4567` and `15551234567` both match), email address (full or local part), WhatsApp group subject, WhatsApp username, or BSUID. Matching is by whole word, with prefix matching on the last term, so `mar` finds `maria@example.com` and `+1555` finds `+15551234567`; a fragment from the middle or end of a number (`4567`) does not match.
     *
     * It does **not** search message bodies — only who the thread is with.
     *
     * Results come back ranked by relevance rather than by recency, so the usual "most recently active first" ordering does not apply while `q` is set. `senderId` and `channel` still narrow the results, and `cursor` paginates them as usual. An empty or whitespace-only `q` returns no items rather than the full list.
     */
    public function withSearch(string $search): self
    {
        $self = clone $this;
        $self['search'] = $search;

        return $self;
    }

    /**
     * Keep only threads last handled by this sender.
     */
    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }
}
