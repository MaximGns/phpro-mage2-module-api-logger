<?php

declare(strict_types=1);

namespace Phpro\APILogger\Service;

use Magento\Framework\App\Request\Http as HttpRequest;
use Phpro\APILogger\Config\SystemConfiguration;

class LogService
{
    /** @var SystemConfiguration */
    private $config;

    public function __construct(SystemConfiguration $configuration)
    {
        $this->config = $configuration;
    }

    /**
     * @param HttpRequest $request
     * @return bool
     */
    public function shouldLog(HttpRequest $request): bool
    {
        $filter = $this->config->getFilter();

        if (null === $filter) {
            return true;
        }

        $requestPath = $request->getRequestString();

        if (strpos($requestPath, $filter) !== false) {
            return $this->config->isFilterOnly();
        }

        return true;
    }
}
