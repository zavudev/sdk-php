<?php

namespace Tests\Services\Senders\Agent;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Client;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\Senders\Agent\Flows\AgentFlow;
use Zavudev\Senders\Agent\Flows\FlowDuplicateResponse;
use Zavudev\Senders\Agent\Flows\FlowGetResponse;
use Zavudev\Senders\Agent\Flows\FlowNewResponse;
use Zavudev\Senders\Agent\Flows\FlowUpdateResponse;

/**
 * @internal
 */
#[CoversNothing]
final class FlowsTest extends TestCase
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
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->agent->flows->create(
            'senderId',
            name: 'Lead Capture',
            steps: [
                ['id' => 'welcome', 'config' => ['text' => 'bar'], 'type' => 'message'],
                [
                    'id' => 'ask_name',
                    'config' => ['variable' => 'bar', 'prompt' => 'bar'],
                    'type' => 'collect',
                ],
            ],
            trigger: ['type' => 'keyword'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FlowNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->agent->flows->create(
            'senderId',
            name: 'Lead Capture',
            steps: [
                [
                    'id' => 'welcome',
                    'config' => ['text' => 'bar'],
                    'type' => 'message',
                    'nextStepID' => 'ask_name',
                ],
                [
                    'id' => 'ask_name',
                    'config' => ['variable' => 'bar', 'prompt' => 'bar'],
                    'type' => 'collect',
                    'nextStepID' => 'nextStepId',
                ],
            ],
            trigger: [
                'type' => 'keyword',
                'intent' => 'intent',
                'keywords' => ['info', 'pricing', 'demo'],
            ],
            description: 'Capture lead information',
            enabled: true,
            priority: 0,
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FlowNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->agent->flows->retrieve(
            'flowId',
            senderID: 'senderId'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FlowGetResponse::class, $result);
    }

    #[Test]
    public function testRetrieveWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->agent->flows->retrieve(
            'flowId',
            senderID: 'senderId'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FlowGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->agent->flows->update(
            'flowId',
            senderID: 'senderId'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FlowUpdateResponse::class, $result);
    }

    #[Test]
    public function testUpdateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->agent->flows->update(
            'flowId',
            senderID: 'senderId',
            description: 'description',
            enabled: true,
            name: 'name',
            priority: 0,
            steps: [
                [
                    'id' => 'id',
                    'config' => ['foo' => 'bar'],
                    'type' => 'message',
                    'nextStepID' => 'nextStepId',
                ],
            ],
            trigger: [
                'type' => 'keyword', 'intent' => 'intent', 'keywords' => ['string'],
            ],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FlowUpdateResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $page = $this->client->senders->agent->flows->list('senderId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Cursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(AgentFlow::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->agent->flows->delete(
            'flowId',
            senderID: 'senderId'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testDeleteWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->agent->flows->delete(
            'flowId',
            senderID: 'senderId'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testDuplicate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->agent->flows->duplicate(
            'flowId',
            senderID: 'senderId',
            newName: 'Lead Capture (Copy)'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FlowDuplicateResponse::class, $result);
    }

    #[Test]
    public function testDuplicateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Prism tests are disabled');
        }

        $result = $this->client->senders->agent->flows->duplicate(
            'flowId',
            senderID: 'senderId',
            newName: 'Lead Capture (Copy)'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FlowDuplicateResponse::class, $result);
    }
}
