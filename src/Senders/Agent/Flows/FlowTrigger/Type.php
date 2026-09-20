<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Flows\FlowTrigger;

/**
 * What starts a flow.
 *
 * - `keyword`: the message contains one of the words listed in `keywords`. Plain substring matching, so a word inside another word still counts.
 * - `intent`: the message MEANS what `intent` describes, whatever words it uses.
 * - `always`: any message starts it.
 * - `manual`: reserved. Nothing starts a `manual` flow today — it is accepted and stored, and no message or endpoint runs it.
 */
enum Type: string
{
    case KEYWORD = 'keyword';

    case INTENT = 'intent';

    case ALWAYS = 'always';

    case MANUAL = 'manual';
}
