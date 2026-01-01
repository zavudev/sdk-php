<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent;

/**
 * Status of an agent execution.
 */
enum AgentExecutionStatus: string
{
    case SUCCESS = 'success';

    case ERROR = 'error';

    case FILTERED = 'filtered';

    case RATE_LIMITED = 'rate_limited';

    case BALANCE_INSUFFICIENT = 'balance_insufficient';
}
