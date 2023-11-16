<?php
declare(strict_types=1);

namespace Apedik\AiBlog\Controller\Adminhtml\Index;

use Apedik\AiBlog\Model\Config;
use Magento\Framework\{App\Action\HttpPostActionInterface,
    App\ResponseInterface,
    Controller\Result\Json,
    Controller\Result\JsonFactory,
    Controller\ResultInterface,
    HTTP\Client\Curl,
    Serialize\Serializer\Json as JsonSerializer
};
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Index extends Action implements HttpPostActionInterface
{
    public function __construct(
        Context $context,
        private readonly JsonFactory $resultJsonFactory,
        private readonly Config $config,
        private readonly Curl $curl,
        private readonly JsonSerializer $json,
    ) {
        parent::__construct($context);
    }

    public function execute(): Json|ResultInterface|ResponseInterface
    {
        $this->curl->setHeaders(
            [
                'authorization' => 'Bearer ' . $this->config->getAIApiKey(),
                'content-type' => 'application/json',
            ],
        );

        $jsonRequest = $this->json->serialize(
            [
                'model' => $this->getRequest()->getParam('model'),
                'messages' => $this->getRequest()->getParam('messages'),
            ],
        );

        $this->curl->post($this->config->getAIApiUrl(), $jsonRequest);

        $response = $this->json->unserialize($this->curl->getBody());

        return $this->resultJsonFactory->create()->setData($response);

    }
}
