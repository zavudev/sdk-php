<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Calls\CallGetResponse;
use Zavudev\Calls\CallHangupResponse;
use Zavudev\Calls\CallListResponse;
use Zavudev\Calls\CallNewResponse;
use Zavudev\Client;
use Zavudev\Core\Util;
use Zavudev\Cursor;

/**
 * @internal
 */
#[CoversNothing]
final class CallsTest extends TestCase
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

        $result = $this->client->calls->create(to: '+56912345678');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CallNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->calls->create(
            to: '+56912345678',
            greeting: 'greeting',
            language: 'es-ES',
            maxDurationMinutes: 1,
            metadata: ['foo' => 'string'],
            senderID: 'sender_12345',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CallNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->calls->retrieve('callId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CallGetResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $page = $this->client->calls->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Cursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(CallListResponse::class, $item);
        }
    }

    #[Test]
    public function testHangup(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->calls->hangup('callId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(CallHangupResponse::class, $result);
    }
}
