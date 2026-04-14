<?php

declare(strict_types=1);

namespace Zavudev\URLs;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;
use Zavudev\URLs\VerifiedURL\ApprovalType;
use Zavudev\URLs\VerifiedURL\Status;

/**
 * @phpstan-type VerifiedURLShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   domain: string,
 *   status: Status|value-of<Status>,
 *   url: string,
 *   approvalType?: null|ApprovalType|value-of<ApprovalType>,
 *   updatedAt?: \DateTimeInterface|null,
 * }
 */
final class VerifiedURL implements BaseModel
{
    /** @use SdkModel<VerifiedURLShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    /**
     * Domain extracted from the URL.
     */
    #[Required]
    public string $domain;

    /**
     * Status of a verified URL.
     *
     * @var value-of<Status> $status
     */
    #[Required(enum: Status::class)]
    public string $status;

    /**
     * The verified URL.
     */
    #[Required]
    public string $url;

    /**
     * How the URL was approved or rejected.
     *
     * @var value-of<ApprovalType>|null $approvalType
     */
    #[Optional(enum: ApprovalType::class)]
    public ?string $approvalType;

    #[Optional]
    public ?\DateTimeInterface $updatedAt;

    /**
     * `new VerifiedURL()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * VerifiedURL::with(id: ..., createdAt: ..., domain: ..., status: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new VerifiedURL)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withDomain(...)
     *   ->withStatus(...)
     *   ->withURL(...)
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
     * @param Status|value-of<Status> $status
     * @param ApprovalType|value-of<ApprovalType>|null $approvalType
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        string $domain,
        Status|string $status,
        string $url,
        ApprovalType|string|null $approvalType = null,
        ?\DateTimeInterface $updatedAt = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['domain'] = $domain;
        $self['status'] = $status;
        $self['url'] = $url;

        null !== $approvalType && $self['approvalType'] = $approvalType;
        null !== $updatedAt && $self['updatedAt'] = $updatedAt;

        return $self;
    }

    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Domain extracted from the URL.
     */
    public function withDomain(string $domain): self
    {
        $self = clone $this;
        $self['domain'] = $domain;

        return $self;
    }

    /**
     * Status of a verified URL.
     *
     * @param Status|value-of<Status> $status
     */
    public function withStatus(Status|string $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

        return $self;
    }

    /**
     * The verified URL.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * How the URL was approved or rejected.
     *
     * @param ApprovalType|value-of<ApprovalType> $approvalType
     */
    public function withApprovalType(ApprovalType|string $approvalType): self
    {
        $self = clone $this;
        $self['approvalType'] = $approvalType;

        return $self;
    }

    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
