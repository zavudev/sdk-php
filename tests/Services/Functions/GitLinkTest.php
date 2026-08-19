<?php

namespace Tests\Services\Functions;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Client;
use Zavudev\Core\Util;
use Zavudev\Functions\GitLink\GitLinkDeployNowResponse;
use Zavudev\Functions\GitLink\GitLinkGetResponse;
use Zavudev\Functions\GitLink\GitLinkLinkResponse;
use Zavudev\Functions\GitLink\GitLinkUpdateResponse;

/**
 * @internal
 */
#[CoversNothing]
final class GitLinkTest extends TestCase
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

        $result = $this->client->functions->gitLink->retrieve('functionId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(GitLinkGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->functions->gitLink->update('functionId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(GitLinkUpdateResponse::class, $result);
    }

    #[Test]
    public function testDeployNow(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->functions->gitLink->deployNow('functionId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(GitLinkDeployNowResponse::class, $result);
    }

    #[Test]
    public function testLink(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->functions->gitLink->link(
            'functionId',
            owner: 'acme',
            repo: 'order-bot'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(GitLinkLinkResponse::class, $result);
    }

    #[Test]
    public function testLinkWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->functions->gitLink->link(
            'functionId',
            owner: 'acme',
            repo: 'order-bot',
            autoDeploy: true,
            branch: 'main',
            rootDir: 'apps/bot',
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(GitLinkLinkResponse::class, $result);
    }

    #[Test]
    public function testUnlink(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->functions->gitLink->unlink('functionId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertNull($result);
    }
}
