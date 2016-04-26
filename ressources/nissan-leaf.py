#!/usr/bin/python

import pycarwings2
import time
from ConfigParser import SafeConfigParser
import logging
import sys
import pprint
import json

logging.basicConfig(stream=sys.stdout, level=logging.CRITICAL)


answer = dict()
username = sys.argv[1]
password = sys.argv[2]


s = pycarwings2.Session(username, password , "NE")
l = s.get_leaf()


result_key = l.request_update()
time.sleep(40) # sleep 60 seconds to give request time to process
battery_status = l.get_status_from_update(result_key)
for i in range (1,20):
        if battery_status is not None:
	    break
        time.sleep(10)
        battery_status = l.get_status_from_update(result_key)
else:
	sys.exit("Never receive a request")
answer["battery_status"] = battery_status.answer
leaf_info = l.get_latest_battery_status()
answer["leaf_info"] = leaf_info.answer
print json.dumps(answer)
#print json.dumps(answer, sort_keys=True, indent=4, separators=(',', ': '))

