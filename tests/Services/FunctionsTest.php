<?php

namespace Tests\Services;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\UnsupportedMockTests;
use Zavudev\Client;
use Zavudev\Core\Util;
use Zavudev\Functions\FunctionDeleteResponse;
use Zavudev\Functions\FunctionDeployResponse;
use Zavudev\Functions\FunctionGetDeploymentResponse;
use Zavudev\Functions\FunctionGetResponse;
use Zavudev\Functions\FunctionNewResponse;
use Zavudev\Functions\FunctionTailLogsResponse;
use Zavudev\Functions\FunctionUpdateResponse;

/**
 * @internal
 */
#[CoversNothing]
final class FunctionsTest extends TestCase
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

        $result = $this->client->functions->create(
            name: 'Order Bot',
            slug: 'order-bot'
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FunctionNewResponse::class, $result);
    }

    #[Test]
    public function testCreateWithOptionalParams(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->functions->create(
            name: 'Order Bot',
            slug: 'order-bot',
            dependencies: ['openai' => '^4.20.0'],
            description: 'Replies to order status questions on WhatsApp.',
            httpEnabled: true,
            memoryMB: 128,
            runtime: 'nodejs24',
            sourceCode: "import { defineFunction } from '@zavu/functions';\n\nexport default defineFunction(async (event, ctx) => {\n  ctx.log('received', event.type);\n});\n",
            timeoutSec: 1,
        );

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FunctionNewResponse::class, $result);
    }

    #[Test]
    public function testRetrieve(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->functions->retrieve('functionId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FunctionGetResponse::class, $result);
    }

    #[Test]
    public function testUpdate(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->functions->update('functionId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FunctionUpdateResponse::class, $result);
    }

    #[Test]
    public function testDelete(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->functions->delete('functionId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FunctionDeleteResponse::class, $result);
    }

    #[Test]
    public function testDeploy(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->functions->deploy('functionId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FunctionDeployResponse::class, $result);
    }

    #[Test]
    public function testGetDeployment(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->functions->getDeployment('deploymentId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FunctionGetDeploymentResponse::class, $result);
    }

    #[Test]
    public function testTailLogs(): void
    {
        if (UnsupportedMockTests::$skip) {
            $this->markTestSkipped('Mock server tests are disabled');
        }

        $result = $this->client->functions->tailLogs('functionId');

        // @phpstan-ignore-next-line method.alreadyNarrowedType
        $this->assertInstanceOf(FunctionTailLogsResponse::class, $result);
    }
}
