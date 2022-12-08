<?php

namespace YValiya\PageSpeed\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class OutputProcessorHelper extends AbstractHelper
{
    public function appendToHead(string $content, string &$html): string
    {
        $html = str_replace("</head>", $content . "</head>", $html);
        return $html;
    }
}