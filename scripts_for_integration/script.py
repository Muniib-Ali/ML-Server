import  mypsutil

usage = get_usage()
for user, value in usage.items():
    print(f"{str(user).ljust(10)}: CPU:{value['CPU']} MEM:{value['MEM']}")