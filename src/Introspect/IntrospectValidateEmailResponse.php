<?php

declare(strict_types=1);

namespace Zavudev\Introspect;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\Introspect\IntrospectValidateEmailResponse\Result;
use Zavudev\Introspect\IntrospectValidateEmailResponse\Summary;

/**
 * @phpstan-import-type ResultShape from \Zavudev\Introspect\IntrospectValidateEmailResponse\Result
 * @phpstan-import-type SummaryShape from \Zavudev\Introspect\IntrospectValidateEmailResponse\Summary
 *
 * @phpstan-type IntrospectValidateEmailResponseShape = array{
 *   results: list<Result|ResultShape>, summary: Summary|SummaryShape
 * }
 */
final class IntrospectValidateEmailResponse implements BaseModel
{
    /** @use SdkModel<IntrospectValidateEmailResponseShape> */
    use SdkModel;

    /**
     * One result per submitted address, in the same order.
     *
     * @var list<Result> $results
     */
    #[Required(list: Result::class)]
    public array $results;

    #[Required]
    public Summary $summary;

    /**
     * `new IntrospectValidateEmailResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * IntrospectValidateEmailResponse::with(results: ..., summary: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new IntrospectValidateEmailResponse)->withResults(...)->withSummary(...)
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
     * @param list<Result|ResultShape> $results
     * @param Summary|SummaryShape $summary
     */
    public static function with(array $results, Summary|array $summary): self
    {
        $self = new self;

        $self['results'] = $results;
        $self['summary'] = $summary;

        return $self;
    }

    /**
     * One result per submitted address, in the same order.
     *
     * @param list<Result|ResultShape> $results
     */
    public function withResults(array $results): self
    {
        $self = clone $this;
        $self['results'] = $results;

        return $self;
    }

    /**
     * @param Summary|SummaryShape $summary
     */
    public function withSummary(Summary|array $summary): self
    {
        $self = clone $this;
        $self['summary'] = $summary;

        return $self;
    }
}
