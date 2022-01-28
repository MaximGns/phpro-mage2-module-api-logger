<?php

declare(strict_types=1);

namespace Phpro\APILogger\Test\Unit\Service;

use Phpro\APILogger\Config\SystemConfiguration;
use Phpro\APILogger\Service\LogService;
use PHPUnit\Framework\TestCase;
use Magento\Framework\App\Request\Http as HttpRequest;

class LogServiceTest extends TestCase
{
    /** @var LogService  */
    private $subject;
    /**
     * @var SystemConfiguration|\PHPUnit\Framework\MockObject\MockObject
     */
    private $configuration;

    protected function setUp(): void
    {
        $this->configuration = $this->createMock(SystemConfiguration::class);
        $this->subject = new LogService($this->configuration);
    }

    public function testShouldLogWhenFilterIsEmpty(): void
    {
        $request = $this->createMock(HttpRequest::class);
        $this->configuration->method('getFilter')->willReturn(null);
        $this->configuration->method('isFilterOnly')->willReturn(false);
        self::assertTrue($this->subject->shouldLog($request));
    }

    public function testShouldLogWhenFilterIsMatching(): void
    {
        $request = $this->createMock(HttpRequest::class);

        $request->method('getRequestString')
            ->willReturn('rest/store_us/V1/internal/guest-carts/iX5TGRFgal7n8bp3FkdDfkR2nokZrwwL');
        $this->configuration->method('getFilter')->willReturn('/internal/guest-carts/');
        $this->configuration->method('isFilterOnly')->willReturn(false);
        self::assertFalse($this->subject->shouldLog($request));
    }

    public function testShouldNotLogWhenFilterIsNotMatching(): void
    {
        $request = $this->createMock(HttpRequest::class);

        $request->method('getRequestString')
            ->willReturn('rest/store_us/V1/internal/guest-carts/iX5TGRFgal7n8bp3FkdDfkR2nokZrwwL');
        $this->configuration->method('getFilter')->willReturn('/no/match');
        $this->configuration->method('isFilterOnly')->willReturn(false);
        self::assertTrue($this->subject->shouldLog($request));
    }

    public function testFilterAndFilterMatching(): void
    {
        $request = $this->createMock(HttpRequest::class);

        $request->method('getRequestString')
            ->willReturn('rest/store_us/V1/internal/guest-carts/iX5TGRFgal7n8bp3FkdDfkR2nokZrwwL');
        $this->configuration->method('getFilter')->willReturn('/internal/guest-carts/');
        $this->configuration->method('isFilterOnly')->willReturn(true);
        self::assertTrue($this->subject->shouldLog($request));
    }
}
