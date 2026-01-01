<?php

declare(strict_types=1);

namespace Zavudev\RegulatoryDocuments\RegulatoryDocument;

enum Status: string
{
    case PENDING = 'pending';

    case UPLOADED = 'uploaded';

    case VERIFIED = 'verified';

    case REJECTED = 'rejected';
}
