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
    bookings.fetch_bookings()
    bookings_data = bookings.fetch_bookings()
    relevant_bookings = [booking for booking in bookings_data if booking['resource_group_name'] == RESOURCE_GROUP]

    users_to_exclude = ["root", "systemd+", "avahi", "message+", "syslog", "daemon", "xrdp", "nvidia-+", "rtkit", "colord", "kernoops"]

    for user, usage in cpu_data.items():
        if user not in users_to_exclude and usage > 10 and user not in [booking['resource_name'] for booking in relevant_bookings]:
            message = f"A user is using {user}: without booking and appointment!"

            client.chat_postMessage(channel='U06J8L68WUA', text = message)
            
    time.sleep(60)