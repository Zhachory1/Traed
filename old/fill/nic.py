import MySQLdb
import requests
import urllib2
import json
import time
from datetime import datetime

def getDQ(struct):
	f       = open('../data/batstock.csv', 'r')
	conn    = MySQLdb.connect(host='localhost', user='root', passwd='16Notefill', db='traed')
	cur     = conn.cursor()
	listing = f.read()
	listing = listing.split("\n")
	st      = datetime.fromtimestamp(time.time()).strftime('%Y%m%d')
	f.close();
	# f       = open('../data/log.txt', 'w')
	for x in range(len(listing)):