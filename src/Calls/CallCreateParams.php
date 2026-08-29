<?php

declare(strict_types=1);

namespace Zavudev\Calls;

use Zavudev\Core\Attributes\Optional;
use Zavudev\Core\Attributes\Required;
use Zavudev\Core\Concerns\SdkModel;
use Zavudev\Core\Concerns\SdkParams;
use Zavudev\Core\Contracts\BaseModel;

/**
 * Place an outbound voice call answered by the voice agent configured on the sender. Zavu dials the recipient and runs the conversation through its managed voice pipeline (speech recognition, the agent's LLM, and speech synthesis, with real-time interruption handling).
 *
 * **Requirements:**
 * - The Voice Agents feature must be enabled for your team (otherwise `403`).
 * - An account that has verified nothing may only call the phone numbers the project has verified (`403` with code `destination_not_verified`, and `details.verifiedNumbers` lists them), and at most 5 calls a day (`429` with code `daily_limit_exceeded`). A number is verified from the dashboard's Sandbox screen by sending the pre-filled WhatsApp message from that phone; the same verification covers SMS and calls. Verify your identity, add a payment method, settle a deposit or subscribe to call any destination. That raises the ceiling to 50 calls a day on Free; paid plans have no daily call ceiling. Full reference: https://docs.zavu.dev/concepts/sending-limits
 * - The sender's agent must have `voice.enabled` set to `true`.
 * - Not available with test-mode API keys.
 *
 * **Billing:** Voice calls are billed per minute of connected time plus telephony, deducted from your prepaid balance. A short-duration estimate is reserved when the call is placed; you are charged for the actual duration when the call ends.
 *
 * @see Zavudev\Services\CallsService::create()
 *
 * @phpstan-type CallCreateParamsShape = array{
 *   to: string,
 *   greeting?: string|null,
 *   language?: string|null,
 *   maxDurationMinutes?: int|null,
 *   metadata?: array<string,string>|null,
 *   senderID?: string|null,
 * }
 */
final class CallCreateParams implements BaseModel
{
    /** @use SdkModel<CallCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Recipient phone number in E.164 format.
     */
    #[Required]
    public string $to;

    /**
     * Overrides the agent's configured greeting for this call only.
     */
    #[Optional]
    public ?string $greeting;

    /**
     * Language the agent speaks on this call only, as a BCP-47 tag (`en`, `es`, `es-ES`, `pt-BR`), or `auto` to detect the caller's language and follow it. Overrides the agent's configured language for speech recognition, the agent's replies, and the synthesized voice. If the agent uses a custom voice you supplied, that voice is kept and only the language changes. When omitted, the agent's configured language is used.
     */
    #[Optional]
    public ?string $language;

    /**
     * Overrides the agent's maximum call duration for this call only.
     */
    #[Optional]
    public ?int $maxDurationMinutes;

    /**
     * Arbitrary metadata to associate with the call. Returned on the call object and included in voice webhooks.
     *
     * @var array<string,string>|null $metadata
     */
    #[Optional(map: 'string')]
    public ?array $metadata;

    /**
     * Sender profile that places the call. Uses the project's default sender if omitted. The sender's agent must have voice enabled.
     */
    #[Optional('senderId')]
    public ?string $senderID;

    /**
     * `new CallCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CallCreateParams::with(to: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CallCreateParams)->withTo(...)
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
     * @param array<string,string>|null $metadata
     */
    public static function with(
        string $to,
        ?string $greeting = null,
        ?string $language = null,
        ?int $maxDurationMinutes = null,
        ?array $metadata = null,
        ?string $senderID = null,
    ): self {
        $self = new self;

        $self['to'] = $to;

        null !== $greeting && $self['greeting'] = $greeting;
        null !== $language && $self['language'] = $language;
        null !== $maxDurationMinutes && $self['maxDurationMinutes'] = $maxDurationMinutes;
        null !== $metadata && $self['metadata'] = $metadata;
        null !== $senderID && $self['senderID'] = $senderID;

        return $self;
    }

    /**
     * Recipient phone number in E.164 format.
     */
    public function withTo(string $to): self
    {
        $self = clone $this;
        $self['to'] = $to;

        return $self;
    }

    /**
     * Overrides the agent's configured greeting for this call only.
     */
    public function withGreeting(string $greeting): self
    {
        $self = clone $this;
        $self['greeting'] = $greeting;

        return $self;
    }

    /**
     * Language the agent speaks on this call only, as a BCP-47 tag (`en`, `es`, `es-ES`, `pt-BR`), or `auto` to detect the caller's language and follow it. Overrides the agent's configured language for speech recognition, the agent's replies, and the synthesized voice. If the agent uses a custom voice you supplied, that voice is kept and only the language changes. When omitted, the agent's configured language is used.
     */
    public function withLanguage(string $language): self
    {
        $self = clone $this;
        $self['language'] = $language;

        return $self;
    }

    /**
     * Overrides the agent's maximum call duration for this call only.
     */
    public function withMaxDurationMinutes(int $maxDurationMinutes): self
    {
        $self = clone $this;
        $self['maxDurationMinutes'] = $maxDurationMinutes;

        return $self;
    }

    /**
     * Arbitrary metadata to associate with the call. Returned on the call object and included in voice webhooks.
     *
     * @param array<string,string> $metadata
     */
    public function withMetadata(array $metadata): self
    {
        $self = clone $this;
        $self['metadata'] = $metadata;

        return $self;
    }

    /**
     * Sender profile that places the call. Uses the project's default sender if omitted. The sender's agent must have voice enabled.
     */
    public function withSenderID(string $senderID): self
    {
        $self = clone $this;
        $self['senderID'] = $senderID;

        return $self;
    }
}
