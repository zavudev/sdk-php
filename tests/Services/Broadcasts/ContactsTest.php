<?php

namespace Tests\Services\Broadcasts;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Broadcasts\BroadcastContact;
use Zavudev\Broadcasts\Contacts\ContactAddResponse;
use Zavudev\Client;
use Zavudev\Core\Util;
use Zavudev\Cursor;

/**
 * @internal
 */
#[CoversNothing]
final class ContactsTest extends TestCase
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
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $page = $this->client->broadcasts->contacts->list('broadcastId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Cursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(BroadcastContact::class, $item);
        }
    }

    #[Test]
    public function testAdd(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->broadcasts->contacts->add(
            'broadcastId',
            contacts: [
                ['recipient' => '+14155551234'], ['recipient' => '+14155555678'],
            ],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ContactAddResponse::class, $result);
    }

    #[Test]
    public function testAddWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->broadcasts->contacts->add(
            'broadcastId',
            contacts: [
                [
                    'recipient' => '+14155551234',
                    'templateButtonVariables' => ['0' => 'abc-report-token'],
                    'templateVariables' => ['name' => 'John', 'order_id' => 'ORD-001'],
                ],
                [
                    'recipient' => '+14155555678',
                    'templateButtonVariables' => ['0' => 'abc-report-token'],
                    'templateVariables' => ['name' => 'Jane', 'order_id' => 'ORD-002'],
                ],
            ],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(ContactAddResponse::class, $result);
    }

    #[Test]
    public function testRemove(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->broadcasts->contacts->remove(
            'contactId',
            broadcastID: 'broadcastId'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testRemoveWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->broadcasts->contacts->remove(
            'contactId',
            broadcastID: 'broadcastId'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }
}
