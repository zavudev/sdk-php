<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Start sending the broadcast immediately or schedule for later.
 *
 * **Sending a broadcast needs no account verification.** Identity and business verification raise daily ceilings; neither is a permission to broadcast, on any channel. What stands in front of a broadcast is the content review below, and it applies to every send path — dashboard, API and CLI. Drafts can be created, edited and kept freely.
 *
 * **Daily ceilings apply per recipient.** Each message a broadcast sends counts against the channel's daily ceiling (see `POST /v1/messages`). Once the ceiling is reached, the remaining recipients are marked `failed` with `errorCode` `DAILY_LIMIT_EXCEEDED`; they are not retried the next day.
 *
 * **Review depends on the channel, and cannot be bypassed.** A draft is submitted to automated content review here; it does not go straight out. A WhatsApp broadcast built on a Meta-approved template skips review (Meta already vetted the content) and begins sending. An email broadcast sends as soon as the review passes it, unless the review asks for a person. Every other channel moves to `pending_admin_review` and waits for a person. A broadcast the review refuses lands on `rejected`: use PATCH to edit the content then call POST /retry-review, or escalate it for a manual review.
 *
 * A broadcast is read once, on its own text, rather than per recipient. While an account's sending is suspended its recipients fail individually with `errorCode` `SENDING_SUSPENDED`; see `POST /v1/messages`.
 *
 * Calling this on a broadcast that is already `approved` or `scheduled` sends or reschedules it directly, since it has already been reviewed. Reserves the estimated cost from your balance.
 *
 * @see Zavudev\Services\BroadcastsService::send()
 *
 * @phpstan-type BroadcastSendParamsShape = array{
 *   scheduledAt?: \DateTimeInterface|null
 * }
 */
final class BroadcastSendParams implements BaseModel
{
    /** @use SdkModel<BroadcastSendParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Schedule for future delivery. Omit to send immediately.
     */
    #[Optional]
    public ?\DateTimeInterface $scheduledAt;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?\DateTimeInterface $scheduledAt = null): self
    {
        $self = new self;

        null !== $scheduledAt && $self['scheduledAt'] = $scheduledAt;

        return $self;
    }

    /**
     * Schedule for future delivery. Omit to send immediately.
     */
    public function withScheduledAt(\DateTimeInterface $scheduledAt): self
    {
        $self = clone $this;
        $self['scheduledAt'] = $scheduledAt;

        return $self;
    }
}
