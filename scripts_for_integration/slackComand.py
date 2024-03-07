import slack
from slack.errors import SlackApiError
import mypsutil as cpu
import json

# Initialize the Slack client with your API token
client = slack.WebClient(token='')

cpu.main()

with open("cpu.json", "r") as json_file:
    cpu_data = json.load(json_file)

if 'muniib' in cpu_data and cpu_data['muniib']['CPU'] > 1.00:
    # Send a message to the general channel
    try:
        cpu_usage = cpu_data['muniib']['CPU']
        message = f"CPU usage for muniib is: {cpu_usage} !"
        response = client.chat_postMessage(channel='test', text=message)
        print("Message sent successfully!")
    except Exception as e:
        print(f"Error sending message: {e}")
else:
    print("CPU usage for user muniib is not over 1.00 or user muniib doesn't exist.")