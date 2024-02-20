import json
import requests

SLACK_BOT_TOKEN = "xoxb-2055479892022-4445817970965-KObYLjbXvuP4QygzDVnoDER5"
SLACK_CHANNEL = 'testtest'
SLACK_BOT_NAME = 'monitor'


def post_message_to_channel(text, blocks = None):
    return requests.post('https://slack.com/api/chat.postMessage', {
        'token': SLACK_BOT_TOKEN,
        'channel': SLACK_CHANNEL,
        'text': text,
        'username': SLACK_BOT_NAME,
        'blocks': json.dumps(blocks) if blocks else None
    }).json()

def post_message_to_user(text, user, blocks = None):
    return requests.post('https://slack.com/api/chat.postMessage', {
        'token': SLACK_BOT_TOKEN,
        'channel': user,
        'text': text,
        'username': SLACK_BOT_NAME,
        'as_user': "true",
        'blocks': json.dumps(blocks) if blocks else None
    }).json()
