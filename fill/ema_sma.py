import MySQLdb

def emasma(p1, p2, tableName, id):
	conn = MySQLdb.connect(host='localhost', user='root', passwd='16Notefill', db='traed')
	cur  = conn.cursor()
	m = 2/(p2+1)
	summ = 0

	sql = "SELECT `close` from `basic`  where `stock_id`="+str(id)+" order by date desc limit "+str(p1)+";"
	cur.execute(sql)
	data = cur.fetchall()
	for row in data:
		summ+=row[0]
	sma = summ/p1
	

emasma(7, 14, "short_term", 5288)