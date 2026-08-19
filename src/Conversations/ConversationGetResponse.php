<?php

declare(strict_types=1);

namespace Zavudev\Conversations;

use Zavudev\Conversations\ConversationGetResponse\Conversation;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type ConversationShape from \Zavudev\Conversations\ConversationGetResponse\Conversation
 *
 * @phpstan-type ConversationGetResponseShape = array{
 *   conversation: Conversation|ConversationShape
 * }
 */
final class ConversationGetResponse implements BaseModel
{
    /** @use SdkModel<ConversationGetResponseShape> */
    use SdkModel;

    /**
     * An inbox thread with one contact. A conversation groups every message exchanged with that contact across channels, so a contact who writes on WhatsApp and later by email stays in one thread.
     */
    #[Required]
    public Conversation $conversation;

    /**
     * `new ConversationGetResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ConversationGetResponse::with(conversation: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ConversationGetResponse)->withConversation(...)
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
     * @param Conversation|ConversationShape $conversation
     */
    public static function with(Conversation|array $conversation): self
    {
        $self = new self;

        $self['conversation'] = $conversation;

        return $self;
    }

    /**
     * An inbox thread with one contact. A conversation groups every message exchanged with that contact across channels, so a contact who writes on WhatsApp and later by email stays in one thread.
     *
     * @param Conversation|ConversationShape $conversation
     */
    public function withConversation(Conversation|array $conversation): self
    {
        $self = clone $this;
        $self['conversation'] = $conversation;

        return $self;
    }
}
