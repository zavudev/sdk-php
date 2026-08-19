<?php

declare(strict_types=1);

namespace Zavudev\Services;

use Zavudev\Client;
use Zavudev\Core\Contracts\BaseResponse;
use Zavudev\Core\Exceptions\APIException;
use Zavudev\Introspect\IntrospectValidateEmailParams;
use Zavudev\Introspect\IntrospectValidateEmailResponse;
use Zavudev\Introspect\IntrospectValidatePhoneParams;
use Zavudev\Introspect\IntrospectValidatePhoneResponse;
use Zavudev\RequestOptions;
use Zavudev\ServiceContracts\IntrospectRawContract;

/**
 * @phpstan-import-type RequestOpts from \Zavudev\RequestOptions
 */
final class IntrospectRawService implements IntrospectRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Heuristic email validation to run before sending: catches invalid syntax, dead domains (no MX/A records), disposable inboxes, role-based addresses (info@, contacto@, sales@), and addresses already on your project's suppression list. Use it to clean a list before a broadcast and keep your bounce rate low.
     *
     * No mailbox-level (SMTP) probe is performed, so a `deliverable` verdict is not a delivery guarantee — it means no negative signal was found. Treat `risky` addresses with care and drop `undeliverable` ones.
     *
     * Accepts a single `email` or an `emails` batch (max 100 per request).
     *
     * @param array{
     *   email?: string, emails?: list<string>
     * }|IntrospectValidateEmailParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<IntrospectValidateEmailResponse>
     *
     * @throws APIException
     */
    public function validateEmail(
        array|IntrospectValidateEmailParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = IntrospectValidateEmailParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/introspect/email',
            body: (object) $parsed,
            options: $options,
            convert: IntrospectValidateEmailResponse::class,
        );
    }

    /**
     * @api
     *
     * Validate a phone number and check if a WhatsApp conversation window is open.
     *
     * @param array{phoneNumber: string}|IntrospectValidatePhoneParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<IntrospectValidatePhoneResponse>
     *
     * @throws APIException
     */
    public function validatePhone(
        array|IntrospectValidatePhoneParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = IntrospectValidatePhoneParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/introspect/phone',
            body: (object) $parsed,
            options: $options,
            convert: IntrospectValidatePhoneResponse::class,
        );
    }
}
