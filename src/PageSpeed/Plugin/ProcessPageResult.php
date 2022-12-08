<?php

namespace YValiya\PageSpeed\Plugin;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use YValiya\PageSpeed\Api\OutputProcessorChain;
use YValiya\PageSpeed\Api\OutputProcessorChainInterface;

class ProcessPageResult
{
    private OutputProcessorChainInterface $outputProcessorChain;

    public function __construct(
        OutputProcessorChainInterface $outputProcessorChain
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