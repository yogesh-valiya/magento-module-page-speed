<?php

namespace YValiya\PageSpeed\Api;

interface OutputProcessorChain
{
    public function process(string &$output): bool;
}