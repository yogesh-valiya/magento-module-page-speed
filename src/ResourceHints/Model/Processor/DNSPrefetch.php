<?php

namespace YValiya\ResourceHints\Model\Processor;

use YValiya\PageSpeed\Api\OutputProcessorInterface;
use YValiya\PageSpeed\Helper\OutputProcessorHelper;

class DNSPrefetch implements OutputProcessorInterface
{
    private OutputProcessorHelper $outputProcessorHelper;

    public function __construct(
        OutputProcessorHelper $outputProcessorHelper
    )
    {
        $this->outputProcessorHelper = $outputProcessorHelper;
    }

    public function process(string &$output): bool
    {
        $this->outputProcessorHelper->appendToHead('<meta name="title" content="Home page"/>', $output);
        return true;
    }
}