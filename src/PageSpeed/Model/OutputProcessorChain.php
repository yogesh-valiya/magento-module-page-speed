<?php

namespace YValiya\PageSpeed\Model;

use YValiya\PageSpeed\Api\OutputProcessorChain as OutputProcessorChainInterface;

class OutputProcessorChain implements OutputProcessorChainInterface
{
    private array $processors;
    const DEFAULT_SORT_ORDER = 999;

    public function __construct(
        array $processors = []
    )
    {
        $this->processors = $processors;
    }

    public function process(string &$output): bool
    {
        foreach ($this->processors as $processor) {
            if (!$processor->process($output)) {
                return false;
            }
        }
        return true;
    }

    protected function getSortedProcessors(): array
    {
        $processes = $this->getProcessors();

        foreach ($processes as $process) {
            if (!isset($process['sortOrder'])) {
                $process['sortOrder'] = self::DEFAULT_SORT_ORDER;
            }
        }

        usort($processes, function ($a, $b) {
            return $a['sortOrder'] <=> $b['sortOrder'];
        });

        return $processes;
    }

    protected function getProcessors(): array
    {
        return $this->processors;
    }

}
