<?php

declare(strict_types=1);

namespace Phpro\APILogger\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Phpro\LoggerHandler\Config\LogConfiguration;

class SystemConfiguration implements LogConfiguration
{
    const XML_LOG_FILE_NAME = 'system/api_log/file';
    const XML_LOG_LEVEL = 'system/api_log/level';
    const XML_ADD_SLASHES = 'system/api_log/add_slashes';
    const XML_FILTER = 'system/api_log/filter';
    const XML_FILTER_ONLY = 'system/api_log/filter_only';

    const LOG_DIR = 'var' . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR;

    /**
     * @var ScopeConfigInterface
     */
    private $config;

    public function __construct(ScopeConfigInterface $config)
    {
        $this->config = $config;
    }

    public function getLogFileName(): string
    {
        return self::LOG_DIR . $this->config->getValue(self::XML_LOG_FILE_NAME);
    }

    public function getLogLevel(): string
    {
        return $this->config->getValue(self::XML_LOG_LEVEL);
    }

    public function getAddSlashes(): bool
    {
        return $this->config->isSetFlag(self::XML_ADD_SLASHES);
    }

    public function getFilter(): ?string
    {
        return $this->config->getValue(self::XML_FILTER);
    }

    public function isFilterOnly(): bool
    {
        return $this->config->isSetFlag(self::XML_FILTER_ONLY);
    }
}
