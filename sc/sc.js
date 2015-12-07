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
 * @param autoRender boolean should the widget render automatically
 * @param config object with config values
 * @return void
 */
var SC = function(autoRender,config) {

	// autoRender
	this._autoRender = (autoRender===true);
	// config
	this._config = (!!config && (typeof config).toLowerCase() == 'object') ? config : undefined;
	// jQuery
	this._$ = ('undefined'==typeof jQuery) ? -1 : jQuery;
	// theme data
	this._themeData = {};
	// notification data
	this._notificationData = {};


	/*
	 * ini
	 * initializes the app
	 *
	 * @return false if failure
	 */
	this.ini = function() {

		// make sure jQuery is loaded
		if(this._$ == -1 || typeof this._$ == 'undefined') {
			console.error('Snake Charmer Relies on jQuery. Please include jQuery library on your web page');
			return false;
		}

		// mandatory config vars
		var conf = ['pageUri','license','themeId'];
		// make sure all config is correct
		for(var i in conf) {
			if(!(conf[i] in this._config)) {
				console.warn('Invalid configuration detected. Please see documentation to include all config values for Snake Charmer. Using default config');
				this._config = undefined;
				break;
			}
		}
		// set default config if undefined
		if(typeof this._config == 'undefined') {
			this._config = this.getDefaultConfig();
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
		if('undefined'==typeof u) {
			console.error('Invalid ajax url');
			return false;
		}
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

		return true;
	};



	/*
	 * getThemeData
	 * gets the theme data for the widget
	 *
	 * @return void
	 */
	this.getThemeData = function() {
	};



	/*
	 * getNotifData
	 * gets notification, event, and page data
	 *
	 * @reutn void
	 */
	this.getNotifData = function() {
	};



	/*
	 * setUpTheme
	 * sets the theme up and renders the
	 * defined elements
	 *
	 * @return void
	 */
	this.setUpTheme = function() {
	};



	/*
	 * setUpEvents
	 * sets up events and the notifications to be displayed
	 *
	 * @return void
	 */
	this.setUpEvents = function() {
	};


};
// END SC
