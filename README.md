# Magento ChatGPT Integration Module for Mageplaza Blog

## Overview

This Magento module extends the functionality of the Mageplaza Blog module by integrating ChatGPT for post and description generation. With this integration, you can enhance your blog posts by automatically generating relevant and engaging content using ChatGPT's natural language processing capabilities.

## Features

- Seamless integration with Mageplaza Blog module.
- Automatic generation of post content using ChatGPT.
- Enhanced post descriptions for improved SEO and user engagement.
- Customizable settings for ChatGPT integration.

## Requirements

- Magento 2.x
- Mageplaza Blog module installed and configured.

## Installation

   ```bash
   composer require apedik/module-ai-blog
   php bin/magento module:enable Apedik_AiBlog
   php bin/magento setup:upgrade
   php bin/magento setup:di:compile
   ```

Configure the settings in the Magento Admin Panel.

## Configuration

1. Log in to the Magento Admin Panel.
2. Navigate to `Stores > Configuration > Mageplaza > Better Blog > AI`.
3. Configure the following settings:
    - **Enable AI**: Enable or disable the ChatGPT integration.
    - **API Key**: Enter your ChatGPT API key. TODO encrypted
    - **API URL**: https://api.openai.com/v1/chat/completions TODO default
    - **Same short/meta description**: Use same content for short and meta description
    - **ChatGPT Language Model**: Select the desired ChatGPT language model. TODO
    - **Additional Configuration Options**: Configure any additional settings specific to your use case.

4. Click on the "Save Config" button.

## Usage

Once the module is installed and configured, two buttons will appear in the post edit form, located under the "Content" and "Meta Description" sections. Fill in the post name and then click these buttons to automatically generate the post and description based on the post title.

## Support and Issues

For any issues or questions regarding this module, please [open a new issue](https://github.com/apedicdev/Magento-ChatGPT-Blog/issues) on the GitHub repository.

## Contributing

We welcome contributions from the community. If you have any improvements or new features to suggest, please submit a pull request.

## TODO
- Post name validation before the requests
- Configurable models

## License

This module is licensed under the [MIT License](LICENSE). Feel free to use, modify, and distribute it as needed.
