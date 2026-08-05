<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Tools\ToolTestResponse;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * One run of a tool triggered from the test endpoint. Recorded so a test is verifiable after the fact rather than only visible in the response.
 *
 * @phpstan-type RunShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   durationMs: int,
 *   success: bool,
 *   toolID: string,
 *   error?: string|null,
 *   params?: array<string,mixed>|null,
 *   response?: string|null,
 *   statusCode?: int|null,
 * }
 */
final class Run implements BaseModel
{
    /** @use SdkModel<RunShape> */
    use SdkModel;

    #[Required]
    public string $id;

    #[Required]
    public \DateTimeInterface $createdAt;

    #[Required]
    public int $durationMs;

    /**
     * Whether the tool returned without error. A tool that answered with a non-2xx status is a failed run, not an error of this endpoint.
     */
    #[Required]
    public bool $success;

    #[Required('toolId')]
    public string $toolID;

    /**
     * Why the run failed, when it did.
     */
    #[Optional(nullable: true)]
    public ?string $error;

    /**
     * The parameters the tool was called with.
     *
     * @var array<string,mixed>|null $params
     */
    #[Optional(map: 'mixed')]
    public ?array $params;

    /**
     * The tool's response body, truncated.
     */
    #[Optional(nullable: true)]
    public ?string $response;

    /**
     * HTTP status the tool's webhook returned. Absent for tools that do not go over HTTP.
     */
    #[Optional(nullable: true)]
    public ?int $statusCode;

    /**
     * `new Run()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Run::with(id: ..., createdAt: ..., durationMs: ..., success: ..., toolID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Run)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withDurationMs(...)
     *   ->withSuccess(...)
     *   ->withToolID(...)
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
     * @param array<string,mixed>|null $params
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        int $durationMs,
        bool $success,
        string $toolID,
        ?string $error = null,
        ?array $params = null,
        ?string $response = null,
        ?int $statusCode = null,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['durationMs'] = $durationMs;
        $self['success'] = $success;
        $self['toolID'] = $toolID;

        null !== $error && $self['error'] = $error;
        null !== $params && $self['params'] = $params;
        null !== $response && $self['response'] = $response;
        null !== $statusCode && $self['statusCode'] = $statusCode;

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

    public function withDurationMs(int $durationMs): self
    {
        $self = clone $this;
        $self['durationMs'] = $durationMs;

        return $self;
    }

    /**
     * Whether the tool returned without error. A tool that answered with a non-2xx status is a failed run, not an error of this endpoint.
     */
    public function withSuccess(bool $success): self
    {
        $self = clone $this;
        $self['success'] = $success;

        return $self;
    }

    public function withToolID(string $toolID): self
    {
        $self = clone $this;
        $self['toolID'] = $toolID;

        return $self;
    }

    /**
     * Why the run failed, when it did.
     */
    public function withError(?string $error): self
    {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    /**
     * The parameters the tool was called with.
     *
     * @param array<string,mixed> $params
     */
    public function withParams(array $params): self
    {
        $self = clone $this;
        $self['params'] = $params;

        return $self;
    }

    /**
     * The tool's response body, truncated.
     */
    public function withResponse(?string $response): self
    {
        $self = clone $this;
        $self['response'] = $response;

        return $self;
    }

    /**
     * HTTP status the tool's webhook returned. Absent for tools that do not go over HTTP.
     */
    public function withStatusCode(?int $statusCode): self
    {
        $self = clone $this;
        $self['statusCode'] = $statusCode;

        return $self;
    }
}
