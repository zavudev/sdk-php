<?php

declare(strict_types=1);

namespace Zavudev\EmailDomains\EmailDomainVerifyResponse\Domain\DNSRecord;

/**
 * What the record is for.
 */
enum Purpose: string
{
    case DKIM = 'dkim';

    case SPF = 'spf';

    case DMARC = 'dmarc';

    case MAIL_FROM = 'mail_from';
}
