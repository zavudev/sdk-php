<?php

declare(strict_types=1);

namespace Zavudev\Conversations\ConversationListResponse;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Present when the thread is a group chat rather than a one-to-one conversation.
 *
 * @phpstan-type GroupShape = array{
 *   id: string, participantCount?: int|null, subject?: string|null
 * }
 */
final class Group implements BaseModel
{
    /** @use SdkModel<GroupShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Optional]
    public ?int $participantCount;

    #[Optional]
    public ?string $subject;

    /**
     * `new Group()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Group::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Group)->withID(...)
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
     */
    public static function with(
        string $id,
        ?int $participantCount = null,
        ?string $subject = null
    ): self {
        $self = new self;

        $self['id'] = $id;

        null !== $participantCount && $self['participantCount'] = $participantCount;
        null !== $subject && $self['subject'] = $subject;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withParticipantCount(int $participantCount): self
    {
        $self = clone $this;
        $self['participantCount'] = $participantCount;

        return $self;
    }

    public function withSubject(string $subject): self
    {
        $self = clone $this;
        $self['subject'] = $subject;

        return $self;
    }
}
