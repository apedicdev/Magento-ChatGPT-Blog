<?php
declare(strict_types=1);

namespace Apedik\AiBlog\Block\Adminhtml\Post\Edit\Tab;

use Apedik\AiBlog\Model\Config as BlogConfig;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Model\Auth\Session;
use Magento\Backend\Model\UrlInterface;
use Magento\Cms\Model\Page\Source\PageLayout as BasePageLayout;
use Magento\Cms\Model\Wysiwyg\Config;
use Magento\Config\Model\Config\Source\Design\Robots;
use Magento\Config\Model\Config\Source\Yesno;
use Magento\Framework\{Data\FormFactory, Registry, Stdlib\DateTime\DateTime};
use Magento\Store\Model\System\Store;
use Mageplaza\Blog\{Block\Adminhtml\Post\Edit\Tab\Post as MagePlazaPost,
    Helper\Image,
    Model\Config\Source\Author,
    Model\Config\Source\AuthorStatus
};


class Post extends MagePlazaPost
{
    private Context $context;

    public function __construct(
        Context $context,
        Registry $registry,
        Session $authSession,
        DateTime $dateTime,
        BasePageLayout $layoutOption,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        Yesno $booleanOptions,
        Robots $metaRobotsOptions,
        Store $systemStore,
        Image $imageHelper,
        Author $author,
        AuthorStatus $status,
        private readonly BlogConfig $config,
        private readonly UrlInterface $backendUrl,
        array $data = [])
    {
        parent::__construct(
            $context,
            $registry,
            $authSession,
            $dateTime,
            $layoutOption,
            $formFactory,
            $wysiwygConfig,
            $booleanOptions,
            $metaRobotsOptions,
            $systemStore,
            $imageHelper,
            $author,
            $status,
            $data,
        );
        $this->context = $context;
    }

    public function getConfig(): BlogConfig
    {
        return $this->config;
    }

    public function getBackendUrl(): UrlInterface
    {
        return $this->backendUrl;
    }

    public function getContext(): Context
    {
        return $this->context;
    }

    public function getFormElement(Post|MagePlazaPost $form, string $element): void
    {
        $onclickElement = match ($element) {
            'meta_description' => 'Description',
            'name' => 'Post',
        };

        $form
            ->getForm()
            ->getElement($element)
            ?->setData(
                'after_element_html',
                "<button class=\"primary\" type=\"button\" onclick=\"AIGenerate{$onclickElement}()\">AI Generate</button>",
            );
    }


    protected function _prepareForm(): void
    {
        $form = parent::_prepareForm();

        if ($this->config->canAiSupportEnabled() === false) {
            return;
        }

        $this->getFormElement($form, 'meta_description');
        $this->getFormElement($form, 'name');
    }

    /**
     * Prepare form Html. call the phtml file with form.
     *
     * @return string
     */
    public function getFormHtml(): string
    {
        $html = parent::getFormHtml();
        $html .= $this->setTemplate('Apedik_AiBlog::post/edit/tab/post.phtml')->toHtml();
        return $html;
    }
}
