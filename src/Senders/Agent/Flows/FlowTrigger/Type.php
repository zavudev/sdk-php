<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Flows\FlowTrigger;

/**
 * Type of trigger for a flow.
 */
enum Type: string
{
    case KEYWORD = 'keyword';

    case INTENT = 'intent';

    case ALWAYS = 'always';

    case MANUAL = 'manual';
}
