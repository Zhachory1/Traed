import MySQLdb

conn    = MySQLdb.connect(host='localhost', user='root', passwd='16Notefill', db='test')
cur     = conn.cursor()
sql = "INSERT INTO `users` (`name`, `email`, `password`) VALUES('Zhach', 'trest@email.com', 'pass_word');"
cur.execute(sql)
sql = "SELECT LAST_INSERT_ID();"
cur.execute(sql)
print cur.fetchone()[0]
conn.commit()
conn.close()