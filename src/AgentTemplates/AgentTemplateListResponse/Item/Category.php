<?php

declare(strict_types=1);

namespace Zavudev\AgentTemplates\AgentTemplateListResponse\Item;

enum Category: string
{
    case SALES = 'sales';

    case SUPPORT = 'support';

    case FRONT_DESK = 'frontDesk';

    case OPS = 'ops';
}
