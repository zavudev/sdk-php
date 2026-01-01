<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent;

/**
 * LLM provider for the AI agent.
 */
enum AgentProvider: string
{
    case OPENAI = 'openai';

    case ANTHROPIC = 'anthropic';

    case GOOGLE = 'google';

    case MISTRAL = 'mistral';

    case ZAVU = 'zavu';
}
