<?php

namespace YValiya\ResourceHints\Model\Processor;

use Magento\Framework\Exception\LocalizedException;
use YValiya\PageSpeed\Api\OutputProcessorInterface;
use YValiya\PageSpeed\Helper\OutputProcessorHelper;
use YValiya\ResourceHints\Model\Config;

class DNSPrefetch implements OutputProcessorInterface
{
    private OutputProcessorHelper $outputProcessorHelper;
    private Config $config;
    private \YValiya\Core\Helper\UtilsHelper $utilsHelper;

    public function __construct(
        \YValiya\Core\Helper\UtilsHelper $utilsHelper,
        Config                           $config,
        OutputProcessorHelper            $outputProcessorHelper
    )
    {
        $this->outputProcessorHelper = $outputProcessorHelper;
        $this->config = $config;
        $this->utilsHelper = $utilsHelper;
    }

    public function process(string &$output): bool
    {
        if ($this->isEnabled()) {
            try {
                $this->outputProcessorHelper->prependToHead($this->getHtml(), $output);
            } catch (LocalizedException) {
                $this->outputProcessorHelper->appendToHead($this->getHtml(), $output);
            }
        }
        return true;
    }

    protected function getHtml(): string
    {
        $html = '';
        foreach ($this->getUrls() as $url) {
            $html .= "<link rel=\"dns-prefetch\" href=\"{$url}\">" . PHP_EOL;
        }
        return $html;
    }

    protected function getUrls(): array
    {
        $urls = $this->config->getValue(Config::XML_PATH_DNS_PREFETCH_URLS);
        $urls = preg_split("/\r\n|\n|\r/", $urls);
        foreach ($urls as $key => &$value) {
            if (filter_var($value, FILTER_VALIDATE_URL) === false) {
                unset($urls[$key]);
            }
            $value = $this->utilsHelper->parseDomainFromURL($value);
        }
        return array_unique($urls);
    }

    protected function isEnabled(): bool
    {
        return $this->config->isSetFlag(\YValiya\PageSpeed\Model\Config::XML_PATH_ENABLED) &&
            $this->config->isSetFlag(Config::XML_PATH_ENABLED) &&
            $this->config->isSetFlag(Config::XML_PATH_DNS_PREFETCH_ENABLED);
    }
}