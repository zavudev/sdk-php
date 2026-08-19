<?php

declare(strict_types=1);

namespace Zavudev\Introspect\IntrospectValidateEmailResponse\Result;

/**
 * Validation verdict.
 * - `deliverable`: nothing suggests the address will bounce.
 * - `risky`: sendable, but a signal predicts elevated bounce/complaint odds (role address, disposable domain, MX-less domain, prior soft bounce).
 * - `undeliverable`: will bounce or is blocked (invalid syntax, dead domain, or the address is on your suppression list after a hard bounce/complaint).
 */
enum Verdict: string
{
    case DELIVERABLE = 'deliverable';

    case RISKY = 'risky';

    case UNDELIVERABLE = 'undeliverable';
}
