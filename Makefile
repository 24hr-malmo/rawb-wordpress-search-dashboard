clear:
	rm -rf ./js/dist
	rm -rf ./js/build

install: 
	rm -rf ./js/node_modules
	(cd js && npm i)

dev: clear
	(cd js && npm run dev)

production: clear
	(cd js && npm run production)
