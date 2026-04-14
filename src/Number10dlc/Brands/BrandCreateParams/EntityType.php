<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Brands\BrandCreateParams;

/**
 * Business entity type for 10DLC brand registration.
 */
enum EntityType: string
{
    case PRIVATE_PROFIT = 'PRIVATE_PROFIT';

    case PUBLIC_PROFIT = 'PUBLIC_PROFIT';

    case NON_PROFIT = 'NON_PROFIT';

    case GOVERNMENT = 'GOVERNMENT';

    case SOLE_PROPRIETOR = 'SOLE_PROPRIETOR';
}
