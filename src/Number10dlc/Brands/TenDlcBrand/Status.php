<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Brands\TenDlcBrand;

/**
 * Status of a 10DLC brand registration.
 *
 * - `draft`: created, not yet submitted to the carrier.
 * - `pending`: submitted, awaiting the carrier's answer.
 * - `verified`: the carrier registered the brand AND verified the business behind it.
 * - `unverified`: the carrier registered the brand but did not verify the business — the registration exists, the identity check did not pass or has not been resolved. Campaigns are allowed, with lower daily limits. Read `identityStatus` for the carrier's own wording.
 * - `rejected`: refused by the carrier.
 * - `failed`: the registration never reached the carrier; the fee is refunded.
 */
enum Status: string
{
    case DRAFT = 'draft';

    case PENDING = 'pending';

    case VERIFIED = 'verified';

    case UNVERIFIED = 'unverified';

    case REJECTED = 'rejected';

    case FAILED = 'failed';
}
