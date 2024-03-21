import os
import time
import slack
from slack.errors import SlackApiError
import mypsutil as cpu
import websiteAPI as bookings
import mygputil as gpu

client = slack.WebClient(token='')

RESOURCE_GROUP = "arptracker4"
USER_MAPPINGS = {"muniib":"alimuniib@gmail.com"}
WHITELIST = ["root", "systemd+", "avahi", "message+", "syslog", "daemon", "xrdp", "nvidia-+", "rtkit", "colord", "kernoops"]
TIME_THRESHOLD = 600
MINIMUM_USAGE = 10

messages_sent = {}



def kill_pid(pid):
    # ADD "muniib ALL = (root) NOPASSWD: /usr/bin/kill" to /etc/sudoers
    os.system(f"sudo kill -9 {str(pid)}")

def discard_old_messages_sent(messages, threshold):
    t = time.time()
    ret = {}
    for channel in messages.keys():
        ret[channel] = []
        for message in messages[channel]:
            if t - message['timestamp'] < threshold:
                ret[channel].append(message)
    return ret

def post_message(channel=None, text=None, messages=None):
    if channel is None or text is None or message is None:
        raise Exception("XXX")
    if channel not in messages:
        messages[channel] = []
    try:
        if text not in [x['text'] for x in messages[channel]]:
            client.chat_postMessage(channel=channel, text=text)
            messages[channel].append({'text': text, 'timestamp': time.time()})
    except SlackApiError as e:
        print(f"Error: {e}")

while True:
    messages_sent = discard_old_messages_sent(messages_sent, TIME_THRESHOLD)

    cpu_data = cpu.main()
    bookings_data = bookings.fetch_bookings()
    users_dict = bookings.fetch_users()
    admin_users = bookings.fetch_admin()
    relevant_bookings = [booking for booking in bookings_data if booking['resource_group_name'] == RESOURCE_GROUP]
    gpu_data = gpu.get_usage()
    
    for current_user, usage in cpu_data.items():
        if current_user not in WHITELIST and usage['CPU'] > MINIMUM_USAGE:
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
                        for admin_user in admin_users:
                            message = f"A user: {current_user} is using more resources than they have booked. Threshold is {upper_threshold_total} and they are using {usage['CPU']}"
                            post_message(channel=admin_user.get('slack'), text=message, messages=messages_sent)
                        message = f"You are using more {RESOURCE_GROUP} : CPU than you have booked!"
                        post_message(channel=slack_id, text=message, messages=messages_sent)
                    elif upper_threshold_total == 0:
                        for admin_user in admin_users:
                            message = f"A user: {current_user} is using {RESOURCE_GROUP}'s CPU without a booking!"
                            post_message(channel=admin_user.get('slack'), text=message, messages=messages_sent)
                        message = f"You are using {RESOURCE_GROUP} : CPU without having created a booking!"
                        post_message(channel=slack_id, text=message, messages=messages_sent)

            else:
                for admin_user in admin_users:
                    message = f"User: {current_user} has not registered on the website and is using more than CPU minimum threshold"
                    post_message(channel=admin_user.get('slack'), text=message, messages=messages_sent)

    
    for singleGPU, processes in gpu_data.items():
        for process in processes:
            if process['user'] not in WHITELIST:
                if process['user'] in USER_MAPPINGS:
                    email = USER_MAPPINGS.get(process['user'], None)
                    slack_id = users_dict.get(email)
                    hasBooked = False
                    for booking in relevant_bookings:
                        if booking['email'] == email:
                            if str(singleGPU) in booking['name']:
                                hasBooked = True
                    if hasBooked == True:
                        continue
                    else:
                        for admin_user in admin_users:
                            message = f"A user: {process['user']} is using {RESOURCE_GROUP}'s GPU number: {singleGPU} without a booking!"
                            post_message(channel=admin_user.get('slack'), text=message, messages=messages_sent)
                        message = f"You are using {RESOURCE_GROUP}'s GPU number: {singleGPU} without having created a booking!"
                        post_message(channel=slack_id, text=message, messages=messages_sent)

                else:
                    for admin_user in admin_users:
                        message = f"User: {process['user']} has not registered on the website and is using GPU number: {singleGPU}"
                        post_message(channel=admin_user.get('slack'), text=message, messages=messages_sent)

    
    
    
    time.sleep(60)


