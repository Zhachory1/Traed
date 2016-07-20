from __future__ import print_function
import MySQLdb
import requests
import urllib2
import socket
import json
import datetime

def getHistory(sym, st):
	try:
		quoteJson = urllib2.urlopen("http://marketdata.websol.barchart.com/getHistory.json?key=1c0449192076f19c7429b2c1ed1c594d&symbol="+sym+"&type=daily&startDate="+st, timeout=30).read().decode('utf-8')
		return quoteJson
	except urllib2.URLError, e:
		print("Resending")
		return getHistory(sym, st)
	except socket.timeout, e:
		print("Resending")
		return getHistory(sym, st)

f       = open('../data/batstock.csv', 'r')
conn    = MySQLdb.connect(host='localhost', user='root', passwd='16Notefill', db='traed')
cur     = conn.cursor()
listing = f.read()
listing = listing.split("\n")
st      = (datetime.datetime.now() - datetime.timedelta(days=2*364)).strftime('%Y%m%d')
f.close()

for record in listing[3461:]:
	try:
		sym = record.split(",")[0]
		print(sym, end="...")
		quoteJson = getHistory(sym, st)
		print("done request", end="...")
		if(quoteJson is not None):
			quote = json.loads(quoteJson)
			results = quote["results"]
			sql = "SELECT `id` FROM `stocks` WHERE `symbol`='"+sym+"';"
			cur.execute(sql)
			print("done select", end="...")
			stock_id = cur.fetchone()[0]
			for data in results:
				sql = "INSERT INTO `traed`.`basic` (`stock_id`, `date`, `open`, `high`, `low`, `close`, `volume`) VALUES ("+str(stock_id)+", '"+str(data["tradingDay"].replace("-",""))+"', "+str(data["open"])+", "+str(data["high"])+", "+str(data["low"])+", "+str(data["close"])+", "+str(data["volume"])+");"
				cur.execute(sql)
			print("done inserts")
	except ValueError, e:
		print("Finished!")
		exit()
# disconnect from server
conn.commit()
conn.close()