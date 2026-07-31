<?php

declare(strict_types=1);

namespace Zavudev\Invitations\Invitation\ConnectedAccount;

enum Channel: string
{
    case WHATSAPP = 'whatsapp';

    case MESSENGER = 'messenger';
}
