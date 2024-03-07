import json
from psutil import Popen
from subprocess import PIPE

def get_usage():
    def minfloat(inp):
        ret = float(inp)
        if ret < 0.05:
            ret = 0.05
        return ret

    p = Popen(["top", "-b", "-n", "1", "-w", "200"], stdout=PIPE)
    stdout, stderror = p.communicate()

    users = {}
    start = False
    for line in stdout.__repr__().split("\\n"):
        # Do the stuff after the header. Process the header accordingly
        if 'COMMAND' in line and 'PID' in line:
            field_indices = {}
            for i, field in enumerate(line.split()):
                field_indices[field] = i
            start = True
            continue
        if start is False:
            continue
        fields = line.split()
        num_fields = len(fields)
        if num_fields > 12:
            fields = fields[0:11] + [' '.join(fields[11:])]
            num_fields = len(fields)
        if num_fields < 12:
            continue
        userid = fields[field_indices['USER']]
        if userid not in users.keys():
            users[userid] = {}
            users[userid]['PIDs'] = []
            users[userid]['COMMANDs'] = []
            users[userid]['CPU'] = 0.
            users[userid]['MEM'] = 0.
        users[userid]['PIDs'].append(int(fields[field_indices['PID']]))
        users[userid]['COMMANDs'].append(fields[field_indices['COMMAND']])
        users[userid]['CPU'] += minfloat(fields[field_indices['%CPU']])
        users[userid]['MEM'] += minfloat(fields[field_indices['%MEM']])

    return users

if __name__ == "__main__":
    usage = get_usage()
    usage_dict = {user: {'CPU': value['CPU'], 'MEM': value['MEM']} for user, value in usage.items()}

    with open("cpu.json", "w") as json_file:
        json.dump(usage_dict, json_file, indent=4)

    for user, value in usage.items():
        print(f"{str(user).ljust(10)}: CPU:{value['CPU']} MEM:{value['MEM']}")
