<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Client;
use Zavudev\Core\Util;
use Zavudev\Cursor;
use Zavudev\URLs\URLGetDetailsResponse;
use Zavudev\URLs\URLSubmitForVerificationResponse;
use Zavudev\URLs\VerifiedURL;

/**
 * @internal
 */
#[CoversNothing]
final class URLsTest extends TestCase
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
    public function testListVerified(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $page = $this->client->urls->listVerified();

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(Cursor::class, $page);

        if ($item = $page->getItems()[0] ?? null) {
            // @phpstan-ignore-next-line method.alreadyNarrowedType
            $this->assertInstanceOf(VerifiedURL::class, $item);
        }
    }

    #[Test]
    public function testRetrieveDetails(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->urls->retrieveDetails('urlId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(URLGetDetailsResponse::class, $result);
    }

    #[Test]
    public function testSubmitForVerification(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->urls->submitForVerification(
            url: 'https://example.com/page'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(URLSubmitForVerificationResponse::class, $result);
    }

    #[Test]
    public function testSubmitForVerificationWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->urls->submitForVerification(
            url: 'https://example.com/page'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(URLSubmitForVerificationResponse::class, $result);
    }
}
