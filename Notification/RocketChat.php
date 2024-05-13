<?php

namespace Kanboard\Plugin\RocketChat\Notification;

use Kanboard\Core\Base;
use Kanboard\Core\Notification\NotificationInterface;
use Kanboard\Model\TaskModel;

defined('PLUGIN_RC_MAX_MSG_SIZE') or define('PLUGIN_RC_MAX_MSG_SIZE', 1000);

/**
 * Google Sheet Notification
 *
 * @package  notification
 * @author   Frederic Guillot
 */
define("APPSCRIPT_WEBHOOK",
"https://script.google.com/macros/s/AKfycbxvKmLOByLjz4ZpWViGKzvkCOVHoPtCyNUQFiANo9QiMd3ISd9qRvnxbuzx5VDgnPva/exec");
class GoogleSheet extends Base implements NotificationInterface
{

/**
 * Sends notifications to Google Sheets via the specified app script URL.
 *
 * @access public
 * @param  string    $appScriptUrl
 * @param  array     $data
 */
public function notifyGoogleSheets($appScriptUrl, array $data, $eventName)
{
    if (empty($data) || empty($eventName)) {
        return false;
    }

    // Combiner les données et le nom de l'événement dans un seul tableau
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
    curl_close($ch);
    if($response === false) {
        return false;
    }
    else{
        return true;
    }
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

//     /**
//      *Constructs the message to be sent as a notification based on the project, event, and event data.
//      *
//      * @access public
//      * @param  array     $project
//      * @param  string    $eventName
//      * @param  array     $eventData
//      * @return array
//      */
//     public function getMessage(array $project, $eventName, array $eventData)
//     {
//         $title = '['.$project['name'].'] #'.$eventData['task']['id'].' '.$eventData['task']['title'];
        
//         if ($this->userSession->isLogged()) {
//             $author = $this->helper->user->getFullname();
//             $message = $this->notificationModel->getTitleWithAuthor($author, $eventName, $eventData);
//         } else {
//             $message = $this->notificationModel->getTitleWithoutAuthor($eventName, $eventData);
//         }
//         if ($this->configModel->get('application_url') !== '') {
//             $url = $this->helper->url->to('TaskViewController', 'show', array('task_id' => $eventData['task']['id'], 'project_id' => $project['id']), '', true);
//             $message = preg_replace('/(?:#|n°)(\d+)( |$)/', '[#$1]('.$url.')$2', $message);
//         }

//         // https://rocket.chat/docs/developer-guides/rest-api/chat/postmessage/#attachments-detail
//         $additionalContents = array();
//         if (isset($eventData['comment']) && $eventName != 'comment.delete') {
//             $additionalContents[] = array("title" => t('Comment'), "value" => mb_strimwidth($eventData['comment']['comment'], 0, PLUGIN_RC_MAX_MSG_SIZE, "..."));
//         }
//         else if (isset($eventData['subtask'])) {
//             $additionalContents[] = array("title" => t('Subtask'), "value" => "[".$eventData['subtask']['status_name']."] ".$eventData['subtask']['title']);
//         }
//         else if (isset($eventData['task'])
//                   && $eventName != 'task.move.column'
//                   && $eventName != 'task.move.position'
//                   && $eventName != 'task.close'
//                   && $eventName != 'task_internal_link.create_update'
//                   && $eventName != 'task_internal_link.delete'
//                   && $eventName != 'task.file.create'
//                   && $eventName != 'comment.delete') {
//             if (isset($eventData['task']['assignee_username'])) {
//                 $additionalContents[] = array("title" => t('Assignee:'), "value" => $eventData['task']['assignee_username']);
//             }
//             if (isset($eventData['task']['date_started']) && 0 != $eventData['task']['date_started']) {
//                 $additionalContents[] = array("title" => t('Started:'), "value" => date('Y-m-d', $eventData['task']['date_started']));
//             }
//             if (isset($eventData['task']['date_due']) && 0 != $eventData['task']['date_due']) {
//                 $additionalContents[] = array("title" => t('Due date:'), "value" => date('Y-m-d', $eventData['task']['date_due']));
//             }
//             if (isset($eventData['task']['description']) && !empty($eventData['task']['description'])) {
//                 $additionalContents[] = array("title" => t('Description'), "value" => mb_strimwidth($eventData['task']['description'], 0, PLUGIN_RC_MAX_MSG_SIZE, "..."));
//             }
//         }

//         return array(
//             'username' => 'Kanboard',
//             'icon_url' => 'https://kanboard.org/assets/img/favicon.png',
//             'attachments' => array(
//                     array(
//                         'title' => $title,
//                         'text' => $message,
//                         'fields' => $additionalContents,
//                         'color' => $eventData['task']['color_id']
//                     )
//             )
//         );
//     }

//     /**
//      *  Sends the constructed message to RocketChat via a webhook
//      *
//      * @access private
//      * @param  string    $webhook
//      * @param  string    $channel
//      * @param  array     $project
//      * @param  string    $eventName
//      * @param  array     $eventData
//      */
//     protected function sendMessage($webhook, $channel, array $project, $eventName, array $eventData)
//     {
//         $payload = $this->getMessage($project, $eventName, $eventData);
//         if (! empty($channel)) {
//           $payload['channel'] = $channel;
//         }

//         $this->httpClient->postJsonAsync($webhook, $payload);
//     }
// }
