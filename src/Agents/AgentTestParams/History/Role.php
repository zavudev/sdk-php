<?php

declare(strict_types=1);

namespace Zavudev\Agents\AgentTestParams\History;

enum Role: string
{
    case USER = 'user';

    case ASSISTANT = 'assistant';
}
