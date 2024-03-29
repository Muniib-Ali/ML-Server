import requests

def fetch_bookings():
    url = "http://57.128.172.217:8000/get-currentbookings"
    response = requests.get(url)
    if response.status_code == 200:
        bookings_data = response.json()
        return bookings_data
    else:
        print("Unable to fetch bookings, error code is:", response.status_code)


def fetch_resources(resource_group):
    url = "http://57.128.172.217:8000/get-thresholds"
    response = requests.get(url)
    if response.status_code == 200:
        all_resources = response.json()
        bot_resources = [resource for resource in all_resources if resource['resource_group_name'] == resource_group]

        resource_dict = {}
        for resource in bot_resources:
            resource_name = resource['name']
            threshold = resource.get('lThreshold')
            if threshold is None:
                threshold = 0
            resource_dict[resource_name] = threshold
        return resource_dict
    else:
        print("Unable to fetch resource thresholds, error code is:", response.status_code)

def fetch_users():
    url = "http://57.128.172.217:8000/get-users"
    response = requests.get(url)
    if response.status_code == 200:
        user_data = response.json()
        email_slack_dict = {user['email']: user['slack'] for user in user_data}
        return email_slack_dict

def fetch_admin():
    url = "http://57.128.172.217:8000/get-users"
    response = requests.get(url)
    if response.status_code == 200:
        user_data = response.json()
        admin_user_data = [user for user in user_data if user['is_admin'] == 1]
        return admin_user_data
if __name__ == "__main__":
    fetch_bookings()
     