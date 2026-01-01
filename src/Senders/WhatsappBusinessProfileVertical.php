<?php

declare(strict_types=1);

namespace Zavudev\Senders;

/**
 * Business category for WhatsApp Business profile.
 */
enum WhatsappBusinessProfileVertical: string
{
    case UNDEFINED = 'UNDEFINED';

    case OTHER = 'OTHER';

    case AUTO = 'AUTO';

    case BEAUTY = 'BEAUTY';

    case APPAREL = 'APPAREL';

    case EDU = 'EDU';

    case ENTERTAIN = 'ENTERTAIN';

    case EVENT_PLAN = 'EVENT_PLAN';

    case FINANCE = 'FINANCE';

    case GROCERY = 'GROCERY';

    case GOVT = 'GOVT';

    case HOTEL = 'HOTEL';

    case HEALTH = 'HEALTH';

    case NONPROFIT = 'NONPROFIT';

    case PROF_SERVICES = 'PROF_SERVICES';

    case RETAIL = 'RETAIL';

    case TRAVEL = 'TRAVEL';

    case RESTAURANT = 'RESTAURANT';

    case NOT_A_BIZ = 'NOT_A_BIZ';
}
