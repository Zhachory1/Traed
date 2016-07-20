import MySQLdb
import requests
import urllib

f          = open('../data/batstock.csv', 'r')
conn       = MySQLdb.connect(host='localhost', user='root', passwd='16Notefill', db='traed')
cur        = conn.cursor()
listing    = f.read()
listing    = listing.split("\n")
sectors    = {}
industries = {
	"Basic Industries"      : 1 ,
	"Capital Goods"         : 3 ,
	"Consumer Durables"     : 4 ,
	"Consumer Non-Durables" : 5 ,
	"Energy"                : 6 ,
	"Finance"               : 7 ,
	"Health Care"           : 8 ,
	"Consumer Services"     : 9 ,
	"Technology"            : 10,
	"Transportation"        : 11,
	"Public Utilities"      : 12,
	"Miscellaneous"			: 0
}
f.close()

for record in listing[1:len(listing)-1]:
	data = record.split(",")
	sym  = data[0]
	name = data[1]
	exch = data[2]
	indy = industries[data[3]]
	sect = 0

	if data[4] not in sectors:
		sql = "INSERT INTO `traed`.`subsector` (`name`, `ind_id`) VALUES ('"+data[4]+"', "+str(indy)+");"
		cur.execute(sql)
		sql = "SELECT `id` FROM `traed`.`subsector` WHERE `name`='"+data[4]+"';"
		cur.execute(sql)
		sectors[data[4]] = cur.fetchone()[0]
	sect = sectors[data[4]]
	# Create table as per requirement
	sql = "INSERT INTO `traed`.`stocks` (`name`, `symbol`, `exchange`, `ind_id`, `ss_id`) VALUES (\""+name+"\", '"+sym+"', '"+exch+"', "+str(indy)+", "+str(sect)+");"
	cur.execute(sql)
# disconnect from server
conn.commit()
conn.close()