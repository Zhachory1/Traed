files = [
	"amex_basic.csv",
	"amex_capitalgoods.csv",
	"amex_durables.csv",
	"amex_energy.csv",
	"amex_finance.csv",
	"amex_health.csv",
	"amex_misc.csv",
	"amex_nondurables.csv",
	"amex_services.csv",
	"amex_tech.csv",
	"amex_transportation.csv",
	"amex_utilities.csv",
	"nyse_basic.csv",
	"nyse_capitalgoods.csv",
	"nyse_durables.csv",
	"nyse_energy.csv",
	"nyse_finance.csv",
	"nyse_health.csv",
	"nyse_misc.csv",
	"nyse_nondurables.csv",
	"nyse_services.csv",
	"nyse_tech.csv",
	"nyse_transportation.csv",
	"nyse_utilities.csv",
	"nasdaq_basic.csv",
	"nasdaq_capitalgoods.csv",
	"nasdaq_durables.csv",
	"nasdaq_energy.csv",
	"nasdaq_finance.csv",
	"nasdaq_health.csv",
	"nasdaq_misc.csv",
	"nasdaq_nondurables.csv",
	"nasdaq_services.csv",
	"nasdaq_tech.csv",
	"nasdaq_transportation.csv",
	"nasdaq_utilities.csv"
]
allstocks = []
count = 0
final = open('../data/batstock.csv', 'w')
final.write('"Symbol","Name","Exchange","Sector","Industry",\n')
for x in range(len(files)):
	f = open('../data/'+files[x], 'r')
	listing = f.read()
	listing = listing.split("\n")
	f.close()
	ex = x/12
	if(ex == 0):
		exchange = 'AMEX'
	elif(ex == 1):
		exchange = 'NASDAQ'
	else:
		exchange = 'NYSE'
	for record in listing[1:len(listing)-1]:
		info = record.split('","')
		if(info[0] not in allstocks and info[0][1:].isalpha()):
			count+=1
			allstocks.append(info[0])
			final.write(info[0].strip()+ "\",\"" + info[1].strip() + "\",\"" + exchange + "\",\"" + info[6].strip() + "\",\"" + info[7].strip() + "\"" + "\n")
final.close()

print(str(count) + " records cleaned up in all files.")