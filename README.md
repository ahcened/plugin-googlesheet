GoogleSheet plugin for Kanboard
==============================

Receive Kanboard notifications on [GoogleSheet](https://github.com/ahcened/plugin-googlesheet).


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

- Generate a new webhook url after deploying the app script project in Google Sheet

### Kanboard configuration

####  Notifications

1. Copy and paste the webhook url into **Integrations ** in your project settings
2. Enable RocketChat notifications
3. Enjoy!

#### App script configuration variables
Each time a deployement is done, a new Webhook URL is generated. Make sure to change it in the php code of the plugin.
|Key | Description | Default value |
|:---|:------------|:--------------|
|`APPSCRIPT_WEBHOOK`   | The generated link from the app script application after deployement. | Empty |

Development
-------------

Please do not hesitate to suggest Pull Request :D

To generate a new release archive, run: `make version=v1.0.x`.
