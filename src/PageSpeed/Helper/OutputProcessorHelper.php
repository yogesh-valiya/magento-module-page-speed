<?php

namespace YValiya\PageSpeed\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Exception\LocalizedException;

class OutputProcessorHelper extends AbstractHelper
{
    public function appendToHead(string $content, string &$html): string
    {
        $html = str_replace("</head>", $content . "</head>", $html);
        return $html;
    }

    /**
     * @throws LocalizedException
     */
    public function prependToHead(string $content, string &$html): string
    {
        if (preg_match('/<head[^e][^<>]*>/', $html, $matches)) {
            $headText = $matches[0] ?? false;
            if ($headText) {
                $html = str_replace($headText, $headText . $content, $html);
            }
        } else if (preg_match('/<meta[^<>]*charset[^<>]*>/', $html, $matches)) {
            $charsetText = $matches[0] ?? false;
            if ($charsetText) {
                $html = str_replace($charsetText, $content . $charsetText, $html);
            }
        } else if (preg_match('/<meta[^<>]*name="title"[^<>]*>/', $html, $matches)) {
            $titleText = $matches[0] ?? false;
            if ($titleText) {
                $html = str_replace($titleText, $content . $titleText, $html);
            }
        } else {
            throw new LocalizedException(__("Failed to prepend content to head"));
        }
        return $html;
    }
}