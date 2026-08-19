<?php

declare(strict_types=1);

namespace Zavudev\Conversations\ConversationMarkAsReadResponse\Conversation\LastMessage;

enum Direction: string
{
    case INBOUND = 'inbound';

    case OUTBOUND = 'outbound';
}
