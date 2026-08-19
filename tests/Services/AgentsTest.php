<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Agents\AgentGetResponse;
use Zavudev\Agents\AgentListVoicesResponse;
use Zavudev\Agents\AgentNewResponse;
use Zavudev\Agents\AgentTestResponse;
use Zavudev\Agents\AgentUpdateResponse;
use Zavudev\Client;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\Senders\Agent\Agent;
use Zavudev\Senders\Agent\AgentProvider;

/**
 * @internal
 */
#[CoversNothing]
final class AgentsTest extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $testUrl = Util::getenv('TEST_API_BASE_URL') ?: 'http://127.0.0.1:4010';
        $client = new Client(apiKey: 'My API Key', baseUrl: $testUrl);

        $this->client = $client;
    }

    #[Test]
    public function testCreate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->agents->create(
            model: 'model',
            name: 'name',
            provider: AgentProvider::OPENAI,
            systemPrompt: 'systemPrompt',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AgentNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->agents->create(
            model: 'model',
            name: 'name',
            provider: AgentProvider::OPENAI,
            systemPrompt: 'systemPrompt',
            contextWindowMessages: 1,
            includeContactMetadata: true,
            maxTokens: 1,
            temperature: 0,
            triggerOnChannels: ['string'],
            triggerOnMessageTypes: ['string'],
            voice: [
                'enabled' => true,
                'greeting' => 'Hi, thanks for calling Acme. How can I help you today?',
                'greetings' => ['es' => 'Hola, soy Atlas. Preguntame lo que quieras.'],
                'interruptible' => true,
                'language' => 'en',
                'maxCallDurationMinutes' => 1,
                'maxIdleSeconds' => 5,
                'model' => 'openai/gpt-4o',
                'recordCalls' => true,
                'sttModel' => 'sttModel',
                'sttProvider' => 'sttProvider',
                'transferPhoneNumber' => '+14155551234',
                'ttsProvider' => 'ttsProvider',
                'ttsVoiceID' => 'aria',
                'voicemailAction' => 'hangup',
                'voicemailMessage' => 'voicemailMessage',
                'voiceSpeed' => 0.5,
            ],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AgentNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->agents->retrieve('agentId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AgentGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->agents->update('agentId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AgentUpdateResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $page = $this->client->agents->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Cursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(Agent::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->agents->delete('agentId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testListVoices(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->agents->listVoices();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AgentListVoicesResponse::class, $result);
    }

    #[Test]
    public function testTest(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->agents->test(
            'agentId',
            message: 'Where is order ORD-12345?'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AgentTestResponse::class, $result);
    }

    #[Test]
    public function testTestWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->agents->test(
            'agentId',
            message: 'Where is order ORD-12345?',
            executeTools: true,
            history: [['content' => 'content', 'role' => 'user']],
            useKnowledgeBase: true,
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(AgentTestResponse::class, $result);
    }
}
