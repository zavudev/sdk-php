<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Broadcasts\Broadcast;
use Zavudev\Broadcasts\BroadcastCancelResponse;
use Zavudev\Broadcasts\BroadcastChannel;
use Zavudev\Broadcasts\BroadcastGetResponse;
use Zavudev\Broadcasts\BroadcastMessageType;
use Zavudev\Broadcasts\BroadcastNewResponse;
use Zavudev\Broadcasts\BroadcastProgress;
use Zavudev\Broadcasts\BroadcastRescheduleResponse;
use Zavudev\Broadcasts\BroadcastSendResponse;
use Zavudev\Broadcasts\BroadcastUpdateResponse;
use Zavudev\Client;
use Zavudev\Core\Util;
use Zavudev\Cursor;

/**
 * @internal
 */
#[CoversNothing]
final class BroadcastsTest extends TestCase
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

        $result = $this->client->broadcasts->create(
            channel: BroadcastChannel::SMS,
            name: 'Black Friday Sale'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BroadcastNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->broadcasts->create(
            channel: BroadcastChannel::SMS,
            name: 'Black Friday Sale',
            content: [
                'filename' => 'filename',
                'mediaID' => 'mediaId',
                'mediaURL' => 'mediaUrl',
                'mimeType' => 'mimeType',
                'templateID' => 'templateId',
                'templateVariables' => ['foo' => 'string'],
            ],
            emailHTMLBody: 'emailHtmlBody',
            emailSubject: 'emailSubject',
            idempotencyKey: 'idempotencyKey',
            messageType: BroadcastMessageType::TEXT,
            metadata: ['foo' => 'string'],
            scheduledAt: new \DateTimeImmutable('2019-12-27T18:11:19.117Z'),
            senderID: 'senderId',
            text: 'Hi {{name}}, check out our Black Friday deals! Use code FRIDAY20 for 20% off.',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BroadcastNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->broadcasts->retrieve('broadcastId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BroadcastGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->broadcasts->update('broadcastId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BroadcastUpdateResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $page = $this->client->broadcasts->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Cursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(Broadcast::class, $item);
        }
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->broadcasts->delete('broadcastId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testCancel(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->broadcasts->cancel('broadcastId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BroadcastCancelResponse::class, $result);
    }

    #[Test]
    public function testProgress(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->broadcasts->progress('broadcastId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BroadcastProgress::class, $result);
    }

    #[Test]
    public function testReschedule(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->broadcasts->reschedule(
            'broadcastId',
            scheduledAt: new \DateTimeImmutable('2024-01-15T14:00:00Z')
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BroadcastRescheduleResponse::class, $result);
    }

    #[Test]
    public function testRescheduleWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->broadcasts->reschedule(
            'broadcastId',
            scheduledAt: new \DateTimeImmutable('2024-01-15T14:00:00Z')
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BroadcastRescheduleResponse::class, $result);
    }

    #[Test]
    public function testSend(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->broadcasts->send('broadcastId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(BroadcastSendResponse::class, $result);
    }
}
