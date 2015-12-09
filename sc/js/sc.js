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
	this._config = (!!config && (typeof config).toLowerCase() == 'object') ? config : {};
	// jQuery
	this._$ = ('undefined'==typeof jQuery) ? -1 : jQuery;
	// theme data
	this._themeData = {};
	// notification data
	this._notificationData = {};
	// html for widget
	this._widget = (this._$ === -1) ? '': this._$('<div id="SCWidget" class="sc_main"></div>');
	// tracks widget status
	this._widgetDisplayed = false;
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

		// insert css for SC
		this.installCss(document);

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
				console.info('Using default configuration for Snake Charmer');
				this._config = undefined;
				break;
			}
		}

		// set default config if undefined
		if(typeof this._config == 'undefined') {
			this._config = this.getDefaultConfig();
		} else {
			// let user override page URI for now
			this._config.pageUri = (!!this._config.pageUri && this._config.pageUri.length > 0) ? this._config.pageUri : loc.protocol+'//'+loc.hostname+loc.pathname;
		}


		this.getThemeData();
		this.getNotifData();

		console.log(this);
	};




	/*
	 * installCss
	 * installs snake charmer css
	 *
	 * @param d document
	 * @return void
	 */
	this.installCss = function(d) {
		var ns = d.createElement('link'); ns.type = 'text/css'; ns.rel = 'stylesheet';
		ns.href = d.location.protocol+'//www.barnescode.com/sc/css/style.css';
		var es = d.getElementsByTagName('link')[0]; es.parentNode.insertBefore(ns, es);
	};




	/*
	 * getDefaultConfig
	 * gets default configuration values for app
	 *
	 * @return object of config vars and values
	 */
	this.getDefaultConfig = function() {

		var ret = {}; // config to return

		// get src of SCJS file so we can parse for configuration
		var tmpuri = this._$('#SCJS').attr('src');
		var pieces = tmpuri.split('?')[1].split('&');
		var tmp = [];
		for(var p in pieces) {
			tmp = pieces[p].split('=');
			ret[tmp[0]] = tmp[1];
		}
		ret.pageUri = window.location.protocol+'//'+window.location.hostname+window.location.pathname;

		console.log(ret);
		return ret;
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
		this.ajax(this._config.getNotifDataUri,{page:this._config.pageUri,license:this._config.license},function() { console.log('err'); }, function(d) { me.setUpEvents(d); });
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
		var tmpstr = '', tmp, outter_class = 'chatbox', set_inner_html = true, show_closer = true;

		for(var x in this._themeData.elements) {
			 tmp = this._themeData.elements[x];

			if(tmp.ElmTag == 'img') { // NOTE could add more elm types in this condition
				outter_class = 'icon';
				set_inner_html = false;
				show_closer = false;
			}

			this._widget.append($('<div></div>').addClass(outter_class).attr('id', outter_class+'_'+x.toString()));
			if(tmp.ElmUseCloseTag == 1) {
				tmpstr = '<'+tmp.ElmTag+' id="'+tmp.ElmId+'"></'+tmp.ElmTag+'>';
			} else {
				tmpstr = '<'+tmp.ElmTag+' id="'+tmp.ElmId+'" />';
			}
			this._widget.find('#'+outter_class+'_'+x.toString()).append(tmpstr);
			/* TODO
			 * 		add in style, height, width shit here
			 */
			if(tmp.ElmShowCount > 0) {
				this._widget.find('#icon_'+x.toString()).append($('<div class="notification"><small>0</small></div>'));
			}

			if(set_inner_html) {
				this._widget.find(tmp.ElmId).html((tmp.ElmInnerHtml===null)?'':tmp.ElmInnerHtml);
			}

			if(show_closer) {
				this._widget.find('#chatbox_'+x.toString()).append($('<div class="closer"><i class="fa fa-close"></i></div>'));
			}


			// ADD ATTRIBUTES
			for(var y in this._themeData.attributes) {
				var ytmp = this._themeData.attributes[y];
				if(ytmp.ElmRecordId == tmp.ElmRecordId) {
					this._widget.find('#'+tmp.ElmId).attr(ytmp.ElmAttribute,ytmp.ElmAttributeValue);
					//this._themeData.attributes.splice(y,1); // remove from array so we are eliminating attribes as we use them
				}
			}
			// END ATTRIBUTES
		}
		// clean up
		delete this._themeData.attributes;
	};



	/*
	 * setUpEvents
	 * sets up events and the notifications to be displayed
	 *
	 * @return void
	 */
	this.setUpEvents = function(d) {
		/* TODO add in page verification */
		this._notificationData = d;
		// reference for callback function when triggering event
		var me = this;

		// identifiers
		var identifiers = {
			id: '#',
			class: '.',
			tag: '',
		}
		// tmp object
		var tmp;
		// action list
		var action_list = [];
		// join string of action list
		var action_str = '';
		// notification list
		var notification_list = [];

		// iterate through all events to set everything up
		for(var x in this._notificationData.page_event) {
			tmp = this._notificationData.page_event[x];

			var splices = []; // so we can eliminate actions for the next iteration
			// iterate through actions see if they are for this event
			for(var y in this._notificationData.actions) {
				// check event IDs
				if(this._notificationData.actions[y].EID == tmp.EID) {
					action_list.push(this._notificationData.actions[y].EAction);
					splices.push(y);
				}
			}
			// remove the actions we are using already
			for(var i in splices) {
				this._notificationData.actions.splice(splices[i],1);
			}
			// clecn this array
			splices = undefined;

			action_str = action_list.join(', ');

			// iterate through notifications and find their links
			for(var j in this._notificationData.notifications) {
				this._notificationData.notifications[j].links = []; // will need to add links to appropriate notif
				var link_splices = []; // to clean up for the next round so it wont iterate through as many
				// only add if event ids match
				if(this._notificationData.notifications[j].EID == tmp.EID) {
					// iterate through links to check for their notification id
					for(var n in this._notificationData.links) {

						// validate notification
						if(this._notificationData.links[n].NID == this._notificationData.notifications[j].NID) {
							this._notificationData.notifications[j].links.push(this._notificationData.links[n].LinkUri);
							link_splices.push(n);
						}

					} // END for loop for links

					// remove items from link array
					for(var m in link_splices) {
						this._notificationData.links.splice(link_splices[m],1);
					}
					// clean array
					link_splices = undefined;

					// push the object to the notification list to pass into event function
					notification_list.push(this._notificationData.notifications[j]);
				}

			} // END for loop for notifications

			this._$(identifiers[tmp.EIdentifier]+tmp.EAttrVal).on(action_str, function() {
				me.triggerEvent(tmp.EID, notification_list);
			});

		} // END for loop for events
	};



	/*
	 * triggerEvent
	 * triggers event with appropriate shit
	 *
	 * @param eid event id int
	 * @param notifs array of notification objects
	 * @return void
	 */
	this.triggerEvent = function(eid, notifs) {
		// record the event triggering
		if(!this.eventTriggered(eid)) {
			console.warn('Failed to record triggered event [ '+eid+' ]');
		}

		console.log(arguments);

		window.SC_EID = eid;
		window.SC_NOTIFS_CACHE = notifs;

		var has_notifs = false;
		for(var i in notifs) {
			if(notifs[i].NID > 0 && (!!notifs[i].NBody || !!notifs[i].NMedia || !!notifs[i].NTitle)) {
				has_notifs = true;
			} else {
				console.error('Invalid notification list passed to triggerEvent');
				console.log(notifs[i]);
			}
		}

		if(has_notifs) {
			this._widget.find('.chatbox span,.chatbox p, .chatbox input, .chatbox label').text(notifs[0].NBody || notifs[0].NTitle || 'View message...');
			this._widget.find('.notification small').text(notifs.length.toString());
		}

		if(!this._widgetDisplayed) {
			this.renderWidget();
		}

		var me = this;
		this._$('.closer').on('click', function() {
			me.removeWidget();
		});
		this._$('.sc_main').on('click', function() {
			console.log('-----------');
			console.log(notifs);
			me.viewNotifications(eid, notifs);
		});
	};




	/*
	 * renderWidget
	 * renders the widgeth
	 */
	this.renderWidget = function() {
		if(this._widgetDisplayed) {
			console.warn('Widget is already displayed. Function trying to render widget: '+arguments.callee.caller.name);
			console.info(this); // show the state of the app for debug
			return false;
		}
		this._$('body').append(this._widget);
		this._widgetDisplayed = true;

		return true;
	};




	/*
	 * removeWidget
	 * removes the widget from page
	 */
	this.removeWidget = function() {
		if(!this._widgetDisplayed) {
			console.warn('Widget is already removed. Function trying to remove widget: '+arguments.callee.caller.name);
			console.info(this); // show state of the app for debug
			return false;
		}
		$('#SCWidget').remove();
		this._widgetDisplayed = false;
		return true;
	}



	/*
	 * viewNotifications
	 * opens side bar and stuff
	 *
	 * @param event id
	 * @param list of notifications
	 * @return void
	 */
	this.viewNotifications = function(e,n) {
		console.log(arguments);
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
		console.error('Ajax failure... contact support or whatever');
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




	/*
	 * eventTriggered
	 * records an event being triggered
	 *
	 * @param event id
	 * @return false if failure
	 */
	this.eventTriggered = function(e) {
		console.log(e);
	};




};
// END SC
// auto initialize
$(document).ready(function() {
	if(typeof window.SC_AUTO_INIT == 'undefined' || window.SC_AUTO_INIT !== false) {
		(window.SC = new SC()).ini();
	}
});
// end auto initialize
