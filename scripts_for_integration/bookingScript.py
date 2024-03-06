import requests
import json
import os

def fetch_bookings():
    url = "http://127.0.0.1:8000/get-currentbookings"
    filepath = os.path.join('scripts_for_integration', 'bookings.json');
    response = requests.get(url)
    if response.status_code == 200:
        bookings_data = response.json()
        with open(filepath, 'w') as fd:
            json.dump(bookings_data, fd, indent=2)

        print("Currently applicable bookings were saved the bookings.json")
    else:
        print("Unable to fetch bookings, error code is:", response.status_code)

if __name__ == "__main__":
    fetch_bookings()