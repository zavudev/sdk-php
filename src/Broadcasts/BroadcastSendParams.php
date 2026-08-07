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
 * **Verification is required to send, and there are two of them.** The team must have completed both identity verification (KYC) and business verification (KYB); passing one is not enough. Drafts can be created, edited and kept without either. Every send path — dashboard, API and CLI alike — enforces both, returning `403` with code `kyc_required` or `kyb_required` for whichever is outstanding.
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
