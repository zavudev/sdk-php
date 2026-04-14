<?php

declare(strict_types=1);

namespace Zavudev\Invitations;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type InvitationShape from \Zavudev\Invitations\Invitation
 *
 * @phpstan-type InvitationNewResponseShape = array{
 *   invitation: Invitation|InvitationShape
 * }
 */
final class InvitationNewResponse implements BaseModel
{
    /** @use SdkModel<InvitationNewResponseShape> */
    use SdkModel;

    #[Required]
    public Invitation $invitation;

    /**
     * `new InvitationNewResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * InvitationNewResponse::with(invitation: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new InvitationNewResponse)->withInvitation(...)
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
     * @param Invitation|InvitationShape $invitation
     */
    public static function with(Invitation|array $invitation): self
    {
        $self = new self;

        $self['invitation'] = $invitation;

        return $self;
    }

    /**
     * @param Invitation|InvitationShape $invitation
     */
    public function withInvitation(Invitation|array $invitation): self
    {
        $self = clone $this;
        $self['invitation'] = $invitation;

        return $self;
    }
}
