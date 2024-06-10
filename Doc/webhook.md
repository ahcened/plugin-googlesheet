# GoogleSheet Plugin for Kanboard

Receive Kanboard notifications on [Google Sheets](https://github.com/ahcened/plugin-googlesheet).

## Author
- Ahcene Dahmane
- License: MIT

## Requirements
- Kanboard >= 1.0.37
- Google Sheets

## Notification System

The Google App Script code captures events from Kanboard. The structure handling these events includes the event data object and the event name object. Understanding which events are sent by Kanboard is crucial before using the event data. The event name helps to understand the action taken, aiding in logging and debugging.

All internal events of Kanboard can be sent to an external URL.
* The web hook URL has to be defined in Settings > Webhooks > Webhook URL
* When an event is triggered Kanboard calls the pre-defined URL automatically
* The data are encoded in JSON format and sent with a POST HTTP request
* The web hook token is also sent as a query string parameter, so you can check if the request really comes from Kanboard.

### Event Name

The event name is the identifier of the event sent by Kanboard to the Google Sheet. The following events are currently supported:

- `comment.create`: Triggered when a new comment is added to a task.
- `comment.update`: Triggered when a comment is modified/updated in a task.
- `comment.delete`: Triggered when a comment is deleted from a task.
- `file.create`: Triggered when a new file is uploaded to a task.
- `task.move.project`: Triggered when a task is moved to a different project.
- `task.move.column`: Triggered when a task status changes (e.g., from "current" to "finished").
- `task.move.position`: Triggered when a task position is changed.
- `task.move.swimlane`: Triggered when a task is dragged and dropped from one swimlane to another.
- `task.update`: Triggered when task data is updated (e.g., start date, priority).
- `task.create`: Triggered when a new task is created within a project.
- `task.close`: Triggered when a task is closed.
- `task.open`: Triggered when a closed task is reopened.
- `task.assignee_change`: Triggered when the task's assignee is changed.
- `subtask.update`: Triggered when a subtask within a task is updated.
- `subtask.create`: Triggered when a new subtask is created within a task.
- `subtask.delete`: Triggered when a subtask is deleted from a task.
- `task_internal_link.create_update`: Triggered when a link is added to a task.
- `task_internal_link.delete`: Triggered when a link is deleted from a task.

### Event Data

Event data is the information sent to the Google App Script application. This data needs to be processed for specific actions. The structure of event data is generally consistent, with variations depending on the event name. Key fields in event data include:

- `task_id`: The ID of the task (int)
- `task`: The task object, which includes:
  - `id`: Task ID
  - `reference`: Reference (if any)
  - `title`: Task title
  - `description`: Task description
  - `date_creation`: Task creation date (in ms)
  - `date_completed`: Task completion date
  - `date_modification`: Last modification date
  - `date_due`: Task deadline
  - `date_started`: Task start date
  - `time_estimated`: Estimated time to complete the task (hours)
  - `time_spent`: Actual time spent on the task
  - `color_id`: Task color (e.g., "yellow")
  - `project_id`: Project ID
  - `column_id`: Task position by column (starting from 0)
  - `owner_id`: Task owner ID
  - `creator_id`: Task creator ID
  - `position`: Task column number
  - `is_active`: Task active status
  - `score`: Task score value
  - `category_id`: Task category ID
  - `priority`: Task priority level
  - `swimlane_id`: Task swimlane ID
  - `date_moved`: Date when the task status changed
  - `recurrence_status`: Recurrence status
  - `recurrence_trigger`: Recurrence trigger
  - `recurrence_factor`: Recurrence factor
  - `recurrence_timeframe`: Recurrence timeframe
  - `recurrence_basedate`: Recurrence base date
  - `recurrence_parent`: Recurrence parent task
  - `recurrence_child`: Recurrence child task
  - `category_name`: Task category name
  - `swimlane_name`: Swimlane name
  - `project_name`: Project name
  - `default_swimlane`: Default swimlane name
  - `column_title`: Task status
  - `assignee_name`: Task assignee
  - `creator_username`: Task creator's username
  - `creator_name`: Task creator's name

All event payloads follow this format:
```json
{
  "event_name": "model.event_name",
  "event_data": {
    "key1": "value1",
    "key2": "value2"
  }
}
```

### Examples of event payloads
- `Task creation ` 
```json
{
    "event_name": "task.create",
    "event_data": {
        "task_id": 5,
        "task": {
            "id": "5",
            "reference": "",
            "title": "My new task",
            "description": "",
            "date_creation": "1469315481",
            "date_completed": null,
            "date_modification": "1469315481",
            "date_due": "0",
            "date_started": "0",
            "time_estimated": "0",
            "time_spent": "0",
            "color_id": "orange",
            "project_id": "1",
            "column_id": "2",
            "owner_id": "1",
            "creator_id": "1",
            "position": "1",
            "is_active": "1",
            "score": "3",
            "category_id": "0",
            "priority": "2",
            "swimlane_id": "0",
            "date_moved": "1469315481",
            "recurrence_status": "0",
            "recurrence_trigger": "0",
            "recurrence_factor": "0",
            "recurrence_timeframe": "0",
            "recurrence_basedate": "0",
            "recurrence_parent": null,
            "recurrence_child": null,
            "category_name": null,
            "swimlane_name": null,
            "project_name": "Demo Project",
            "default_swimlane": "Default swimlane",
            "column_title": "Ready",
            "assignee_username": "admin",
            "assignee_name": null,
            "creator_username": "admin",
            "creator_name": null
        }
    }
}
```
- `Task modification `
```json
{
    "event_name": "task.update",
    "event_data": {
        "task_id": "5",
        "task": {
            "id": "5",
            "reference": "",
            "title": "My new task",
            "description": "New description",
            "date_creation": "1469315481",
            "date_completed": null,
            "date_modification": "1469315531",
            "date_due": "1469836800",
            "date_started": "0",
            "time_estimated": "0",
            "time_spent": "0",
            "color_id": "purple",
            "project_id": "1",
            "column_id": "2",
            "owner_id": "1",
            "creator_id": "1",
            "position": "1",
            "is_active": "1",
            "score": "3",
            "category_id": "0",
            "priority": "2",
            "swimlane_id": "0",
            "date_moved": "1469315481",
            "recurrence_status": "0",
            "recurrence_trigger": "0",
            "recurrence_factor": "0",
            "recurrence_timeframe": "0",
            "recurrence_basedate": "0",
            "recurrence_parent": null,
            "recurrence_child": null,
            "category_name": null,
            "swimlane_name": null,
            "project_name": "Demo Project",
            "default_swimlane": "Default swimlane",
            "column_title": "Ready",
            "assignee_username": "admin",
            "assignee_name": null,
            "creator_username": "admin",
            "creator_name": null
        },
        "changes": {
            "description": "New description",
            "color_id": "purple",
            "date_due": 1469836800
        }
    }
}
```
NB : Task update events have a field called changes that contains updated values.
- `Comment creation `
```json
{
    "event_name": "comment.create",
    "event_data": {
        "comment": {
            "id": "1",
            "task_id": "5",
            "user_id": "1",
            "date_creation": "1469315727",
            "comment": "My comment.",
            "reference": null,
            "username": "admin",
            "name": null,
            "email": null,
            "avatar_path": null
        },
        "task": {
            "id": "5",
            "reference": "",
            "title": "My new task",
            "description": "New description",
            "date_creation": "1469315481",
            "date_completed": null,
            "date_modification": "1469315531",
            "date_due": "1469836800",
            "date_started": "0",
            "time_estimated": "0",
            "time_spent": "0",
            "color_id": "purple",
            "project_id": "1",
            "column_id": "2",
            "owner_id": "1",
            "creator_id": "1",
            "position": "1",
            "is_active": "1",
            "score": "3",
            "category_id": "0",
            "priority": "2",
            "swimlane_id": "0",
            "date_moved": "1469315481",
            "recurrence_status": "0",
            "recurrence_trigger": "0",
            "recurrence_factor": "0",
            "recurrence_timeframe": "0",
            "recurrence_basedate": "0",
            "recurrence_parent": null,
            "recurrence_child": null,
            "category_name": null,
            "swimlane_name": null,
            "project_name": "Demo Project",
            "default_swimlane": "Default swimlane",
            "column_title": "Ready",
            "assignee_username": "admin",
            "assignee_name": null,
            "creator_username": "admin",
            "creator_name": null
        }
    }
}
```
- `Subtask creation `
```json
{
    "event_name": "subtask.create",
    "event_data": {
        "subtask": {
            "id": "1",
            "title": "My subtask",
            "status": "0",
            "time_estimated": "0",
            "time_spent": "0",
            "task_id": "5",
            "user_id": "1",
            "position": "1",
            "username": "admin",
            "name": null,
            "timer_start_date": 0,
            "status_name": "Todo",
            "is_timer_started": false
        },
        "task": {
            "id": "5",
            "reference": "",
            "title": "My new task",
            "description": "New description",
            "date_creation": "1469315481",
            "date_completed": null,
            "date_modification": "1469315531",
            "date_due": "1469836800",
            "date_started": "0",
            "time_estimated": "0",
            "time_spent": "0",
            "color_id": "purple",
            "project_id": "1",
            "column_id": "2",
            "owner_id": "1",
            "creator_id": "1",
            "position": "1",
            "is_active": "1",
            "score": "3",
            "category_id": "0",
            "priority": "2",
            "swimlane_id": "0",
            "date_moved": "1469315481",
            "recurrence_status": "0",
            "recurrence_trigger": "0",
            "recurrence_factor": "0",
            "recurrence_timeframe": "0",
            "recurrence_basedate": "0",
            "recurrence_parent": null,
            "recurrence_child": null,
            "category_name": null,
            "swimlane_name": null,
            "project_name": "Demo Project",
            "default_swimlane": "Default swimlane",
            "column_title": "Ready",
            "assignee_username": "admin",
            "assignee_name": null,
            "creator_username": "admin",
            "creator_name": null
        }
    }
}
```
- `File upload `
```json
{
    "event_name": "task.file.create",
    "event_data": {
        "file": {
            "id": "1",
            "name": "kanboard-latest.zip",
            "path": "tasks/5/6f32893e467e76671965b1ec58c06a2440823752",
            "is_image": "0",
            "task_id": "5",
            "date": "1469315613",
            "user_id": "1",
            "size": "4907308"
        },
        "task": {
            "id": "5",
            "reference": "",
            "title": "My new task",
            "description": "New description",
            "date_creation": "1469315481",
            "date_completed": null,
            "date_modification": "1469315531",
            "date_due": "1469836800",
            "date_started": "0",
            "time_estimated": "0",
            "time_spent": "0",
            "color_id": "purple",
            "project_id": "1",
            "column_id": "2",
            "owner_id": "1",
            "creator_id": "1",
            "position": "1",
            "is_active": "1",
            "score": "3",
            "category_id": "0",
            "priority": "2",
            "swimlane_id": "0",
            "date_moved": "1469315481",
            "recurrence_status": "0",
            "recurrence_trigger": "0",
            "recurrence_factor": "0",
            "recurrence_timeframe": "0",
            "recurrence_basedate": "0",
            "recurrence_parent": null,
            "recurrence_child": null,
            "category_name": null,
            "swimlane_name": null,
            "project_name": "Demo Project",
            "default_swimlane": "Default swimlane",
            "column_title": "Ready",
            "assignee_username": "admin",
            "assignee_name": null,
            "creator_username": "admin",
            "creator_name": null
        }
    }
}
```
- `Task link creation `
```json
{
    "event_name": "task_internal_link.create_update",
    "event_data": {
        "task_link": {
            "id": "2",
            "opposite_task_id": "5",
            "task_id": "4",
            "link_id": "3",
            "label": "is blocked by",
            "opposite_link_id": "2"
        },
        "task": {
            "id": "4",
            "reference": "",
            "title": "My task",
            "description": "",
            "date_creation": "1469314356",
            "date_completed": null,
            "date_modification": "1469315422",
            "date_due": "1469491200",
            "date_started": "0",
            "time_estimated": "0",
            "time_spent": "0",
            "color_id": "green",
            "project_id": "1",
            "column_id": "1",
            "owner_id": "1",
            "creator_id": "1",
            "position": "1",
            "is_active": "1",
            "score": "0",
            "category_id": "0",
            "priority": "0",
            "swimlane_id": "0",
            "date_moved": "1469315422",
            "recurrence_status": "0",
            "recurrence_trigger": "0",
            "recurrence_factor": "0",
            "recurrence_timeframe": "0",
            "recurrence_basedate": "0",
            "recurrence_parent": null,
            "recurrence_child": null,
            "category_name": null,
            "swimlane_name": null,
            "project_name": "Demo Project",
            "default_swimlane": "Default swimlane",
            "column_title": "Backlog",
            "assignee_username": "admin",
            "assignee_name": null,
            "creator_username": "admin",
            "creator_name": null
        }
    }
}
```
