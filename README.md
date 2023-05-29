# Big-Board

## Local requirements

- PHP 7.4
- MySQL
- [Composer](https://getcomposer.org/)

## Set up Slack

### Channels

Create a `#big-board` channel.

### Slack Bot

1. Go to https://api.slack.com/apps
1. Click **Create an App**.
1. Click **From scratch**.
1. Name it TobyBot and choose your team's workspace.
1. Allow the following permission scopes:
    - `commands`
    - `channels:history`
    - `channels:read`
    - `channels:write.invites`
    - `channels:write.topic`
    - `chat:write`
    - `chat:write.public`
    - `emoji:read`
    - `pins:write`
    - `users.profile:read`
    - `users:read`
    - `users:write`
    - `channels:manage`
    - `channels:join`

1. Click "Slash Commands". Create these seven commands. For each one, define the Request URL as `http://[YOURAPP].herokuapp.com/tobybot`. Include Descriptions and Usage Hints as desired.
    - `/board`: Query for puzzle status
    - `/solve`: Set the solution for a puzzle
    - `/info`: Get info for a puzzle
    - `/connect`: Connect to Big Board
    - `/avatar`: Refresh your avatar
    - `/tobybot`: List all commands

## Set up Google API project

1. [Go here](https://console.developers.google.com/apis/credentials)
2. Click "Create credentials". Choose "OAuth client ID".
3. Add Authorized JavaScript origins
    - `https://[YOURAPP].herokuapp.com`
4. Add Authorized redirect URIs:
    - `https://[YOURAPP].herokuapp.com`
    - `https://[YOURAPP].herokuapp.com/oauth`
5. Note your Client ID and Client secret.
6. Add the privacy policy URL (`http://your-domain/privacy`) to your [OAuth consent screen](https://console.cloud.google.com/apis/credentials).  Once your app is live, you'll need to go through the verification process [here](https://support.google.com/cloud/answer/7454865)) to get rid of the "unverified app" screen.
7. Create a separate credential for testing.  Add `http://localhost:8888` to Authorized JavaScript origins and `http://localhost:8888` and `http://localhost:8888/oauth` to Authorized Redirect URI's for that one
8. Click "Create credentials" again and choose "Service Account".  Download the JSON for login info here for later.
9. At https://console.developers.google.com/apis/dashboard?project=[your-project-name], enable:
    - Google Drive API
    - Picker API
    - Sheets API
10. Enable auth/drive.file scope at https://console.developers.google.com/apis/credentials/consent/edit?project=[your-project-id]
11. Click "Create credentials" again and choose "API Key"

## Set up Heroku instance

Note that Heroku does not have a free tier. Many features can be tested using a local instance. The Slack integration must be tested on Heroku.

The current recommendation for testing is to sign your account up for the "eco" tier, which is $5/month and covers both the web and worker dynos.

Provision a MySQL add-on. I used ClearDB. Create a DB. Note your:

- URL
- DB name
- username
- password

The free (Ignite) tier is fine for testing, but upgrade to the Punch tier ($9.99/month) for the hunt.

Provision Heroku Redis. At the lowest (mini) tier, this costs $3 per month (prorated to the second).

`heroku addons:create heroku-redis:mini -a your-app-name`

Allow workers on Heroku.

`heroku config:add LD_LIBRARY_PATH=/app/php/ext:/app/apache/lib -a your-app-name`

## Config variables

Define these locally and Heroku.  Locally: copy `envvars_example.config` to `envvars.config`, fill out the fields, and run `source envars.config`.  On Heroku: config variables are in the settings tab.

Some notes on figuring these out:

**Database configuration**

- `BIG_BOARD_DB_HOST`
- `BIG_BOARD_DB_NAME`
- `BIG_BOARD_DB_USERNAME`
- `BIG_BOARD_DB_PASSWORD`

On Heroku - there's a `CLEARDB_DATABASE_URL` config variable which is in the format `mysql://BIG_BOARD_DB_USERNAME:BIG_BOARD_DB_PASSWORD@BIG_BOARD_DB_HOST/BIG_BOARD_DB_NAME?reconnect=true`.

Locally - Run mysql and create a database and a user.  host is localhost, the rest is what you set while creating this.

**Google Drive configuration**

- `GOOGLE_APP_ID` - the project number in the google cloud console
- `GOOGLE_APPLICATION_NAME` - the project name
- `GOOGLE_CLIENT_ID` - you got this while setting up google credentials earlier
- `GOOGLE_CLIENT_SECRET` - same
- `GOOGLE_DEVELOPER_KEY` - the API key you got while setting up google credentials
- `GOOGLE_DRIVE_ID` - go to google drive for your team folder, look at the url - it's the long id string there.  Similarly for `GOOGLE_DOCS_TEMPLATE_ID`
- `GOOGLE_SERVICE_ACCOUNT_APPLICATION_CREDENTIALS` - this is the json for when you made the service account credential

**Slack configuration**

- `SLACK_DOMAIN` - just the id, without any dots or the slack.com domain -- e.g. palindrome2018
- `TOBYBOT_SLACK_KEY` - OAuth Bot Access token. Starts with `xoxb`.
- `TOBYBOT_SIGNING_SECRET` - Signing secret, listed under Basic Information. 32 characters long.

**Other**

- `SIDEBAR_TEAM_INFO` - data that goes in Big Board sidebar.  Semicolon separated;  each semicolon starts a new line.

## Set up local environment

Run:

```
composer install --ignore-platform-reqs
```

At this point, make sure all the installed libraries (which are at `vendor/bin/`) are on your PATH. Then run:

```
composer dump-autoload
propel config:convert
propel sql:insert
propel migrate --fake
```

You can run the app locally with e.g.

```
php -S localhost:8888
```

## Push to Heroku

To set up the DB on Heroku, first push, then run:

```
heroku run bash -a your-app-name
propel sql:insert
```

Set up automatic deployments by connecting your Heroku instance to your GitHub repo.
