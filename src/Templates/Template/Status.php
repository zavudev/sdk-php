<?php

declare(strict_types=1);

namespace Zavudev\Templates\Template;

enum Status: string
{
    case DRAFT = 'draft';

    case PENDING = 'pending';

    case APPROVED = 'approved';

    case REJECTED = 'rejected';
}
