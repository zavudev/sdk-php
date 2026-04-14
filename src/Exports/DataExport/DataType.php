<?php

declare(strict_types=1);

namespace Zavudev\Exports\DataExport;

/**
 * Types of data that can be exported.
 */
enum DataType: string
{
    case MESSAGES = 'messages';

    case CONVERSATIONS = 'conversations';

    case WEBHOOK_DELIVERIES = 'webhookDeliveries';

    case AGENT_EXECUTIONS = 'agentExecutions';

    case ACTIVITIES = 'activities';
}
