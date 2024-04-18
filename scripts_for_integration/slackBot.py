import os
import time
import slack
from slack.errors import SlackApiError
import mypsutil as cpu
import websiteAPI as bookings
import mygputil as gpu
import re
import json

config = json.load(open("config.json", 'r'))

RESOURCE_GROUP = config["resource_group"]
USER_MAPPINGS = config["user_mappings"]
WHITELIST = config["whitelist"]
TIME_THRESHOLD = config["time_threshold"]
MINIMUM_USAGE = config["minimum_usage"]
TOKEN = config["token"]
ABFILTER = config["ab_filter"]
NUMBER_OF_WARNINGS = config["number_of_warnings"]

client = slack.WebClient(token=TOKEN)

messages_sent = {}

cpu_usage = dict()

users_to_terminate = {}

process_to_terminate = {}


def kill_pid(pid):
    # ADD "muniib ALL = (root) NOPASSWD: /usr/bin/kill" to /etc/sudoers
    os.system(f"sudo kill -9 {str(pid)}")

def kill_by_user(uid):
    os.system(f"sudo pkill -u {str(uid)}")
    
def add_process_to_terminate(pid, slack_id, user, gpu_num):
    timestamp = time.time()
    if pid not in process_to_terminate:
        process_to_terminate[pid] = {'timestamp': timestamp, 'slack_id': slack_id, 'user': user, 'warnings': 1, 'gpu': gpu_num}
    else:
        timeCheck = timestamp - process_to_terminate[pid]['timestamp']
        if(timeCheck / process_to_terminate[pid]['warnings'] >= TIME_THRESHOLD):
            process_to_terminate[pid]['warnings'] += 1

def add_user_to_terminate(uid, slack_id):
    timestamp = time.time()
    if uid not in users_to_terminate:
        users_to_terminate[uid] = {'timestamp': timestamp, 'slack_id': slack_id, 'warnings': 1}
    else:
        timeCheck = timestamp - users_to_terminate[uid]['timestamp']
        if(timeCheck / users_to_terminate[uid]['warnings'] >= TIME_THRESHOLD):
            users_to_terminate[uid]['warnings'] += 1

def terminate_users_and_proccesses(messages_sent):
    for uid, data in list(users_to_terminate.items()):
        current_time = time.time()
        slack_id = data['slack_id']
        timestamp = data['timestamp']
        compare_timestamp = current_time - timestamp

        if data['warnings'] > NUMBER_OF_WARNINGS:
            #kill_by_user(uid)
            message = "All of your user processes would be terminated at this point, however since this is a test run of the system only a warning message is sent"
            post_message(channel=slack_id, text = message, messages=messages_sent )
            for admin_user in admin_users:
                message = f"User: {uid} would have been terminated if the system was really implemented"
                post_message(channel=admin_user.get('slack'), text=message, messages=messages_sent)
            del users_to_terminate[uid]
        if (compare_timestamp - TIME_THRESHOLD * data['warnings']) > TIME_THRESHOLD:
            del users_to_terminate[uid]

    for pid, data in list(process_to_terminate.items()):
        current_time = time.time()
        slack_id = data['slack_id']
        timestamp = data['timestamp']
        gpu_num = data['gpu']
        compare_timestamp = current_time - timestamp
        user = data['user']
            #kill_pid(pid)
        if data['warnings'] > NUMBER_OF_WARNINGS:
            message = f"Your processes on GPU number:{gpu_num} would be terminated at this point, however since this is a test run of the system only a warning message is sent"
            post_message(channel=slack_id, text = message, messages=messages_sent )
            for admin_user in admin_users:
                message = f"All process by {user} on GPU number:{gpu_num} would have been terminated if the system was really implemented for using a GPU without booking it"
                post_message(channel=admin_user.get('slack'), text=message, messages=messages_sent)
            del process_to_terminate[pid]
        if (compare_timestamp - TIME_THRESHOLD * data['warnings']) > TIME_THRESHOLD:
            del process_to_terminate[pid]


            

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
    messageToSend = text[:]
    text = re.sub("([\(]).*?([\)])", "\g<1>\g<2>", text)

    if channel is None or text is None or message is None:
        raise Exception("XXX")
    if channel not in messages:
        messages[channel] = []
    try:
        if text not in [x['text'] for x in messages[channel]]:
            client.chat_postMessage(channel=channel, text=messageToSend)
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
        try:
            cpu_usage[current_user] = ABFILTER*cpu_usage[current_user] + (1.-ABFILTER)*usage['CPU']
        except KeyError:
            cpu_usage[current_user] = (1.-ABFILTER)*usage['CPU']

        if current_user not in WHITELIST and cpu_usage[current_user] > MINIMUM_USAGE:
            if current_user in USER_MAPPINGS:
                pass
            if current_user in USER_MAPPINGS:
                email = USER_MAPPINGS.get(current_user, None)
                slack_id = users_dict.get(email)
                upper_threshold_total=MINIMUM_USAGE
                for booking in relevant_bookings:
                    if booking.get('email') == email:
                        upper_threshold_total += booking.get('uThreshold', 0)
                if cpu_usage[current_user] < upper_threshold_total:
                    continue
                else:
                    if upper_threshold_total != 0:
                        for admin_user in admin_users:
                            message = f"A user: {current_user} is using more resources than they have booked. Threshold is ({upper_threshold_total}) and they are using ({cpu_usage[current_user]})"
                            post_message(channel=admin_user.get('slack'), text=message, messages=messages_sent)
                        message = f"You are using more {RESOURCE_GROUP} : CPU than you have booked! Threshold is ({upper_threshold_total}) but you are using ({cpu_usage[current_user]})"
                        post_message(channel=slack_id, text=message, messages=messages_sent)
                        add_user_to_terminate(current_user, slack_id)

                    elif upper_threshold_total == 0:
                        for admin_user in admin_users:
                            message = f"A user: {current_user} is using {RESOURCE_GROUP}'s CPU without a booking!"
                            post_message(channel=admin_user.get('slack'), text=message, messages=messages_sent)
                        message = f"You are using {RESOURCE_GROUP} : CPU without having created a booking!"
                        post_message(channel=slack_id, text=message, messages=messages_sent)
                        add_user_to_terminate(current_user, slack_id)


            else:
                for admin_user in admin_users:
                    message = f"User: {current_user} has not registered on the website and is using more than CPU minimum threshold"
                    post_message(channel=admin_user.get('slack'), text=message, messages=messages_sent)
                add_user_to_terminate(current_user, 0)


    
    for singleGPU, processes in gpu_data.items():
        for process in processes:
            if process['user'] not in WHITELIST:
                if process['user'] in USER_MAPPINGS:
                    pass
                if process['user'] in USER_MAPPINGS:
                    email = USER_MAPPINGS.get(process['user'], None)
                    slack_id = users_dict.get(email)
                    hasBooked = False
                    for booking in relevant_bookings:
                        if booking['email'] == email:
                            if str(singleGPU) in booking['resource_name'] and 'CPU' not in booking['resource_name']:
                                hasBooked = True
                    if hasBooked == True:
                        continue
                    else:
                        for admin_user in admin_users:
                            message = f"A user: {process['user']} is using {RESOURCE_GROUP}'s GPU number: {singleGPU} without a booking!"
                            post_message(channel=admin_user.get('slack'), text=message, messages=messages_sent)
                        message = f"You are using {RESOURCE_GROUP}'s GPU number: {singleGPU} without having created a booking!"
                        post_message(channel=slack_id, text=message, messages=messages_sent)
                        add_process_to_terminate(process['pid'], slack_id, process['user'], singleGPU)

                else:
                    for admin_user in admin_users:
                        message = f"User: {process['user']} has not registered on the website and is using GPU number: {singleGPU}"
                        post_message(channel=admin_user.get('slack'), text=message, messages=messages_sent)
                    add_process_to_terminate(process['pid'], 0, process['user'], singleGPU)

    
    
    terminate_users_and_proccesses(messages_sent)

    time.sleep(60)


