<?php

declare(strict_types=1);

namespace Zavudev\Introspect\IntrospectValidateEmailResponse\Result;

enum Reason: string
{
    case INVALID_SYNTAX = 'invalid_syntax';

    case DOMAIN_NOT_FOUND = 'domain_not_found';

    case DOMAIN_NO_MX = 'domain_no_mx';

    case DISPOSABLE_DOMAIN = 'disposable_domain';

    case ROLE_ADDRESS = 'role_address';

    case SUPPRESSED_HARD_BOUNCE = 'suppressed_hard_bounce';

    case SUPPRESSED_SOFT_BOUNCE = 'suppressed_soft_bounce';

    case SUPPRESSED_COMPLAINT = 'suppressed_complaint';

    case SUPPRESSED_MANUAL = 'suppressed_manual';

    case SUPPRESSED_UNSUBSCRIBE = 'suppressed_unsubscribe';
}
