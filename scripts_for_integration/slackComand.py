import slack
from slack.errors import SlackApiError
import mypsutil as cpu

# Initialize the Slack client with your API token
client = slack.WebClient(token='')

# Function to send a direct message
# Function to send a direct message



client.chat_postMessage(channel='general', text='test');
# Send the direct messag