<?php

namespace Kanboard\Plugin\GoogleSheet;

use Kanboard\Core\Translator;
use Kanboard\Core\Plugin\Base;

class Plugin extends Base
{
    public function initialize()
    {
        $this->template->hook->attach('template:config:integrations', 'GoogleSheet:config/integration');
        $this->template->hook->attach('template:project:integrations', 'GoogleSheet:project/integration');
        $this->template->hook->attach('template:user:integrations', 'GoogleSheet:user/integration');

        $this->userNotificationTypeModel->setType('googlesheet', 'GoogleSheet', '\Kanboard\Plugin\GoogleSheet\Notification\GoogleSheet');
        $this->projectNotificationTypeModel->setType('googlesheet', 'GoogleSheet', '\Kanboard\Plugin\GoogleSheet\Notification\GoogleSheet');
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginDescription()
    {
        return t('Receive notifications on Google Sheet');
    }

    public function getPluginAuthor()
    {
        return 'Ahcene Dahmane';
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
