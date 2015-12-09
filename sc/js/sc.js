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
	// sidebar
	this._sidebar = (this._$ === -1) ? '': this._$('<div id="SCSB" class="sc_main"><div class="bigchat"><div class="header"><div class="name"></div><div class="time"></div><div id="ChatClose" class="close"><i class="fa fa-close"></i></div></div><div class="primarychat"></div></div></div>');
	// tracks widget status
	this._widgetDisplayed = false;
	// tracks sidebar status
	this._sidebarDisplayed = false;
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
		this.installJsCss(document);

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

	};




	/*
	 * installCss
	 * installs snake charmer css
	 *
	 * @param d document
	 * @return void
	 */
	this.installJsCss = function(d) {
		this._$('head').append('<link type="text/css" rel="stylesheet" href="http://www.barnescode.com/sc/css/style.css"><script src="//www.barnescode.com/sc/js/autosize.min.js"></script>');
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

			this.triggerEvent(identifiers[tmp.EIdentifier]+tmp.EAttrVal,action_str,tmp.EID,notification_list);

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
	this.triggerEvent = function(idnt, act_str, eid, notifs) {
		var me = this;
		this._$(idnt).on(act_str, function() {
			console.log('triggering event: '+eid.toString());

			// record the event triggering
			if(!me.eventTriggered(eid)) {
				console.warn('Failed to record triggered event [ '+eid+' ]');
			}

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
				me._widget.find('.chatbox span,.chatbox p, .chatbox input, .chatbox label').text(notifs[0].NBody || notifs[0].NTitle || 'View message...');
				me._widget.find('.notification small').text(notifs.length.toString());
			}

			if(!me._widgetDisplayed) {
				me.renderSc('widget');
			}

			me._$('.closer').on('click', function() {
				me.removeSc('widget');
			});
			me._$('.sc_main').on('click', function() {
				me.removeSc('widget');
				me.viewNotifications(eid, notifs);
			});
		});
	};




	/*
	 * viewNotifications
	 * opens side bar and stuff
	 *
	 * @param event id
	 * @param list of notifications
	 * @return void
	 */
	this.viewNotifications = function(e,n) {
		this._sidebar.find('.bigchat .header .name').text(this._themeData.sidebar.SBTitle);
		this._sidebar.find('.bigchat .header .time').text('just now'); // lazy as fuck right now

		var ids = [];
		var d, ts; // date object, time string
		for(var i in n) {

			if(n[i].EID != e) {
				continue;
			}

			ids.push(n[i].NID);
			d = new Date();
			ts = d.getHours().toString()+':'+d.getMinutes().toString();

			/*
			 * TODO
			 * 		check if any Style attributes are set in
			 * 		SC._themeData.sidbar and use inline
			 * 		css as STYLE attributes so users can restyle shit
			 * 		-----do so in this mess somewhere:
			 */


			this._sidebar.find('.primarychat').append(this._$('<div></div>').attr('id', 'ml'+i.toString()).addClass('message').addClass('left'));
			this._sidebar.find('.primarychat').append(this._$('<div></div>').addClass('timestamp').text(ts));
			this._sidebar.find('#ml'+i.toString()).append('<div class="icon"><img src="'+this._themeData.sidebar.SBImg+'" /></div>');
			this._sidebar.find('#ml'+i.toString()).append(this._$('<div></div>').attr('id', 'cb'+i.toString()).addClass('chatbubble'));

			if(!!n[i].NTitle) {
				this._sidebar.find('#cb'+i.toString()).append(this._$('<p></p>').text(n[i].NTitle));
			}
			if(!!n[i].NMedia) {
				this._sidebar.find('#cb'+i.toString()).append(n[i].NMedia);
			}
			if(!!n[i].NBody) {
				this._sidebar.find('#cb'+i.toString()).append(this._$('<p></p>').text(n[i].NBody));
			}
		}

		if(!this.notificationSeen(ids)) {
			console.warn('Failed to record seen notifications');
			console.log(ids);
		}

		ids = d = ts = undefined; // clean up

		var me = this;

		if(!this._sidebarDisplayed) {
			this.renderSc('sidebar');
		}

		this._$('#ChatClose').on('click', function() {
			me.removeSc('sidebar');
		});

		this._$('body').append('<script id="tmpScScr">autosize(document.querySelectorAll("textarea"));</script>');
	};




	/*
	 * renderSc
	 * renders the widgeth
	 *
	 * @param rend string 'widget' or 'sidebar'
	 */
	this.renderSc = function(rend) {
		if((rend === 'widget' && this._widgetDisplayed) || (rend === 'sidebar' && this._sidebarDisplayed)) {
			console.warn(rend+' is already displayed. Function trying to render it: '+arguments.callee.caller.name);
			return false;
		}
		var attr = '_'+rend, dattr = '_'+rend+'Displayed';
		this._$('body').append(this[attr]);
		this[dattr] = true;

		return true;
	};




	/*
	 * removeSc
	 * removes the widget from page
	 */
	this.removeSc = function(rend) {
		if((rend === 'widget' && !this._widgetDisplayed) || (rend === 'sidebar' && !this._sidebarDisplayed)) {
			console.warn(rend+' is already removed. Function trying to remove it: '+arguments.callee.caller.name);
			return false;
		}
		var i = (rend === 'widget') ? '#SCWidget':'#SCSB';
		var dattr = '_'+rend+'Displayed';
		$(i).remove();
		$('#tmpScScr').remove();
		this[dattr] = false;

		// reset the sidebar
		if(rend === 'sidebar') {
			this._sidebar = (this._$ === -1) ? '': this._$('<div id="SCSB" class="sc_main"><div class="bigchat"><div class="header"><div class="name"></div><div class="time"></div><div id="ChatClose" class="close"><i class="fa fa-close"></i></div></div><div class="primarychat"></div></div></div>');
		}

		return true;
	}




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




	/*
	 * notificationSeen
	 * records when notification is seen
	 *
	 * @param array of notification ids
	 * @return false if fails
	 */
	this.notificationSeen = function(nids) {
		console.log(nids);
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
