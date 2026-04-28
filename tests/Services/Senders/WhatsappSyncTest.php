<?php

namespace Tests\Services\Senders;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Client;
use Zavudev\Core\Util;
use Zavudev\Senders\WhatsappSync\WhatsappSyncGetResponse;
use Zavudev\Senders\WhatsappSync\WhatsappSyncStartContactsSyncResponse;
use Zavudev\Senders\WhatsappSync\WhatsappSyncStartHistorySyncResponse;

/**
 * @internal
 */
#[CoversNothing]
final class WhatsappSyncTest extends TestCase
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
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->senders->whatsappSync->retrieve('senderId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(WhatsappSyncGetResponse::class, $result);
    }

    #[Test]
    public function testStartContactsSync(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->senders->whatsappSync->startContactsSync(
            'senderId'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            WhatsappSyncStartContactsSyncResponse::class,
            $result
        );
    }

    #[Test]
    public function testStartHistorySync(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->senders->whatsappSync->startHistorySync(
            'senderId'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(
            WhatsappSyncStartHistorySyncResponse::class,
            $result
        );
    }
}
