import time
import slack
from slack.errors import SlackApiError
import mypsutil as cpu
import newBookingScript as bookings
# import json

# Initialize the Slack client with your API token
client = slack.WebClient(token='')

RESOURCE_GROUP = "arptracker4"

while True:

    cpu_data = cpu.main()
    bookings_data = bookings.fetch_bookings(RESOURCE_GROUP)
    resources = bookings.fetch_resources()
    relevant_bookings = [booking for booking in bookings_data if booking['resource_group_name'] == RESOURCE_GROUP]

    users_to_exclude = ["root", "systemd+", "avahi", "message+", "syslog", "daemon", "xrdp", "nvidia-+", "rtkit", "colord", "kernoops"]

    for user, usage in cpu_data.items():
        if user not in users_to_exclude:
            if user in resources:  
                if usage['CPU'] > resources[user] and user not in [booking['resource_name'] for booking in relevant_bookings]:
                    message = f"A user is using {user} without a booking and appointment! CPU usage is above the threshold. Threshold is {resources[user]}"
                    client.chat_postMessage(channel='U06J8L68WUA', text=message)
            else:
                message = f"The resource for user {user} has not been added to the website."
                client.chat_postMessage(channel='U06J8L68WUA', text=message)
            
    time.sleep(60)