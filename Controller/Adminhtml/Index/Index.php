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

        $this->curl->post($this->config->getAIApiUrl(), $this->getJsonRequest());

        $response = $this->json->unserialize($this->curl->getBody());

        return $this->resultJsonFactory->create()->setData($response);

    }

    /**
     * @return bool|string
     */
    public function getJsonRequest(): string|bool
    {
        $requestType = $this->getRequest()->getParam('request_type');
        $postName = $this->getRequest()->getParam('post_name');

        return $this->json->serialize(
            [
                'model' => 'gpt-3.5-turbo', // TODO configurable
                'messages' => [
                    [
                        'role' => 'user',
                        'content' =>
                            'write a ' . $requestType . ' about ' . $postName,
                    ],
                ],
            ],
        );
    }
}
