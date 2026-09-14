<?php

declare(strict_types=1);

namespace Zavudev\PhoneNumbers\OwnedPhoneNumber;

/**
 * Regulatory review state. Numbers that need no review are `approved` immediately. A number bought with regulatory information is owned and billed from purchase and starts `pending_review`; it cannot send messages or place calls until this is `approved`. The state is re-checked every 6 hours: poll `GET /v1/phone-numbers/{phoneNumberId}` to follow it.
 *
 * Assign it to a sender with `PATCH /v1/phone-numbers/{phoneNumberId}` (`senderId`) before or after approval. A number assigned while under review is recorded and connected to that sender when it is approved; the connection is retried until it succeeds. A sender created over the API is set up for SMS as part of the assignment. `rejected` means review refused the information: the number cannot be assigned to a sender. A number that stays `pending_review` may be waiting on information the API cannot supply; contact support.
 */
enum RegulatoryStatus: string
{
    case APPROVED = 'approved';

    case PENDING_REVIEW = 'pending_review';

    case REJECTED = 'rejected';
}
