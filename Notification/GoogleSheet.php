<?php

namespace Kanboard\Plugin\GoogleSheet\Notification;

use Kanboard\Core\Base;
use Kanboard\Core\Notification\NotificationInterface;
use Kanboard\Model\TaskModel;


define("APPSCRIPT_WEBHOOK","your_url");

class GoogleSheet extends Base implements NotificationInterface
{

/**
 * Sends eventData and eventName to Google Sheet via the specified app script webhook URL.
 *
 * @access public
 * @param  string    $appScriptUrl
 * @param  array     $eventData  
 * @param  array     $eventName
 */
public function notifyGoogleSheets($appScriptUrl, array $data, $eventName)
{
    if (empty($data) || empty($eventName)) {
        error_log("notifyGoogleSheets: Data or event name is empty.");
        return false;
    }
    $requestData = array(
        'eventData' => $data,
        'eventName' => $eventName
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $appScriptUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if($response === false) {
        error_log("notifyGoogleSheets: cURL error: " . curl_error($ch));
        curl_close($ch);
        return false;
    }
    curl_close($ch);
    
    $responseData = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("notifyGoogleSheets: Invalid JSON response.");
        return false;
    }

    error_log("notifyGoogleSheets: Response: " . print_r($responseData, true));
    return true;
}
    /**
     * Send notification to a user
     *
     * @access public
     * @param  array     $user
     * @param  string    $eventName
     * @param  array     $eventData
     */
    public function notifyUser(array $user, $eventName, array $eventData)
    {
        $webhook = $this->userMetadataModel->get($user['id'], 'rocketchat_webhook_url', $this->configModel->get('rocketchat_webhook_url'));
        $channel = $this->userMetadataModel->get($user['id'], 'rocketchat_webhook_channel');

        if (! empty($webhook)) {
            if ($eventName === TaskModel::EVENT_OVERDUE) {
                foreach ($eventData['tasks'] as $task) {
                    $project = $this->projectModel->getById($task['project_id']);
                    $eventData['task'] = $task;
                    $this->notifyGoogleSheets(APPSCRIPT_WEBHOOK,$eventData,$eventName);
                }
            } else {
                $project = $this->projectModel->getById($eventData['task']['project_id']);
                $this->notifyGoogleSheets(APPSCRIPT_WEBHOOK,$eventData,$eventName);
            }
        }
    }

    /**
     *Sends notifications to a project based on the specified event and event data.
     *
     * @access public
     * @param  array     $project
     * @param  string    $eventName
     * @param  array     $eventData
     */
    public function notifyProject(array $project, $eventName, array $eventData)
    {
        $webhook = $this->projectMetadataModel->get($project['id'], 'rocketchat_webhook_url');
        $channel = $this->projectMetadataModel->get($project['id'], 'rocketchat_webhook_channel');

        if (! empty($webhook)) {
            $this->notifyGoogleSheets(APPSCRIPT_WEBHOOK,$eventData,$eventName);
        }
    }
}
