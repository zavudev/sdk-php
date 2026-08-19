<?php

declare(strict_types=1);

namespace Zavudev\Conversations\ConversationMarkAsReadResponse;

use Zavudev\Conversations\ConversationMarkAsReadResponse\Conversation\Group;
use Zavudev\Conversations\ConversationMarkAsReadResponse\Conversation\LastMessage;
use Zavudev\Conversations\ConversationMarkAsReadResponse\Conversation\Whatsapp;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * An inbox thread with one contact. A conversation groups every message exchanged with that contact across channels, so a contact who writes on WhatsApp and later by email stays in one thread.
 *
 * @phpstan-import-type LastMessageShape from \Zavudev\Conversations\ConversationMarkAsReadResponse\Conversation\LastMessage
 * @phpstan-import-type GroupShape from \Zavudev\Conversations\ConversationMarkAsReadResponse\Conversation\Group
 * @phpstan-import-type WhatsappShape from \Zavudev\Conversations\ConversationMarkAsReadResponse\Conversation\Whatsapp
 *
 * @phpstan-type ConversationShape = array{
 *   id: string,
 *   channels: list<string>,
 *   contactIdentifier: string,
 *   createdAt: \DateTimeInterface,
 *   lastMessage: LastMessage|LastMessageShape,
 *   messageCount: int,
 *   unreadCount: int,
 *   updatedAt: \DateTimeInterface,
 *   contactID?: string|null,
 *   email?: string|null,
 *   group?: null|Group|GroupShape,
 *   senderID?: string|null,
 *   whatsapp?: null|Whatsapp|WhatsappShape,
 * }
 */
final class Conversation implements BaseModel
{
    /** @use SdkModel<ConversationShape> */
    use SdkModel;

    #[Required]
    public string $id;

    /**
     * Every channel this thread has carried messages on.
     *
     * @var list<string> $channels
     */
    #[Required(list: 'string')]
    public array $channels;

    /**
     * The key this thread is filed under: a phone number in E.164, a WhatsApp business-scoped user ID (BSUID), a numeric chat ID (Telegram/Instagram/Messenger), or a group JID. It is not always a phone number, so do not parse it as one.
     */
    #[Required]
    public string $contactIdentifier;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * Denormalized preview of the most recent message, so a thread list needs no extra fetch.
     */
    #[Required]
    public LastMessage $lastMessage;

    #[Required]
    public int $messageCount;

    /**
     * Inbound messages not yet marked read. Reset with POST /v1/conversations/{conversationId}/read.
     */
    #[Required]
    public int $unreadCount;

    #[Required]
    public \DateTimeInterface $updatedAt;

    /**
     * ID of the contact this thread belongs to. Absent on group threads and on threads whose contact has not been resolved yet.
     */
    #[Optional('contactId')]
    public ?string $contactID;

    /**
     * Email address of the thread, when the contact was reached by email.
     */
    #[Optional]
    public ?string $email;

    /**
     * Present when the thread is a group chat rather than a one-to-one conversation.
     */
    #[Optional]
    public ?Group $group;

    /**
     * Sender that last handled this thread. Use it as the `Zavu-Sender` header when replying so the answer leaves from the same number the contact knows.
     */
    #[Optional('senderId')]
    public ?string $senderID;

    /**
     * WhatsApp identity, present when the contact adopted a username.
     */
    #[Optional]
    public ?Whatsapp $whatsapp;

    /**
     * `new Conversation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Conversation::with(
     *   id: ...,
     *   channels: ...,
     *   contactIdentifier: ...,
     *   createdAt: ...,
     *   lastMessage: ...,
     *   messageCount: ...,
     *   unreadCount: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Conversation)
     *   ->withID(...)
     *   ->withChannels(...)
     *   ->withContactIdentifier(...)
     *   ->withCreatedAt(...)
     *   ->withLastMessage(...)
     *   ->withMessageCount(...)
     *   ->withUnreadCount(...)
     *   ->withUpdatedAt(...)
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
     * @param list<string> $channels
     * @param LastMessage|LastMessageShape $lastMessage
     * @param Group|GroupShape|null $group
     * @param Whatsapp|WhatsappShape|null $whatsapp
     */
    public static function with(
        string $id,
        array $channels,
        string $contactIdentifier,
        \DateTimeInterface $createdAt,
        LastMessage|array $lastMessage,
        int $messageCount,
        int $unreadCount,
        \DateTimeInterface $updatedAt,
        ?string $contactID = null,
        ?string $email = null,
        Group|array|null $group = null,
        ?string $senderID = null,
        Whatsapp|array|null $whatsapp = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['channels'] = $channels;
        $self['contactIdentifier'] = $contactIdentifier;
        $self['createdAt'] = $createdAt;
        $self['lastMessage'] = $lastMessage;
        $self['messageCount'] = $messageCount;
        $self['unreadCount'] = $unreadCount;
        $self['updatedAt'] = $updatedAt;

        null !== $contactID && $self['contactID'] = $contactID;
        null !== $email && $self['email'] = $email;
        null !== $group && $self['group'] = $group;
        null !== $senderID && $self['senderID'] = $senderID;
        null !== $whatsapp && $self['whatsapp'] = $whatsapp;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Every channel this thread has carried messages on.
     *
     * @param list<string> $channels
     */
    public function withChannels(array $channels): self
    {
        $self = clone $this;
        $self['channels'] = $channels;

        return $self;
    }

    /**
     * The key this thread is filed under: a phone number in E.164, a WhatsApp business-scoped user ID (BSUID), a numeric chat ID (Telegram/Instagram/Messenger), or a group JID. It is not always a phone number, so do not parse it as one.
     */
    public function withContactIdentifier(string $contactIdentifier): self
    {
        $self = clone $this;
        $self['contactIdentifier'] = $contactIdentifier;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Denormalized preview of the most recent message, so a thread list needs no extra fetch.
     *
     * @param LastMessage|LastMessageShape $lastMessage
     */
    public function withLastMessage(LastMessage|array $lastMessage): self
    {
        $self = clone $this;
        $self['lastMessage'] = $lastMessage;

        return $self;
    }

    public function withMessageCount(int $messageCount): self
    {
        $self = clone $this;
        $self['messageCount'] = $messageCount;

        return $self;
    }

    /**
     * Inbound messages not yet marked read. Reset with POST /v1/conversations/{conversationId}/read.
     */
    public function withUnreadCount(int $unreadCount): self
    {
        $self = clone $this;
        $self['unreadCount'] = $unreadCount;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * ID of the contact this thread belongs to. Absent on group threads and on threads whose contact has not been resolved yet.
     */
    public function withContactID(string $contactID): self
    {
        $self = clone $this;
        $self['contactID'] = $contactID;

        return $self;
    }

    /**
     * Email address of the thread, when the contact was reached by email.
     */
    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * Present when the thread is a group chat rather than a one-to-one conversation.
     *
     * @param Group|GroupShape $group
     */
    public function withGroup(Group|array $group): self
    {
        $self = clone $this;
        $self['group'] = $group;

        return $self;
    }

    /**
     * Sender that last handled this thread. Use it as the `Zavu-Sender` header when replying so the answer leaves from the same number the contact knows.
     */
    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }

    /**
     * WhatsApp identity, present when the contact adopted a username.
     *
     * @param Whatsapp|WhatsappShape $whatsapp
     */
    public function withWhatsapp(Whatsapp|array $whatsapp): self
    {
        $self = clone $this;
        $self['whatsapp'] = $whatsapp;

        return $self;
    }
}
