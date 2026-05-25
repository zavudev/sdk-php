<?php

namespace Tests\Services\Functions;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Client;
use Zavudev\Core\Util;
use Zavudev\Functions\Secrets\SecretListResponse;

/**
 * @internal
 */
#[CoversNothing]
final class SecretsTest extends TestCase
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

        $result = $this->client->functions->secrets->list('functionId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(SecretListResponse::class, $result);
    }

    #[Test]
    public function testSet(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->functions->secrets->set(
            'key',
            functionID: 'functionId',
            value: 'value'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertIsNotResource($result);
    }

    #[Test]
    public function testSetWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->functions->secrets->set(
            'key',
            functionID: 'functionId',
            value: 'value'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertIsNotResource($result);
    }

    #[Test]
    public function testUnset(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->functions->secrets->unset(
            'key',
            functionID: 'functionId'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }

    #[Test]
    public function testUnsetWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->functions->secrets->unset(
            'key',
            functionID: 'functionId'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }
}
