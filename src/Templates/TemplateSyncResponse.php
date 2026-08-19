<?php

declare(strict_types=1);

namespace Zavudev\Templates;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-type TemplateSyncResponseShape = array{
 *   accountsSynced: int,
 *   errors: list<string>,
 *   imported: int,
 *   linked: int,
 *   skipped: int,
 *   updated: int,
 * }
 */
final class TemplateSyncResponse implements BaseModel
{
    /** @use SdkModel<TemplateSyncResponseShape> */
    use SdkModel;

    /**
     * WhatsApp Business Accounts reconciled in this call.
     */
    #[Required]
    public int $accountsSynced;

    /**
     * Problems hit while syncing. Non-empty with a 200 means part of the sync did not complete — the rest still did.
     *
     * @var list<string> $errors
     */
    #[Required(list: 'string')]
    public array $errors;

    /**
     * Templates that existed on Meta and were created in Zavu by this call.
     */
    #[Required]
    public int $imported;

    /**
     * Existing Zavu templates that were matched to a Meta template by name and bound to its Meta ID.
     */
    #[Required]
    public int $linked;

    /**
     * Meta templates left alone: already linked to a Zavu template, or rejected/disabled on Meta.
     */
    #[Required]
    public int $skipped;

    /**
     * Templates whose approval status changed to match Meta.
     */
    #[Required]
    public int $updated;

    /**
     * `new TemplateSyncResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TemplateSyncResponse::with(
     *   accountsSynced: ...,
     *   errors: ...,
     *   imported: ...,
     *   linked: ...,
     *   skipped: ...,
     *   updated: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TemplateSyncResponse)
     *   ->withAccountsSynced(...)
     *   ->withErrors(...)
     *   ->withImported(...)
     *   ->withLinked(...)
     *   ->withSkipped(...)
     *   ->withUpdated(...)
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
     * @param list<string> $errors
     */
    public static function with(
        int $accountsSynced,
        array $errors,
        int $imported,
        int $linked,
        int $skipped,
        int $updated,
    ): self {
        $self = new self;

        $self['accountsSynced'] = $accountsSynced;
        $self['errors'] = $errors;
        $self['imported'] = $imported;
        $self['linked'] = $linked;
        $self['skipped'] = $skipped;
        $self['updated'] = $updated;

        return $self;
    }

    /**
     * WhatsApp Business Accounts reconciled in this call.
     */
    public function withAccountsSynced(int $accountsSynced): self
    {
        $self = clone $this;
        $self['accountsSynced'] = $accountsSynced;

        return $self;
    }

    /**
     * Problems hit while syncing. Non-empty with a 200 means part of the sync did not complete — the rest still did.
     *
     * @param list<string> $errors
     */
    public function withErrors(array $errors): self
    {
        $self = clone $this;
        $self['errors'] = $errors;

        return $self;
    }

    /**
     * Templates that existed on Meta and were created in Zavu by this call.
     */
    public function withImported(int $imported): self
    {
        $self = clone $this;
        $self['imported'] = $imported;

        return $self;
    }

    /**
     * Existing Zavu templates that were matched to a Meta template by name and bound to its Meta ID.
     */
    public function withLinked(int $linked): self
    {
        $self = clone $this;
        $self['linked'] = $linked;

        return $self;
    }

    /**
     * Meta templates left alone: already linked to a Zavu template, or rejected/disabled on Meta.
     */
    public function withSkipped(int $skipped): self
    {
        $self = clone $this;
        $self['skipped'] = $skipped;

        return $self;
    }

    /**
     * Templates whose approval status changed to match Meta.
     */
    public function withUpdated(int $updated): self
    {
        $self = clone $this;
        $self['updated'] = $updated;

        return $self;
    }
}
