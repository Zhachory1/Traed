
import sys, os, random, requests, urllib2, json, time, datetime, MySQLdb, getDailyQuotes, atr, cc, cci, ema_sma, final, first, g1, g2, g3, industry, macd, nic, pivots, roc, rsi, sd, stoch, subsector, init
from __future__ import print_function
from multiprocessing import Process

#############################################
# Zero Step									#
#	Init rows for database					#
#	create dictionary with stock_id for key #
#	and ids from basic, short, mid, long, 	#
#	and final for stocks					#
#											#
#	Store basic data in dictionary			#
#############################################
# Create rows and get ids and their corresponding stock_id in tuples, 
#	Use it to pass to these all of these functions
# Structure
#	{
#		stock_id: {
#			nic:		num,  	|create: nic, 		del: end
#			cc:			num,	|create: cc, 		del: end
#			basic_id:	num,	|create: getDQ,		del: end
#			short_id:	num,	|create: getDQ, 	del: end
#			mid_id:		num,	|create: getDQ, 	del: end
#			long_id:	num,	|create: getDQ, 	del: end
#			final_id:	num,	|create: getDQ, 	del: end
#			basic_data:	{
#				open: 		[1-25],		|create: getDQ, 	del: end
#				close:		[1-50],		|create: getDQ, 	del: end
#				high:		[H,HH],		|create: getDQ, 	del: end
#				low:		[L,LL],		|create: getDQ, 	del: end
#				volume:		num 		|create: getDQ, 	del: end
#			}	
#			short_data: {	
#				sd: 		num,		|create: nic, 		del: end
#				s1: 		num,		|create: nic, 		del: end
#				s2: 		num,		|create: nic, 		del: end
#				r1: 		num,		|create: nic, 		del: end
#				r2: 		num,		|create: nic, 		del: end
#				tp: 		num,		|create: nic, 		del: end
#				perK: 		num,		|create: nic, 		del: end
#				perD: 		num,		|create: nic, 		del: end
#				ema1: 		num,		|create: nic, 		del: end
#				sma1: 		num,		|create: nic, 		del: end
#				md: 		num,		|create: nic, 		del: end
#				cci: 		num,		|create: nic, 		del: end
#				tr: 		num,		|create: nic, 		del: end
#				atr: 		num,		|create: nic, 		del: end
#				roc: 		num,		|create: nic, 		del: end
#				rsi: 		num,		|create: nic, 		del: end
#				ema_macd1: 	num,		|create: nic, 		del: end
#				ema_macd2: 	num,		|create: nic, 		del: end
#				macd: 		num,		|create: nic, 		del: end
#				signal: 	num,		|create: nic, 		del: end
#				macd-h: 	num,		|create: nic, 		del: end
#				g1: 		num,		|create: nic, 		del: end
#				g2: 		num,		|create: nic, 		del: end
#				g3: 		num,		|create: nic, 		del: end
#				first: 		num 		|create: nic, 		del: end
#			},	
#			mid_data: {
#				*same as short_data*
#			},
#			long_data: {
#				*same as short_data*
#			}
#		},
#		...
#	}
#
# UPDATE `traed`.`tablename` SET `column`='value' WHERE `id`='id';

if __name__ == '__main__':
	data = {}

	#############################################
	# First Step								#
	#	getDailyQuotes, Nic, CC 				#
	#############################################
	processes = []
	p = Process(target=getDQ, args=(data,))
	p.start()
	processes.append(p)
	p = Process(target=nic)
	p.start()
	processes.append(p)
	p = Process(target=cc)
	p.start()
	processes.append(p)
	for p in processes:
		p.join()

	#############################################
	# Second Step								#
	#	ShortTerm								#
	#		SMA_EMA, ROC, SD, MACD, CCI, Pivots #
	#		RSI, ATR, Stoch 					#
	#############################################
	processes = []
	p = Process(target=ema_sma, args=(7, 14, "short_term", short_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=roc, args=(6, "short_term", short_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=sd, args=(14, "short_term", short_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=macd, args=(6, 13, 3, "short_term", short_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=cci, args=(10, "short_term", short_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=pivots, args=(1, "short_term", short_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=rsi, args=(7, "short_term", short_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=atr, args=(14, "short_term", short_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=stoch, args=(1, "short_term", short_id, basic_id))
	p.start()
	processes.append(p)
	for p in processes:
		p.join()

	#############################################
	# Third Step								#
	#	MidTerm									#
	#		SMA_EMA, ROC, SD, MACD, CCI, Pivots #
	#		RSI, ATR, Stoch 					#
	#	ShortTerm								#
	#		G1, G2, G3 							#
	#############################################
	processes = []
	p = Process(target=ema_sma, args=(14, 25, "mid_term", mid_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=roc, args=(15, "mid_term", mid_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=sd, args=(20, "mid_term", mid_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=macd, args=(12, 26, 9, "mid_term", mid_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=cci, args=(20, "mid_term", mid_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=pivots, args=(7, "mid_term", mid_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=rsi, args=(14, "mid_term", mid_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=atr, args=(20, "mid_term", mid_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=stoch, args=(2, "mid_term", mid_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=g1, args=("short_term", short_id))
	p.start()
	processes.append(p)
	p = Process(target=g2, args=("short_term", short_id))
	p.start()
	processes.append(p)
	p = Process(target=g3, args=("short_term", short_id))
	p.start()
	processes.append(p)
	for p in processes:
		p.join()

	#############################################
	# Fourth Step								#
	#	LongTerm								#
	#		SMA_EMA, ROC, SD, MACD, CCI, Pivots #
	#		RSI, ATR, Stoch 					#
	#	ShortTerm 								#
	#		first, final						#
	#	subsector, industry						#
	#############################################
	processes = []
	p = Process(target=ema_sma, args=(25, 50, "long_term", long_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=roc, args=(30, "long_term", long_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=sd, args=(50, "long_term", long_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=macd, args=(24, 32, 18, "long_term", long_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=cci, args=(50, "long_term", long_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=pivots, args=(30, "long_term", long_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=rsi, args=(25, "long_term", long_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=atr, args=(50, "long_term", long_id, basic_id))
	p.start()
	processes.append(p)
	p = Process(target=stoch, args=(3, "long_term", long_id, basic_id))
	p.start()
	processes.append(p)
	first("short_term", short_id);
	final(1)
	for p in processes:
		p.join()

	p = Process(target=subsector)
	p.start()
	processes.append(p)
	p = Process(target=industry)
	p.start()
	processes.append(p)
	for p in processes:
		p.join()

	#############################################
	# Fifth Step								#
	#	LongTerm, Mid term						#
	#		G1, G2, G3 							#
	#############################################
	processes = []
	p = Process(target=g1, args=("long_term", long_id))
	p.start()
	processes.append(p)
	p = Process(target=g2, args=("long_term", long_id))
	p.start()
	processes.append(p)
	p = Process(target=g3, args=("long_term", long_id))
	p.start()
	processes.append(p)
	p = Process(target=g1, args=("mid_term", mid_id))
	p.start()
	processes.append(p)
	p = Process(target=g2, args=("mid_term", mid_id))
	p.start()
	processes.append(p)
	p = Process(target=g3, args=("mid_term", mid_id))
	p.start()
	processes.append(p)
	for p in processes:
		p.join()

	#############################################
	# Sixth Step								#
	#	LongTerm, MidTerm						#
	#		first, final						#
	#############################################
	processes = []
	p = Process(target=first, args=("mid_term", mid_id))
	p.start()
	processes.append(p)
	p = Process(target=first, args=("long_term", long_id))
	p.start()
	for p in processes:
		p.join()

	processes = []
	p = Process(target=final, args=(2))
	p.start()
	processes.append(p)
	p = Process(target=final, args=(3))
	p.start()
	processes.append(p)
	for p in processes:
		p.join()
