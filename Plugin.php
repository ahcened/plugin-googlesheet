<?php

namespace Kanboard\Plugin\RocketChat;

use Kanboard\Core\Translator;
use Kanboard\Core\Plugin\Base;

/**
 * GoogleSheet Plugin
 *
 * @package  GoogleSheet
 * @author   
 * @author   
 * @contributor 
 * @contributor 
 */
class Plugin extends Base
{
    public function initialize()
    {
        $this->template->hook->attach('template:config:integrations', 'GoogleSheet:config/integration');
        $this->template->hook->attach('template:project:integrations', 'GoogleSheet:project/integration');
        $this->template->hook->attach('template:user:integrations', 'GoogleSheet:user/integration');

        $this->userNotificationTypeModel->setType('GoogleSheet', 'GoogleSheet', '\Kanboard\Plugin\RocketChat\Notification\RocketChat');
        $this->projectNotificationTypeModel->setType('GoogleSheet', 'GoogleSheet', '\Kanboard\Plugin\RocketChat\Notification\RocketChat');
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginDescription()
    {
        return t('Receive notifications on GoogleSheet');
    }

    public function getPluginAuthor()
    {
        return '';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/ahcened/plugin-googlesheet';
    }

    public function getCompatibleVersion()
    {
        return '>=1.0.37';
    }
}
