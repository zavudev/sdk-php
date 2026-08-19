<?php

declare(strict_types=1);

namespace Zavudev\Conversations;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Messages in this thread, newest first, across every channel it has carried. Reply with `POST /v1/messages`, passing the conversation's `senderId` as the `Zavu-Sender` header so the answer leaves from the number the contact already knows.
 *
 * @see Zavudev\Services\ConversationsService::listMessages()
 *
 * @phpstan-type ConversationListMessagesParamsShape = array{
 *   cursor?: string|null, limit?: int|null
 * }
 */
final class ConversationListMessagesParams implements BaseModel
{
    /** @use SdkModel<ConversationListMessagesParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Opaque cursor from a previous response's `nextCursor`.
     */
    #[Optional]
    public ?string $cursor;

    #[Optional]
    public ?int $limit;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $cursor = null, ?int $limit = null): self
    {
        $self = new self;

        null !== $cursor && $self['cursor'] = $cursor;
        null !== $limit && $self['limit'] = $limit;

        return $self;
    }

    /**
     * Opaque cursor from a previous response's `nextCursor`.
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
}
