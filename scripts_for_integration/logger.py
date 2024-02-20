import time

import mygputil
import mypsutil

from myslack import post_message_to_user


NAIM = "U04QJBLFLPR" # Luis



WHITELIST = ['root', 'message+', 'whoopsie', 'daemon', 'colord', 'kernoops', 'rtkit', 'lightdm', 'systemd+', 'uuidd', 'avahi', 'postgres', 'syslog', 'clamav', '_rpc', 'statd', 'www-data']

def get_gpu_users(cpu_dict, gpu_dict):
    gpu_users = {}
    for gpu in gpu_dict.keys():
        gpu_users[gpu] = []

    for gpu, gpu_pids in gpu_dict.items():
        for user, user_data in cpu_dict.items():
            if user in WHITELIST:
                continue
            for gpu_pid in gpu_pids:
                for cpu_pid in user_data['PIDs']:
                    if cpu_pid == gpu_pid:
                        if user not in gpu_users[gpu]:
                            gpu_users[gpu].append(user)
    return gpu_users
			

while True:
    message = '='*80
    cpu_usage = mypsutil.get_usage()
    for k in WHITELIST:
        cpu_usage.pop(k, None)
    message += f'\ncpu_usage:'
    for user, user_data in cpu_usage.items():
        message += f"\n{str(user).ljust(10)}: CPU:{user_data['CPU']} MEM:{user_data['MEM']}"
    gpu_usage = mygputil.get_usage()
    gpu_users = get_gpu_users(cpu_usage, gpu_usage)
    message += f'\ngpu_users: {gpu_users}'

    print(message)
    print(post_message_to_user(message, NAIM))
    time.sleep(60)


