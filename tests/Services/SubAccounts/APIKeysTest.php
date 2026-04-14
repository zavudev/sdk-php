<?php

namespace Tests\Services\SubAccounts;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Client;
use Zavudev\Core\Util;
use Zavudev\SubAccounts\APIKeys\APIKeyListResponse;
use Zavudev\SubAccounts\APIKeys\APIKeyNewResponse;

/**
 * @internal
 */
#[CoversNothing]
final class APIKeysTest extends TestCase
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

        $result = $this->client->subAccounts->apiKeys->create(
            'id',
            name: 'Production Key'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIKeyNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->subAccounts->apiKeys->create(
            'id',
            name: 'Production Key',
            environment: 'live',
            permissions: ['string']
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIKeyNewResponse::class, $result);
    }

    #[Test]
    public function testList(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->subAccounts->apiKeys->list('id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(APIKeyListResponse::class, $result);
    }

    #[Test]
    public function testRevoke(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->subAccounts->apiKeys->revoke('keyId', id: 'id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testRevokeWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->subAccounts->apiKeys->revoke('keyId', id: 'id');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }
}
