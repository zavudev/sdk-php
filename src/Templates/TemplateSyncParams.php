<?php

declare(strict_types=1);

namespace Zavudev\Templates;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Reconcile this project's templates against WhatsApp. Two things happen per connected WhatsApp Business Account: templates that exist on Meta but not in Zavu are imported (or linked to an existing template with the same name), and the approval status of the templates Zavu already knows about is refreshed from Meta.
 *
 * This is what to call when a template was created outside Zavu — in Meta Business Manager, or by another tool — or when a `template.status_changed` webhook was missed and a template is stuck in `pending`. Status changes normally arrive by webhook; this endpoint is the recovery path and the only path for a template Zavu never created.
 *
 * Templates that Meta reports as rejected or disabled are not imported; they are counted in `skipped`. Existing local templates are matched first by Meta template ID, then by name.
 *
 * By default every sender in the project with a WhatsApp Business Account is synced. Pass `senderId` to sync only that sender's account. The call is synchronous — it waits for Meta and returns what changed — so it can take a few seconds per account. A failure on one account does not fail the request: it is reported in `errors` and the remaining accounts are still synced.
 *
 * @see Zavudev\Services\TemplatesService::sync()
 *
 * @phpstan-type TemplateSyncParamsShape = array{senderID?: string|null}
 */
final class TemplateSyncParams implements BaseModel
{
    /** @use SdkModel<TemplateSyncParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Sync only the WhatsApp Business Account attached to this sender. If omitted, every WhatsApp sender in the project is synced.
     */
    #[Optional('senderId')]
    public ?string $senderID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $senderID = null): self
    {
        $self = new self;

        null !== $senderID && $self['senderID'] = $senderID;

        return $self;
    }

    /**
     * Sync only the WhatsApp Business Account attached to this sender. If omitted, every WhatsApp sender in the project is synced.
     */
    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }
}
