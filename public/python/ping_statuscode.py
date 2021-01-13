import requests
import time
import threading

def ping():
	fo = open("url.txt", "r")
	str = fo.read(100);
	x = requests.get(str)
	fo.close()
	print(x.status_code)	

threads = []
start_time = time.time()
for x in range(150):
    t = threading.Thread(target=ping())
    threads.append(t)
    t.start()
print("--- %s seconds ---" % (time.time() - start_time))
