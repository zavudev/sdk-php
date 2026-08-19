<?php

declare(strict_types=1);

namespace Zavudev\Introspect\IntrospectValidateEmailResponse;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Introspect\IntrospectValidateEmailResponse\Result\Reason;
use Zavudev\Introspect\IntrospectValidateEmailResponse\Result\Verdict;

/**
 * @phpstan-type ResultShape = array{
 *   domain: string|null,
 *   email: string,
 *   normalized: string|null,
 *   reasons: list<Reason|value-of<Reason>>,
 *   verdict: Verdict|value-of<Verdict>,
 * }
 */
final class Result implements BaseModel
{
    /** @use SdkModel<ResultShape> */
    use SdkModel;

    /**
     * Domain part of the address. Null when the syntax is invalid.
     */
    #[Required]
    public ?string $domain;

    /**
     * The address exactly as submitted.
     */
    #[Required]
    public string $email;

    /**
     * Lowercased, trimmed form of the address. Null when the syntax is invalid.
     */
    #[Required]
    public ?string $normalized;

    /**
     * Signals behind the verdict. Empty for a clean `deliverable` address.
     *
     * @var list<value-of<Reason>> $reasons
     */
    #[Required(list: Reason::class)]
    public array $reasons;

    /**
     * Validation verdict.
     * - `deliverable`: nothing suggests the address will bounce.
     * - `risky`: sendable, but a signal predicts elevated bounce/complaint odds (role address, disposable domain, MX-less domain, prior soft bounce).
     * - `undeliverable`: will bounce or is blocked (invalid syntax, dead domain, or the address is on your suppression list after a hard bounce/complaint).
     *
     * @var value-of<Verdict> $verdict
     */
    #[Required(enum: Verdict::class)]
    public string $verdict;

    /**
     * `new Result()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Result::with(
     *   domain: ..., email: ..., normalized: ..., reasons: ..., verdict: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Result)
     *   ->withDomain(...)
     *   ->withEmail(...)
     *   ->withNormalized(...)
     *   ->withReasons(...)
     *   ->withVerdict(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<Reason|value-of<Reason>> $reasons
     * @param Verdict|value-of<Verdict> $verdict
     */
    public static function with(
        ?string $domain,
        string $email,
        ?string $normalized,
        array $reasons,
        Verdict|string $verdict,
    ): self {
        $self = new self;

        $self['domain'] = $domain;
        $self['email'] = $email;
        $self['normalized'] = $normalized;
        $self['reasons'] = $reasons;
        $self['verdict'] = $verdict;

        return $self;
    }

    /**
     * Domain part of the address. Null when the syntax is invalid.
     */
    public function withDomain(?string $domain): self
    {
        $self = clone $this;
        $self['domain'] = $domain;

        return $self;
    }

    /**
     * The address exactly as submitted.
     */
    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * Lowercased, trimmed form of the address. Null when the syntax is invalid.
     */
    public function withNormalized(?string $normalized): self
    {
        $self = clone $this;
        $self['normalized'] = $normalized;

        return $self;
    }

    /**
     * Signals behind the verdict. Empty for a clean `deliverable` address.
     *
     * @param list<Reason|value-of<Reason>> $reasons
     */
    public function withReasons(array $reasons): self
    {
        $self = clone $this;
        $self['reasons'] = $reasons;

        return $self;
    }

    /**
     * Validation verdict.
     * - `deliverable`: nothing suggests the address will bounce.
     * - `risky`: sendable, but a signal predicts elevated bounce/complaint odds (role address, disposable domain, MX-less domain, prior soft bounce).
     * - `undeliverable`: will bounce or is blocked (invalid syntax, dead domain, or the address is on your suppression list after a hard bounce/complaint).
     *
     * @param Verdict|value-of<Verdict> $verdict
     */
    public function withVerdict(Verdict|string $verdict): self
    {
        $self = clone $this;
        $self['verdict'] = $verdict;

        return $self;
    }
}
