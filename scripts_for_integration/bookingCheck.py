import json
import mygputil
import mypsutil
import time
import datetime

from myslack import post_message_to_user

NAIM = "U04QJBLFLPR"

WHITELIST = ['root', 'message+', 'whoopsie', 'daemon', 'colord', 'kernoops', 'rtkit', 'lightdm', 'systemd+', 'uuidd', 'avahi', 'postgres', 'syslog', 'clamav', '_rpc', 'statd', 'www-data']

def load_bookings():
    with open('bookings.json', 'r') as file:
        data = json.load(file)
    return data['data']

def use_matches_with_booking(cpu_use, gpu_use, booking):
    today = datetime.date.today()
    booking_date = datetime.datetime.strptime(booking['created_at'].split('T')[0], '%Y-%m-%d').date()
    return (cpu_use['username'] == booking['username'] and
            cpu_use['CPU'] > 5 and
            (gpu_use is None or gpu_use['GPU'] > 5) and
            today == booking_date)

def send_message(use, message_type):
    if message_type == 'no_match':
        print(f"No booking matched for: {use['username']}")
    elif message_type == 'matched':
        print(f"Username matched for user: {use['username']}")

def get_gpu_users(gpu_usage):
    gpu_users = {}
    for users in gpu_usage.values():
        for username in users:
            gpu_users[username] = True
    return gpu_users

def main():
    # Loading all the bookings
    bookings = load_bookings()

    while True:
        message = '='*80
        cpu_usage = mypsutil.get_usage()
        for k in WHITELIST:
            cpu_usage.pop(k, None)

        message += f'\ncpu_usage:'
        for username, usage_info in cpu_usage.items():
            message += f'\n{username}  : CPU:{usage_info["CPU"]} MEM:{usage_info["MEM"]}'

        gpu_usage = mygputil.get_usage()
        gpu_users = get_gpu_users(gpu_usage)
        message += f'\ngpu_users: {gpu_usage}'

        for username, cpu_use_info in cpu_usage.items():
            cpu_use = {'username': username, 'CPU': cpu_use_info['CPU']}
            gpu_use = {'username': username, 'GPU': gpu_usage[username]['GPU']} if username in gpu_users else None
            valid = False
            for booking in bookings:
                if use_matches_with_booking(cpu_use, gpu_use, booking):
                    valid = True
                    send_message(cpu_use, 'matched')
                    break
            if not valid:
                send_message(cpu_use, 'no_match')

        print(message)
        print(post_message_to_user(message, NAIM))
        time.sleep(60)

if __name__ == "__main__":
    main()