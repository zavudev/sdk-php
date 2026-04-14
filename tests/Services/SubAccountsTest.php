<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Client;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\SubAccounts\SubAccount;
use Zavudev\SubAccounts\SubAccountDeactivateResponse;
use Zavudev\SubAccounts\SubAccountGetBalanceResponse;
use Zavudev\SubAccounts\SubAccountGetResponse;
use Zavudev\SubAccounts\SubAccountNewResponse;
use Zavudev\SubAccounts\SubAccountUpdateResponse;

/**
 * @internal
 */
#[CoversNothing]
final class SubAccountsTest extends TestCase
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

        $result = $this->client->subAccounts->create(name: 'Client ABC');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SubAccountNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->subAccounts->create(
            name: 'Client ABC',
            creditLimit: 0,
            externalID: 'externalId',
            metadata: ['foo' => 'bar'],
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SubAccountNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->subAccounts->retrieve('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SubAccountGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->subAccounts->update('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SubAccountUpdateResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $page = $this->client->subAccounts->list();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Cursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(SubAccount::class, $item);
        }
    }

    #[Test]
    public function testDeactivate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->subAccounts->deactivate('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SubAccountDeactivateResponse::class, $result);
    }

    #[Test]
    public function testGetBalance(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->subAccounts->getBalance('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SubAccountGetBalanceResponse::class, $result);
    }
}
