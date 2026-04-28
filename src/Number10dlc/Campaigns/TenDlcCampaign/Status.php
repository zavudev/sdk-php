<?php

declare(strict_types=1);

namespace Zavudev\Number10dlc\Campaigns\TenDlcCampaign;

/**
 * Status of a 10DLC campaign registration.
 */
enum Status: string
{
    case DRAFT = 'draft';

    case PENDING = 'pending';

    case APPROVED = 'approved';

    case REJECTED = 'rejected';
}
