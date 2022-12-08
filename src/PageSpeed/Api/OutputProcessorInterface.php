<?php

namespace YValiya\PageSpeed\Api;

interface OutputProcessorInterface
{
    public function process(string &$output): bool;
}