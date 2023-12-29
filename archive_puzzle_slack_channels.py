from slack_sdk import WebClient
import os
import time

client = WebClient(token=os.environ.get("TOBYBOT_SLACK_KEY", ""))

cursor = None
while True:
    conversations = client.conversations_list(cursor=cursor)
    channels = conversations['channels']
    for channel in channels:
        if channel['name'][0] == 'ρ' and not channel['is_archived']:
            print("found {}".format(channel['name']))
            print(channel["id"])
            client.conversations_join(channel=channel["id"])
            client.conversations_archive(channel=channel["id"])
            time.sleep(10)
    if not conversations['response_metadata']['next_cursor']:
        print("all channels archived")
        break
    cursor = conversations['response_metadata']['next_cursor']
