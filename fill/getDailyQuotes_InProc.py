import MySQLdb
import requests
import urllib2
import json
import time
from datetime import datetime


f       = open('../data/batstock.csv', 'r')
conn    = MySQLdb.connect(host='localhost', user='root', passwd='16Notefill', db='traed')
cur     = conn.cursor()
listing = f.read()
listing = listing.split("\n")
st      = datetime.fromtimestamp(time.time()).strftime('%Y%m%d')
f.close();
#f       = open('../data/log.txt', 'w')
for x in range(len(listing)/100):
	print("On " + str(x) + "th group...")
	#f.write(str(x) + " group\n\n")
	num     = 100
	symbols = listing[(100*x)].split(",")[0]
	if x == len(listing)/100:
		num = listing%100
	for record in listing[(100*x)+1:(100*x)+num-1]:
		symbols = symbols + "," + record.split(",")[0] 
	quoteJson = urllib2.urlopen("http://marketdata.websol.barchart.com/getQuote.json?key=1c0449192076f19c7429b2c1ed1c594d&symbols="+symbols).read().decode('utf-8')
	quote = json.loads(quoteJson)
	results = quote["results"]
	#f.write(str(results))
	for data in results:
		if data["volume"] != None and data['symbol'] != '':
			sql = "SELECT `id` FROM `stocks` WHERE `symbol`='"+data["symbol"]+"';"
			cur.execute(sql)
			stock = cur.fetchone()
			stock_id = stock[0]
			sql = "INSERT INTO `traed`.`basic` (`stock_id`, `date`, `open`, `high`, `low`, `close`, `volume`) VALUES ("+str(stock_id)+", '"+str(st)+"', "+str(data["open"])+", "+str(data["high"])+", "+str(data["low"])+", "+(str(data["close"]) if data["close"] != "" else str(0)) +", "+str(data["volume"])+");"
			cur.execute(sql)
# disconnect from server
conn.commit()
conn.close()

