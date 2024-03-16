import time
import slack
from slack.errors import SlackApiError
import mypsutil as cpu
import newBookingScript as bookings

client = slack.WebClient(token='')

RESOURCE_GROUP = "arptracker4"
USER_MAPPINGS = {"muniib":"alimuniib@gmail.com"}
WHITELIST = ["root", "systemd+", "avahi", "message+", "syslog", "daemon", "xrdp", "nvidia-+", "rtkit", "colord", "kernoops"]
while False:

    cpu_data = cpu.main()
    bookings_data = bookings.fetch_bookings()
    resources = bookings.fetch_resources(RESOURCE_GROUP)
    relevant_bookings = [booking for booking in bookings_data if booking['resource_group_name'] == RESOURCE_GROUP]

    users_to_exclude = ["root", "systemd+", "avahi", "message+", "syslog", "daemon", "xrdp", "nvidia-+", "rtkit", "colord", "kernoops"]

    # {"cpu_block_1": (10,50), "cpu_block_2": (10, 50)}


    print(resources)
    for current_user, usage in cpu_data.items():
        if current_user not in users_to_exclude:
            if current_user in resources:  
                if usage['CPU'] > resources[current_user] and current_user not in [booking['resource_name'] for booking in relevant_bookings]:
                    message = f"A user is using {current_user} without a booking and appointment! CPU usage is above the threshold. Threshold is {resources[current_user]}"
                    client.chat_postMessage(channel='U06J8L68WUA', text=message)
            else:
                message = f"The resource for user {current_user} has not been added to the website."
                client.chat_postMessage(channel='U06J8L68WUA', text=message)
            
    time.sleep(60)

while True:
    cpu_data = cpu.main()
    bookings_data = bookings.fetch_bookings()
    users_dict = bookings.fetch_users()
    relevant_bookings = [booking for booking in bookings_data if booking['resource_group_name'] == RESOURCE_GROUP]
    
    for current_user, usage in cpu_data.items():
        if current_user not in WHITELIST:
            if current_user in USER_MAPPINGS:
                email = USER_MAPPINGS.get(current_user, None)
                slack_id = users_dict.get(email)
                upper_threshold_total=0
                for booking in relevant_bookings:
                    if booking.get('email') == email:
                        upper_threshold_total += booking.get('uThreshold', 0)
                if usage['CPU'] < upper_threshold_total:
                    continue
                else:
                    if upper_threshold_total != 0:
                        message = f"A user: {current_user} is using more resources than they have booked. Threshold is {upper_threshold_total} and they are using {usage['CPU']}"
                        client.chat_postMessage(channel='U06J8L68WUA', text=message)
                        message = f"You are using more {RESOURCE_GROUP} : CPU than you have booked!"
                        client.chat_postMessage(channel=slack_id, text=message)
                    elif upper_threshold_total == 0:
                        message = f"A user: {current_user} is using arptracker-4's CPU without a booking!"
                        client.chat_postMessage(channel='U06J8L68WUA', text=message)
                        message = f"You are using {RESOURCE_GROUP} : CPU without having created a booking!"
                        client.chat_postMessage(channel=slack_id, text=message)

            else:
                message = f"User: {current_user} has not registered on the website"
                client.chat_postMessage(channel='U06J8L68WUA', text=message)

    time.sleep(60)


