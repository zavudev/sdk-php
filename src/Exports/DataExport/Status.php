<?php

declare(strict_types=1);

namespace Zavudev\Exports\DataExport;

/**
 * Status of a data export job.
 */
enum Status: string
{
    case PENDING = 'pending';

    case PROCESSING = 'processing';

    case COMPLETED = 'completed';

    case FAILED = 'failed';
}
