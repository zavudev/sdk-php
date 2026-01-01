<?php

declare(strict_types=1);

namespace Zavudev\Senders\Agent\Flows;

use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Create a copy of an existing flow with a new name.
 *
 * @see Zavudev\Services\Senders\Agent\FlowsService::duplicate()
 *
 * @phpstan-type FlowDuplicateParamsShape = array{
 *   senderID: string, newName: string
 * }
 */
final class FlowDuplicateParams implements BaseModel
{
    /** @use SdkModel<FlowDuplicateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $senderID;

    #[Required]
    public string $newName;

    /**
     * `new FlowDuplicateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * FlowDuplicateParams::with(senderID: ..., newName: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new FlowDuplicateParams)->withSenderID(...)->withNewName(...)
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
     */
    public static function with(string $senderID, string $newName): self
    {
        $self = new self;

        $self['senderID'] = $senderID;
        $self['newName'] = $newName;

        return $self;
    }

    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }

    public function withNewName(string $newName): self
    {
        $self = clone $this;
        $self['newName'] = $newName;

        return $self;
    }
}
