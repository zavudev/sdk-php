<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Agent\Voice;

/**
 * What the agent does when an answering machine or voicemail is detected on an outbound call.
 */
enum VoicemailAction: string
{
    case HANGUP = 'hangup';

    case LEAVE_MESSAGE = 'leave_message';
}
