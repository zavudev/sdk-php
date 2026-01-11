<?php

declare(strict_types=1);

namespace Zavudev\Broadcasts\Broadcast;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * AI content review result.
 *
 * @phpstan-type ReviewResultShape = array{
 *   categories?: list<string>|null,
 *   flaggedContent?: list<string>|null,
 *   reasoning?: string|null,
 *   reviewedAt?: \DateTimeInterface|null,
 *   score?: float|null,
 * }
 */
final class ReviewResult implements BaseModel
{
    /** @use SdkModel<ReviewResultShape> */
    use SdkModel;

    /**
     * Policy categories violated, if any.
     *
     * @var list<string>|null $categories
     */
    #[Optional(list: 'string')]
    public ?array $categories;

    /**
     * Problematic text fragments, if any.
     *
     * @var list<string>|null $flaggedContent
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $flaggedContent;

    /**
     * Explanation of the review decision.
     */
    #[Optional]
    public ?string $reasoning;

    #[Optional]
    public ?\DateTimeInterface $reviewedAt;

    /**
     * Content safety score from 0.0 to 1.0, where 1.0 is completely safe.
     */
    #[Optional]
    public ?float $score;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $categories
     * @param list<string>|null $flaggedContent
     */
    public static function with(
        ?array $categories = null,
        ?array $flaggedContent = null,
        ?string $reasoning = null,
        ?\DateTimeInterface $reviewedAt = null,
        ?float $score = null,
    ): self {
        $self = new self;

        null !== $categories && $self['categories'] = $categories;
        null !== $flaggedContent && $self['flaggedContent'] = $flaggedContent;
        null !== $reasoning && $self['reasoning'] = $reasoning;
        null !== $reviewedAt && $self['reviewedAt'] = $reviewedAt;
        null !== $score && $self['score'] = $score;

        return $self;
    }

    /**
     * Policy categories violated, if any.
     *
     * @param list<string> $categories
     */
    public function withCategories(array $categories): self
    {
        $self = clone $this;
        $self['categories'] = $categories;

        return $self;
    }

    /**
     * Problematic text fragments, if any.
     *
     * @param list<string>|null $flaggedContent
     */
    public function withFlaggedContent(?array $flaggedContent): self
    {
        $self = clone $this;
        $self['flaggedContent'] = $flaggedContent;

        return $self;
    }

    /**
     * Explanation of the review decision.
     */
    public function withReasoning(string $reasoning): self
    {
        $self = clone $this;
        $self['reasoning'] = $reasoning;

        return $self;
    }

    public function withReviewedAt(\DateTimeInterface $reviewedAt): self
    {
        $self = clone $this;
        $self['reviewedAt'] = $reviewedAt;

        return $self;
    }

    /**
     * Content safety score from 0.0 to 1.0, where 1.0 is completely safe.
     */
    public function withScore(float $score): self
    {
        $self = clone $this;
        $self['score'] = $score;

        return $self;
    }
}
