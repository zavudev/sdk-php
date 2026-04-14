<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Client;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\Invitations\Invitation;
use Zavudev\Invitations\InvitationCancelResponse;
use Zavudev\Invitations\InvitationGetResponse;
use Zavudev\Invitations\InvitationNewResponse;

/**
 * @internal
 */
#[CoversNothing]
final class InvitationsTest extends TestCase
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

        $result = $this->client->invitations->create();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(InvitationNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->invitations->retrieve('invitationId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(InvitationGetResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $page = $this->client->invitations->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Cursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(Invitation::class, $item);
        }
    }

    #[Test]
    public function testCancel(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->invitations->cancel('invitationId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(InvitationCancelResponse::class, $result);
    }
}
