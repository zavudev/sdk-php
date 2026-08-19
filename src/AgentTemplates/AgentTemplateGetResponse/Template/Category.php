<?php

declare(strict_types=1);

namespace Zavudev\AgentTemplates\AgentTemplateGetResponse\Template;

enum Category: string
{
    case SALES = 'sales';

    case SUPPORT = 'support';

    case FRONT_DESK = 'frontDesk';

    case OPS = 'ops';
}
