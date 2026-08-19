<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Core\Util;
use Zavudev\Introspect\IntrospectValidateEmailResponse;
use Zavudev\Introspect\IntrospectValidatePhoneResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\IntrospectContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class IntrospectService implements IntrospectContract
{
    /**
     * @api
     */
    public IntrospectRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new IntrospectRawService($client);
    }

    /**
     * @api
     *
     * Heuristic email validation to run before sending: catches invalid syntax, dead domains (no MX/A records), disposable inboxes, role-based addresses (info@, contacto@, sales@), and addresses already on your project's suppression list. Use it to clean a list before a broadcast and keep your bounce rate low.
     *
     * No mailbox-level (SMTP) probe is performed, so a `deliverable` verdict is not a delivery guarantee — it means no negative signal was found. Treat `risky` addresses with care and drop `undeliverable` ones.
     *
     * Accepts a single `email` or an `emails` batch (max 100 per request).
     *
     * @param string $email single email address to validate
     * @param list<string> $emails batch of email addresses to validate (max 100)
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function validateEmail(
        ?string $email = null,
        ?array $emails = null,
        RequestOptions|array|null $requestOptions = null,
    ): IntrospectValidateEmailResponse {
        $params = Util::removeNulls(['email' => $email, 'emails' => $emails]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->validateEmail(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Validate a phone number and check if a WhatsApp conversation window is open.
     *
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function validatePhone(
        string $phoneNumber,
        RequestOptions|array|null $requestOptions = null
    ): IntrospectValidatePhoneResponse {
        $params = Util::removeNulls(['phoneNumber' => $phoneNumber]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->validatePhone(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
