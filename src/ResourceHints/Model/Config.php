<?php

namespace YValiya\ResourceHints\Model;

class Config extends \YValiya\Core\Model\Config
{
    const XML_PATH_ENABLED = 'yvaliya_page_speed/resource_hints/enabled';
    const XML_PATH_DNS_PREFETCH_ENABLED = 'yvaliya_page_speed/resource_hints_dns_prefetch/enabled';
    const XML_PATH_DNS_PREFETCH_URLS = 'yvaliya_page_speed/resource_hints_dns_prefetch/urls';
}