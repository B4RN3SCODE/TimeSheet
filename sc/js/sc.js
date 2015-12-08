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
	// html for widget
	this._widget = $('<div id="SCWidget" class="sc_main"></div>');
	// default getThemeUri
	this._defaultGetThemeUri = 'http://www.barnescode.com/sc/include/getTheme.php';
	// default getNotifDataUri
	this._defaultGetNotifDataUri = 'http://www.barnescode.com/sc/include/getNotifData.php';


	/*
	 * ini
	 * initializes the app
	 *
	 * @return false if failure
	 */
	this.ini = function() {
		var loc = window.location;

		// make sure jQuery is loaded
		if(this._$ == -1 || typeof this._$ == 'undefined') {
			console.error('Snake Charmer Relies on jQuery. Please include jQuery library on your web page');
			return false;
		}

		// mandatory config vars
		var conf = ['license','themeId'];
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
		} else {
			this._config.pageUri = loc.protocol+'//'+loc.hostname+loc.pathname;
		}



	};



	/*
	 * getDefaultConfig
	 * gets default configuration values for app
	 *
	 * @return object of config vars and values
	 */
	this.getDefaultConfig = function() {
		return {
			pageUri: window.location.protocol+'//'+window.location.hostname+window.location.pathname,
			license: '',
			themeId: 0,
		}
	};



	/*
	 * ajax
	 * ajax functionality for the app
	 * feel free to pass these parameters to the function
	 * in any manner you want to... any order.  the logic
	 * will figure out what each parameter is.
	 *
	 * error callback function is not to be passed because
	 * the framework will automatically handle an ajax error
	 * only a success function is available to be overwritten,
	 * otherwise the default ajax callback will be used
	 *
	 * @param url string target url
	 * @param data object of data to send
	 * @param type string type of request default POST *NOT REQUIRED*
	 * @param succ function to exectue on success
	 * @return true if successful
	 */
	this.ajax = function() {
		var args = arguments, u, d, t, e, s, has_data = false;

		if(args.length < 2) {
			console.error('Invalid arguments passed to ajax function. Required: target_url, data_to_send');
			return false;
		}

		for(var i in args) {

			if('object' == (typeof args[i]).toLowerCase()) {
				for(var p in args[i]) {
					has_data = true;
					break;
				}
				d = args[i];
				if(!has_data) {
					console.warn('No data passed to SC.ajax function [empty object]. Sending request with no data');
				}


			} else if('function' == (typeof args[i]).toLowerCase()) {

				s = args[i];

			} else if('string' == (typeof args[i]).toLowerCase()) {

				if(args[i].toUpperCase() == 'POST' || args[i].toUpperCase() == 'GET') {
					t = args[i].toUpperCase();
				} else if(this.validUrl(args[i])) {
					u = args[i];
				}


			}
		}

		e = this.defaultAjaxErrCb;
		t = (!t || t == null || t == undefined || typeof t == 'undefined') ? 'POST' : t;
		s = (!s || s == null || s == undefined || typeof s == 'undefined') ? this.defaultAjaxSuccCb : s;

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
		if(!this._config.getThemeUri || typeof this._config.getThemeUri == 'undefined') {
			this._config.getThemeUri = this._defaultGetThemeUri;
		}
		var me = this;
		this.ajax(this._config.getThemeUri,{theme:this._config.themeId,license:this._config.license},function() { console.log('err'); }, function(d) { me.setUpTheme(d); });

	};



	/*
	 * getNotifData
	 * gets notification, event, and page data
	 *
	 * @reutn void
	 */
	this.getNotifData = function() {
		if(!this._config.getNotifDataUri || typeof this._config.getNotifDataUri == 'undefined') {
			this._config.getNotifDataUri = this._defaultGetNotifDataUri;
		}
		var me = this;
		this.ajax(this._config.getNotifDataUri,{theme:this._config.themeId,license:this._config.license},function() { console.log('err'); }, function(d) { me.setUpEvents(d); });
	};



	/*
	 * setUpTheme
	 * sets the theme up and renders the
	 * defined elements
	 *
	 * @return void
	 */
	this.setUpTheme = function(d) {
		this._themeData = d;

		for(var x in this._themeData.elements) {
			var tmp = this._themeData.elements[x];

			if(tmp.ElmTag == 'img') { // NOTE could add more elm types in this condition

				this._widget.append($('<div></div>').addClass('icon').attr('id', 'icon_'+x.toString()));
				this._widget.find('#icon_'+x.toString()).append($('<'+tmp.ElmTag+' id="'+tmp.ElmId+'"'+(tmp.ElmUseCloseTag > 0)?'></'+tmp.ElmTag+'>':' />'));
				/* TODO
				 * 		add in style, height, width shit here
				 */
				if(tmp.ElmShowCount > 0) {
					this._widget.find('#icon_'+x.toString()).append($('<div class="notification"><small>0</small></div>'));
				}

			} // end image, icon whatever else we may add later idk

			else { // text items or whatever

				this._widget.append($('<div></div>').addClass('chatbox').attr('id', 'chatbox_'+x.toString())); console.log(1);
				this._widget.find('#chatbox_'+x.toString()).append('<'+tmp.ElmTag+' id="'+tmp.ElmId+'"'+(tmp.ElmUseCloseTag > 0)?'></'+tmp.ElmTag+'>':' />');console.log(2);
				this._widget.find('#chatbox_'+x.toString()).html((tmp.ElmInnerHtml===null)?'':tmp.ElmInnerHtml);console.log(3);

			}

			// ADD ATTRIBUTES
			for(var y in this._themeData.attributes) {
				var ytmp = this._themeData.attributes[y];
				if(ytmp.ElmRecordId == tmp.ElmRecordId) {
					this._widget.find('#'+tmp.ElmId).attr(ytmp.ElmAttribute,ytmp.ElmAttributeValue);
					//this._themeData.attributes.splice(y,1); // remove from array so we are eliminating attribes as we use them
				}
			}
			// clean up
			delete this._themeData.attributes;
			// END ATTRIBUTES
			console.log(this._widget);
			return false;
		}
	};



	/*
	 * setUpEvents
	 * sets up events and the notifications to be displayed
	 *
	 * @return void
	 */
	this.setUpEvents = function(d) {
		console.log(d);
	};



	/*
	 * renderWidget
	 * renders the widgeth
	 */
	this.renderWidget = function() {
	};




	/*
	 * defaultAjaxSuccCb
	 * decides what to do by default with ajax data
	 * on success
	 *
	 * @param d data from ajax handler
	 * @return void
	 */
	this.defaultAjaxSuccCb = function(d) {
		console.log(d);
	};


	/*
	 * defaultAjaxErrCb
	 * default ajax error callback
	 *
	 * @return void
	 */
	this.defaultAjaxErrCb = function() {
	};



	/*
	 * getParamNames
	 * gets parameters for a given function
	 *
	 * @param func function to get the param of
	 * @return array of functions
	 */
	this.getParamNames = function(func) {
		var regx = /([^\s,]+)/g;
		var funcStr = func.toString().replace(/((\/\/.*$)|(\/\*[\s\S]*?\*\/))/mg,'');
		var result = funcStr.slice(funcStr.indexOf('(')+1, funcStr.indexOf(')')).match(regx);

		return (result === null) ? [] : result;
	};



	/*
	 * validUrl
	 * checks if param is a valid url
	 *
	 * @param u url to check
	 * @return true if valid url
	 */
	this.validUrl = function(u) {
		u = u.replace(/https\:\/\/|http\:\/\//g,'');
		var regx = /[-a-zA-Z0-9\:\%\.\_\+\~\#\=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9\:\%\_\+\.\~\#\?\&\/\/\=]*)/;
		var result = u.match(regx);

		return (result != null && result.length > 0);
	};



};
// END SC
