<?php
declare(strict_types=1);

namespace Apedik\AiBlog\Block\Adminhtml\Post\Edit\Tab;

use Apedik\AiBlog\Model\Config as BlogConfig;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Model\Auth\Session;
use Magento\Cms\Model\Page\Source\PageLayout as BasePageLayout;
use Magento\Cms\Model\Wysiwyg\Config;
use Magento\Config\Model\Config\Source\Design\Robots;
use Magento\Config\Model\Config\Source\Yesno;
use Magento\Framework\{Data\FormFactory, Registry, Stdlib\DateTime\DateTime};
use Magento\Store\Model\System\Store;
use Mageplaza\Blog\{Block\Adminhtml\Post\Edit\Tab\Post as MagePlazaPost,
    Helper\Image,
    Model\Config\Source\Author,
    Model\Config\Source\AuthorStatus};


class Post extends MagePlazaPost
{
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
    }

    private const DESC_BUTTON = '<button class="primary" type="button" onclick="AIGenerateDesc();">AI Generate</button>';
    private const TITLE_BUTTON = '<button class="primary" type="button" onclick="AIGeneratePost();">AI Generate</button>';

    public function getConfig(): BlogConfig
    {
        return $this->config;
    }

    protected function _prepareForm(): void
    {
        $form = parent::_prepareForm();

        if ($this->config->canAiSupportEnabled() === false) {
            return;
        }

        $form
            ->getForm()
            ->getElement('meta_description')
            ?->setData(
                'after_element_html',
                self::DESC_BUTTON . $this->getAIGenerateDescScript(),
            );

        $form
            ->getForm()
            ->getElement('name')
            ?->setData(
                'after_element_html',
                self::TITLE_BUTTON . $this->getAIGeneratePostScript(),
            );
    }

    /**
     * Prepare form Html. call the phtm file with form.
     *
     * @return string
     */
    public function getFormHtml()
    {
        // get the current form as html content.
        $html = parent::getFormHtml();
        //Append the phtml file after the form content.
        $html .= $this->setTemplate('Apedik_AiBlog::post/edit/tab/post.phtml')->toHtml();
        return $html;
    }
}
