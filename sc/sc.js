/*
 * SC
 * Snake Charmer Application
 *
 * @author		Tyler J Barnes
 * @contact		b4rn3scode@gmail.com
 * @version		1.0
 * @doc			www.barnescode.com/sc/README.txt
 */

// strict mode
'use strict';

/*
 * main object
 *
 * @param config object with config values
 * @return void
 */
var SC = function(config) {

	// config
	this._config = (!!config && (typeof config).toLowerCase() == 'object') ? config : undefined;

	this.ini = function() {
	};

	this.getDefaultConfig = function() {
		var loc = window.location;
		return {
			pageUri: loc.protocol+'//'+loc.hostname+loc.pathname,
		}
	};
};
// END SC
