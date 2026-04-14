<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Brands\TenDlcBrand;

/**
 * Status of a 10DLC brand registration.
 */
enum Status: string
{
    case DRAFT = 'draft';

    case PENDING = 'pending';

    case VERIFIED = 'verified';

    case REJECTED = 'rejected';
}
