<?php

declare(strict_types=1);

namespace Zavudev\Calls\CallListResponse\Transcript;

/**
 * Who produced the turn. `tool` records a tool call the agent made during the conversation.
 */
enum Role: string
{
    case USER = 'user';

    case ASSISTANT = 'assistant';

    case TOOL = 'tool';
}
