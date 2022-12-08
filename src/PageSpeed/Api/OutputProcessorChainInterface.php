<?php

namespace YValiya\PageSpeed\Api;

interface OutputProcessorChainInterface
{
    public function process(string &$output): bool;
}