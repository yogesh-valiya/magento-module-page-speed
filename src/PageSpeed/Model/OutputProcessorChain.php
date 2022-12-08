<?php

namespace YValiya\PageSpeed\Model;

use YValiya\PageSpeed\Api\OutputProcessorChainInterface;
use YValiya\PageSpeed\Api\OutputProcessorInterface;

class OutputProcessorChain implements OutputProcessorChainInterface
{
    const DEFAULT_SORT_ORDER = 999;

    private array $processors;

    public function __construct(
        array $processors = []
    )
    {
        $this->processors = $processors;
    }

    public function process(string &$output): bool
    {
        foreach ($this->processors as $processor) {
            if (($processor['processor'] ?? false) && (!$processor['processor'] instanceof OutputProcessorInterface)) {
                continue;
            }
            if (!$processor['processor']->process($output)) {
                return false;
            }
        }
        return true;
    }

    protected function getSortedProcessors(): array
    {
        $processes = $this->getProcessors();

        foreach ($processes as $key => $process) {
            if (!isset($process['processor'])) {
                unset($process[$key]);
            }
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
