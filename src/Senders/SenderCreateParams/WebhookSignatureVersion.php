<?php

declare(strict_types=1);

namespace Zavudev\Senders\SenderCreateParams;

/**
 * Which `X-Zavu-Signature` scheme this receiver is sent.
 *
 * - `v1`: `v1=HMAC_SHA256(secret, body)`. The scheme used before this was configurable. Existing webhooks stay on it until you move them.
 * - `v2`: `v2=HMAC_SHA256(secret, "{t}.{body}")`. The current scheme, and the default for new senders. It signs the timestamp together with the body.
 * - `v1+v2`: both signatures, sharing one `t`. The migration setting: a receiver reading either one works, so you can deploy and confirm your new verifier before switching over.
 *
 * Moving from `v1` straight to `v2` returns `400`. Set `v1+v2` first. See https://docs.zavu.dev/guides/receiving-messages/signature-migration
 */
enum WebhookSignatureVersion: string
{
    case V1 = 'v1';

    case V1_V2 = 'v1+v2';

    case V2 = 'v2';
}
