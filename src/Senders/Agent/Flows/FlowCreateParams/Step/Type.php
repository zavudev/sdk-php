<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Flows\FlowCreateParams\Step;

/**
 * Type of flow step.
 */
enum Type: string
{
    case MESSAGE = 'message';

    case COLLECT = 'collect';

    case CONDITION = 'condition';

    case TOOL = 'tool';

    case LLM = 'llm';

    case TRANSFER = 'transfer';
}
