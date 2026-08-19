<?php

declare(strict_types=1);

namespace Zavudev\Calls\CallListResponse;

use Zavudev\Calls\CallListResponse\Transcript\Role;
use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * A single turn in a voice call transcript.
 *
 * @phpstan-type TranscriptShape = array{
 *   role: Role|value-of<Role>,
 *   seq: int,
 *   text: string,
 *   endedAt?: \DateTimeInterface|null,
 *   startedAt?: \DateTimeInterface|null,
 * }
 */
final class Transcript implements BaseModel
{
    /** @use SdkModel<TranscriptShape> */
    use SdkModel;

    /**
     * Who produced the turn. `tool` records a tool call the agent made during the conversation.
     *
     * @var value-of<Role> $role
     */
    #[Required(enum: Role::class)]
    public string $role;

    /**
     * Ordinal position of the turn within the call, starting at 0.
     */
    #[Required]
    public int $seq;

    /**
     * Transcribed speech for `user` and `assistant` turns, or a JSON summary of the tool call for `tool` turns.
     */
    #[Required]
    public string $text;

    /**
     * When the turn ended.
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $endedAt;

    /**
     * When the turn started.
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $startedAt;

    /**
     * `new Transcript()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Transcript::with(role: ..., seq: ..., text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Transcript)->withRole(...)->withSeq(...)->withText(...)
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
     * @param Role|value-of<Role> $role
     */
    public static function with(
        Role|string $role,
        int $seq,
        string $text,
        ?\DateTimeInterface $endedAt = null,
        ?\DateTimeInterface $startedAt = null,
    ): self {
        $self = new self;

        $self['role'] = $role;
        $self['seq'] = $seq;
        $self['text'] = $text;

        null !== $endedAt && $self['endedAt'] = $endedAt;
        null !== $startedAt && $self['startedAt'] = $startedAt;

        return $self;
    }

    /**
     * Who produced the turn. `tool` records a tool call the agent made during the conversation.
     *
     * @param Role|value-of<Role> $role
     */
    public function withRole(Role|string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }

    /**
     * Ordinal position of the turn within the call, starting at 0.
     */
    public function withSeq(int $seq): self
    {
        $self = clone $this;
        $self['seq'] = $seq;

        return $self;
    }

    /**
     * Transcribed speech for `user` and `assistant` turns, or a JSON summary of the tool call for `tool` turns.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * When the turn ended.
     */
    public function withEndedAt(?\DateTimeInterface $endedAt): self
    {
        $self = clone $this;
        $self['endedAt'] = $endedAt;

        return $self;
    }

    /**
     * When the turn started.
     */
    public function withStartedAt(?\DateTimeInterface $startedAt): self
    {
        $self = clone $this;
        $self['startedAt'] = $startedAt;

        return $self;
    }
}
