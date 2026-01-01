<?php

namespace Tests\Services\Senders;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Client;
use Zavudev\Senders\Agent\AgentProvider;
use Zavudev\Senders\Agent\AgentResponse;
use Zavudev\Senders\Agent\AgentStats;

/**
 * @internal
 */
#[CoversNothing]
final class AgentTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $testUrl = getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(apiKey: 'My API Key', baseUrl: $testUrl);

        $this->client = $client;
    }

    #[Test]
    public function testCreate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->agent->create(
            'senderId',
            model: 'gpt-4o-mini',
            name: 'Customer Support',
            provider: AgentProvider::OPENAI,
            systemPrompt: 'You are a helpful customer support agent. Be friendly and concise.',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AgentResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->agent->create(
            'senderId',
            model: 'gpt-4o-mini',
            name: 'Customer Support',
            provider: AgentProvider::OPENAI,
            systemPrompt: 'You are a helpful customer support agent. Be friendly and concise.',
            apiKey: 'sk-...',
            contextWindowMessages: 1,
            includeContactMetadata: true,
            maxTokens: 1,
            temperature: 0,
            triggerOnChannels: ['string'],
            triggerOnMessageTypes: ['string'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AgentResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->agent->retrieve('senderId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AgentResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->agent->update('senderId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AgentResponse::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->agent->delete('senderId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testStats(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->agent->stats('senderId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AgentStats::class, $result);
    }
}
