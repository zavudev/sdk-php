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
 * **The account must be past the unverified level to send, except on WhatsApp.** An account that has verified nothing is refused with `403` and code `kyc_required` on every channel other than `whatsapp`. Any one of these lifts it: identity verification (KYC), a saved payment method, a settled deposit, or a paid plan. Business verification (KYB) is not required to broadcast; it gates 10DLC registration only. A `whatsapp` broadcast is exempt: it can only be built on a template, and Meta vets the business and the content when it approves that template, so an unapproved template is refused instead. `smart` is not exempt, since it can route a contact to SMS or email. Drafts can be created, edited and kept without any check. Every send path (dashboard, API and CLI) enforces the same rule.
 *
 * **Daily ceilings apply per recipient.** Each message a broadcast sends counts against the channel's daily ceiling (see `POST /v1/messages`). Once the ceiling is reached, the remaining recipients are marked `failed` with `errorCode` `DAILY_LIMIT_EXCEEDED`; they are not retried the next day.
 *
 * **Review depends on the channel, and cannot be bypassed.** A draft is submitted to automated content review here; it does not go straight out. A WhatsApp broadcast built on a Meta-approved template skips review (Meta already vetted the content) and begins sending. An email broadcast sends as soon as the automated review passes. Every other channel moves to `pending_admin_review` and waits for a person. If the review rejects it, use PATCH to edit the content then call POST /retry-review.
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
