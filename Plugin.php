<?php

namespace Kanboard\Plugin\plugin-googlesheet;

use Kanboard\Core\Translator;
use Kanboard\Core\Plugin\Base;

/**
 * RocketChat Plugin
 *
 * @package  plugin-googlesheet
 * @author   Frederic Guillot
 * @author   Olivier Maridat
 * @contributor Fabio Lucattini 
 * @contributor Jamie Owen
 */
class Plugin extends Base
{
    public function initialize()
    {
        $this->template->hook->attach('template:config:integrations', 'RocketChat:config/integration');
        $this->template->hook->attach('template:project:integrations', 'RocketChat:project/integration');
        $this->template->hook->attach('template:user:integrations', 'RocketChat:user/integration');

        $this->userNotificationTypeModel->setType('rocketchat', 'RocketChat', '\Kanboard\Plugin\RocketChat\Notification\RocketChat');
        $this->projectNotificationTypeModel->setType('rocketchat', 'RocketChat', '\Kanboard\Plugin\RocketChat\Notification\RocketChat');
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginDescription()
    {
        return t('Receive notifications on RocketChat');
    }

    public function getPluginAuthor()
    {
        return 'Frédéric Guillot & Olivier Maridat';
    }

    public function getPluginVersion()
    {
        return '1.0.10';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/plugin-rocketchat';
    }

    public function getCompatibleVersion()
    {
        return '>=1.0.37';
    }
}
