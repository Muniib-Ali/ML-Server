from psutil import Popen
from subprocess import PIPE
import psutil

def get_usage():
    p = Popen(["nvidia-smi"], stdout=PIPE)
    stdout, stderror = p.communicate()

    gpus = {}
    start1 = start2 = False
    for line in stdout.__repr__().split("\\n"):
        # Do the stuff after the header
        if 'Process name' in line:
            start1 = True
            continue
        if start1 is False:
            continue
        if '==========' in line:
            start2 = True
            continue
        if start2 is False:
            continue
        # From here 
        fields = line.split()
        if len(fields) < 9:
            break
        gpu = int(fields[1])
        pid = int(fields[4])
        process = psutil.Process(pid)
        user = process.username()
        if gpu in gpus.keys():
            gpus[gpu].append({'pid': pid, 'user': user })
        else:
            gpus[gpu] = [{'pid': pid, 'user': user }]
        #print(pid, gpu)
    return gpus

if __name__ == "__main__":
    usage = get_usage()
    print(usage)

