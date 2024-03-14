import requests
import json
import os

def fetch_bookings():
    url = "http://127.0.0.1:8000/get-currentbookings"
    filepath = os.path.join('scripts_for_integration', 'bookings.json');
    response = requests.get(url)
    if response.status_code == 200:
        bookings_data = response.json()
        return bookings_data
    else:
        print("Unable to fetch bookings, error code is:", response.status_code)

if __name__ == "__main__":
    fetch_bookings()
