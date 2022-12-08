<?php

namespace YValiya\PageSpeed\Model\Processor;

use YValiya\PageSpeed\Api\OutputProcessorInterface;

class ShouldBeHtml implements OutputProcessorInterface
{
    public function process(string &$output): bool
    {
        if (preg_match('/(<html[^>]*>)(?>.*?<body[^>]*>)/is', $output)
            && preg_match('/(<\/body[^>]*>)(?>.*?<\/html[^>]*>)$/is', $output)) {
            return true;
        }
        return false;
    }
}