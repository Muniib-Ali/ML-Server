from pprint import pprint
import requests
from bs4 import BeautifulSoup
import pandas as pd


cookies = {
    'XSRF-TOKEN': 'eyJpdiI6Inp0MnhSZVdnVklTTVUrVzIvV0hIY2c9PSIsInZhbHVlIjoiNnR6c0RoL2dHazJaVm1mVnN6NzlkQkVNL3ZZcTkzL1cyT0JGZW9nNERCUjh3eDJmNlErb0Q2elFLS3RyZkpmU0c3b05PbnZyajhaV25EcjJHS3BPNC90TTRNUDJHNEJ5WXFKMlRtWEh5YXBDeXNkWEtTQ3ZucVVTVmJ0TURFejAiLCJtYWMiOiI3MmIzMjA0MmY2YzAzODVlNzYzZTI5OTgwMDhhMTRiMzBiYjFiOGExNDA5ZTc3NTJkZjJhNjNjMjU4YTNkMDMxIiwidGFnIjoiIn0%3D',
    'ml_server_booking_session': 'eyJpdiI6IlRMZTlidFVNOGRYaXZiNXpEOE1lUGc9PSIsInZhbHVlIjoibnJTYWFndWl2d3VQME91dW1DajVMZzhoK3RWN0Vva0RHSXQzOUpmWXNTUUEwQWFzTktpRHVleG1mZ1NYNStJa1VOV042SFVXa2xtNkVmbGFERlhyb2lhQnJCOEVzRTQ3UlFjajRZblMrUmFaODZsZUJNM092MHgzQ1UzaVk1OHMiLCJtYWMiOiJiYzNhMmQ0Njc0YzFjMjYxNWNmNDRhNTZmY2E5MWM3YzE2MGZkM2Y3NzZjOTAzODdjNDYwOWQ0MGRkNzc0NTVmIiwidGFnIjoiIn0%3D',
}

headers = {
    'authority': 'www.aston-mlbooking.com',
    'accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
    'accept-language': 'en-GB,en-US;q=0.9,en;q=0.8',
    'cache-control': 'max-age=0',
    'cookie': 'XSRF-TOKEN=eyJpdiI6Inp0MnhSZVdnVklTTVUrVzIvV0hIY2c9PSIsInZhbHVlIjoiNnR6c0RoL2dHazJaVm1mVnN6NzlkQkVNL3ZZcTkzL1cyT0JGZW9nNERCUjh3eDJmNlErb0Q2elFLS3RyZkpmU0c3b05PbnZyajhaV25EcjJHS3BPNC90TTRNUDJHNEJ5WXFKMlRtWEh5YXBDeXNkWEtTQ3ZucVVTVmJ0TURFejAiLCJtYWMiOiI3MmIzMjA0MmY2YzAzODVlNzYzZTI5OTgwMDhhMTRiMzBiYjFiOGExNDA5ZTc3NTJkZjJhNjNjMjU4YTNkMDMxIiwidGFnIjoiIn0%3D; ml_server_booking_session=eyJpdiI6IlRMZTlidFVNOGRYaXZiNXpEOE1lUGc9PSIsInZhbHVlIjoibnJTYWFndWl2d3VQME91dW1DajVMZzhoK3RWN0Vva0RHSXQzOUpmWXNTUUEwQWFzTktpRHVleG1mZ1NYNStJa1VOV042SFVXa2xtNkVmbGFERlhyb2lhQnJCOEVzRTQ3UlFjajRZblMrUmFaODZsZUJNM092MHgzQ1UzaVk1OHMiLCJtYWMiOiJiYzNhMmQ0Njc0YzFjMjYxNWNmNDRhNTZmY2E5MWM3YzE2MGZkM2Y3NzZjOTAzODdjNDYwOWQ0MGRkNzc0NTVmIiwidGFnIjoiIn0%3D',
    'sec-ch-ua': '"Chromium";v="112", "Google Chrome";v="112", "Not:A-Brand";v="99"',
    'sec-ch-ua-mobile': '?0',
    'sec-ch-ua-platform': '"Windows"',
    'sec-fetch-dest': 'document',
    'sec-fetch-mode': 'navigate',
    'sec-fetch-site': 'none',
    'sec-fetch-user': '?1',
    'upgrade-insecure-requests': '1',
    'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36',
}

response = requests.get('https://www.aston-mlbooking.com/user/BookingJson', cookies=cookies, headers=headers)

soup = BeautifulSoup(response.content, 'html.parser')
print(response.content)
fd = open('bookings.json', 'wb')
fd.write(response.content)
fd.close()
