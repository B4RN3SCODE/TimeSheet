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
	// jQuery
	this._$ = ('undefined'==typeof jQuery || 'undefined' == $) undefined : $;



	/*
	 * ini
	 * initializes the app
	 *
	 * @return false if failure
	 */
	this.ini = function() {
		// make sure jQuery is loaded
		if(typeof this._$ == undefined) {
			console.error('Snake Charmer Relies on jQuery. Please include jQuery library on your web page');
			return false;
		}


	};



	/*
	 * getDefaultConfig
	 * gets default configuration values for app
	 *
	 * @return object of config vars and values
	 */
	this.getDefaultConfig = function() {
		var loc = window.location;
		return {
			pageUri: loc.protocol+'//'+loc.hostname+loc.pathname,
			license: '',
			themeId: 0,

		}
	};



	/*
	 * ajax
	 * ajax functionality for the app
	 *
	 * @param url string target url
	 * @param data object of data to send
	 * @param type string type of request default POST
	 * @param err function to execute on error
	 * @param succ function to exectue on success
	 * @return true if successful
	 */
	this.ajax = function(url, data, type, err, succ) {
		var u = (!!url && url.replace(/\ /g,'').length > 0) ? url : undefined;
		var d = data;
		var t = (type.toUpperCase() == 'POST' || type.toUpperCase() == 'GET') ? type.toUpperCase() : 'POST';
		var e = err;
		var s = succ;

		this._$.ajaxSetup({
			cache: false,
			headers: {
				'Cache-Control': 'no-cache, no-store, must-revalidate'
			}
		});
		this._$.ajax({
			url: u, data: d, type: t, error: e,	success: function(d) { s(d); }
		});
	};
};
// END SC
