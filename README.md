GoogleSheet plugin for Kanboard
==============================

Receive Kanboard notifications on [GoogleSheet](https://docs.google.com/spreadsheets).


Author
------
- Ahcene Dahmane
- License MIT

Requirements
------------

- Kanboard >= 1.0.37
- Google Sheet

Installation
------------

You have the choice between 3 methods:

1. Install the plugin from the Kanboard plugin manager in one click
2. Download the zip file and decompress everything under the directory `plugins/GoogleSheet`
3. Clone this repository into the folder `plugins/GoogleSheet`

Note: Plugin folder is case-sensitive.

Configuration
-------------

### GoogleSheet configuration

- Generate a new webhook url after deploying the app script project

### Kanboard configuration

#### Individual notifications

1. Copy and paste the webhook url into **Integrations ** in your
   user profile
2. Enable RocketChat notifications in your user profile or project settings (Optional)
3. Enjoy!

#### Project notification

1. Copy and paste the webhook url into **Integrations** in the
   project settings
2. Add the channel name (Optional)
3. Enable RocketChat notification in the project (Optional)
4. Enjoy!

#### Kanboard configuration file

One technical parameter can be override by the [Kanboard `config.php` file](https://docs.kanboard.org/en/latest/admin_guide/config_file.html):

|Key | Description | Default value |
|:---|:------------|:--------------|
|`APPSCRIPT_WEBHOOK`   | The generated link from the app script application after deployement. | Empty |

Development
-------------

Please do not hesitate to suggest Pull Request :D

To generate a new release archive, run: `make version=v1.0.x`.
