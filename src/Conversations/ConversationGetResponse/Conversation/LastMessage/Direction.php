<?php

declare(strict_types=1);

namespace Zavudev\Conversations\ConversationGetResponse\Conversation\LastMessage;

enum Direction: string
{
    case INBOUND = 'inbound';

    case OUTBOUND = 'outbound';
}
