<?php
declare(strict_types=1);

namespace Apedik\AiBlog\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

readonly class Config
{
    private const BLOG_AI_SUPPORT_AI_ENABLED_PATH = 'blog/ai_support/enabled';
    private const BLOG_AI_SUPPORT_SAME_SHORT_META_DESCRIPTION_PATH = 'blog/ai_support/short_meta_description';
    private const BLOG_AI_SUPPORT_AI_KEY_PATH = 'blog/ai_support/ai_key';
    private const BLOG_AI_SUPPORT_AI_URL_PATH = 'blog/ai_support/ai_url';

    public function __construct(private ScopeConfigInterface $scopeConfig)
    {
    }

    public function isAiSupportEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::BLOG_AI_SUPPORT_AI_ENABLED_PATH);
    }

    public function useSameShortMetaDescription(): bool
    {
        return $this->scopeConfig->isSetFlag(self::BLOG_AI_SUPPORT_SAME_SHORT_META_DESCRIPTION_PATH);
    }

    public function getAIApiKey(): ?string
    {
        $apiKey = $this->scopeConfig->getValue(self::BLOG_AI_SUPPORT_AI_KEY_PATH);
        return empty($apiKey) === false ? $apiKey : null;
    }

    public function getAIApiUrl(): ?string
    {
        $apiUrl = $this->scopeConfig->getValue(self::BLOG_AI_SUPPORT_AI_URL_PATH);
        return empty($apiUrl) === false ? $apiUrl : null;
    }

    public function canAiSupportEnabled(): bool
    {
        return $this->isAiSupportEnabled() === true
            && empty($this->getAIApiUrl()) === false
            && empty($this->getAIApiKey()) === false;
    }
}
