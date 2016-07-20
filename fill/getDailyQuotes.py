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
		for data in results:
			if data["volume"] != None and data['symbol'] != '':
				sql = "SELECT `id` FROM `stocks` WHERE `symbol`='"+data["symbol"]+"';"
				cur.execute(sql)
				stock                                    = cur.fetchone()
				stock_id                                 = stock[0]
				struct[stock_id]                         = {}
				struct[stock_id]['basic_data']           = {}
				struct[stock_id]['basic_data']["open"]   = data["open"]
				struct[stock_id]['basic_data']["close"]  = data["close"] if data["close"] != "" else 0
				struct[stock_id]['basic_data']["high"]   = data["high"]
				struct[stock_id]['basic_data']["low"]    = data["low"]
				struct[stock_id]['basic_data']["volume"] = data["volume"]
				sql                                      = "INSERT INTO `traed`.`basic` (`stock_id`, `date`, `open`, `high`, `low`, `close`, `volume`) VALUES ("+str(stock_id)+", '"+str(st)+"', "+str(data["open"])+", "+str(data["high"])+", "+str(data["low"])+", "+(str(data["close"]) if data["close"] != "" else str(0)) +", "+str(data["volume"])+");"
				cur.execute(sql)
				sql = "SELECT LAST_INSERT_ID();"
				cur.execute(sql)
				struct[stock_id]['basic'] = cur.fetchone()[0]
				for name in ['short_term', 'mid_term', 'long_term', 'final']:
					sql = "INSERT INTO `traed`.`"+name+"` (`stock_id`, `date`) VALUES ("+str(stock_id)+", '"+str(st)+"');"
					cur.execute(sql)
					sql = "SELECT LAST_INSERT_ID();"
					cur.execute(sql)
					struct[stock_id][name] = cur.fetchone()[0]
	# disconnect from server
	# f.write(datetime.fromtimestamp(time.time()).strftime('%Y/%m/%d %H:%M:%S') + "\t Traed-Daily Quotes::Completed")
	del listing
	conn.commit()
	conn.close()
