<?php

namespace YValiya\PageSpeed\Plugin;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use YValiya\PageSpeed\Api\OutputProcessorChain;

class ProcessPageResult
{
    private OutputProcessorChain $outputProcessorChain;

    public function __construct(
        OutputProcessorChain $outputProcessorChain
    )
    {
        $this->outputProcessorChain = $outputProcessorChain;
    }

    public function afterRenderResult(ResultInterface $subject, $result, ResponseInterface $response)
    {
        $output = $response->getBody();
        if ($this->outputProcessorChain->process($output)) {
            $response->setBody($output);
        }
        return $result;
    }
}