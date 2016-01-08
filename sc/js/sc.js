/*
 * SC
 * Snake Charmer Application
 *
 * @author		Tyler J Barnes
 * @contact		b4rn3scode@gmail.com
 * @version		1.0
 */

/*+++++++++++++++++++++++++++++++++++++++++++++++++++++/
 * Change Log | todo list
 *
 * 20160108	Tyler J Barnes
 *  - TODO
 * 		Use generated (temp) uid to handle events triggered
 * 		and seen notification storing
 *
 *  - TODO
 * 		Cookie handling for new generated uid
 *
 *
 *++++++++++++++++++++++++++++++++++++++++++++++++++++*/


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
	this._widget = (this._$ === -1) ? '': this._$('<div id="SCWidget" class="sc_main" style="z-index:999;"></div>');
	// rewrite cache
	this._widgetElmsRemoved = [];
	// sidebar
	this._sidebar = (this._$ === -1) ? '': this._$('<div id="SCSB" class="sc_main" style="z-index:999;"><div class="bigchat"><div id="ChatClose" class="header"><div class="name"></div><div class="time"></div><div class="close">Close</div></div><div class="primarychat"></div></div></div>');
	// tracks the state of whats displayed
	this._displayState = { widget: false, sidebar: false };
	// default getThemeUri
	this._defaultGetThemeUri = '//www.conversionvoodoo.com/sc/include/getTheme.php';
	// default getNotifDataUri
	this._defaultGetNotifDataUri = '//www.conversionvoodoo.com/sc/include/getNotifData.php';
	// default eventTriggered url
	this._defaultEventTriggeredUri = '//www.conversionvoodoo.com/sc/include/eventTriggered.php';
	// default notifSeen url
	this._defaultNotifSeenUri = '//www.conversionvoodoo.com/sc/include/notifSeen.php';

	// notification sound location
	//		** note: to change this, after using SC_AUTO_INIT = false to
	//			prevent the app from auto initializing, set SC._notificationSoundFile
	//			to point to the new sound location -- then do SC.ini()
	this._notificationSoundFile = '//www.conversionvoodoo.com/sc/media/notif.mp3';
	// audio object to play
	this._audio = null;

	// cookie name(s) & stuff
	this._eventCookieName = 'snevdat';
	this._defaultCookieExpire = 10; // days

	// events manual trigger... dont store trigger or write cookies
	this._dispatchedCodes = [];



	/*
	 * ini
	 * initializes the app
	 *
	 * @return false if failure
	 */
	this.ini = function() {
		var loc = window.location;

		// insert css for SC
		this.installJsCss();

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

		// init audio obj
		this._audio = new Audio(this._notificationSoundFile);

		this.getThemeData();

	};




	/*
	 * installCss
	 * installs snake charmer css
	 *
	 * @param d document
	 * @return void
	 */
	this.installJsCss = function() {
		this._$('head').append('<link type="text/css" rel="stylesheet" href="//www.conversionvoodoo.com/sc/css/style.css"><script src="//www.conversionvoodoo.com/sc/js/autosize.min.js"></script>');
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

		var scriptParams = '?theme='+this._config.themeId+'&license='+this._config.license;

		this.addScript(document.location.protocol+this._config.getThemeUri+scriptParams, true);

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

		var scriptParams = '?page='+this._config.pageUri+'&license='+this._config.license;

		this.addScript(document.location.protocol+this._config.getNotifDataUri+scriptParams, true);

	};




	/*
	 * addScript
	 * adds a js script to document
	 *
	 * @param s string full source url
	 * @param asnc bool asyncronous
	 * @return void
	 */
	this.addScript = function(s, asnc) {

		if(!!s && this.validUrl(s)) {
			asnc = (asnc === true);

			var ns2 = document.createElement('script');
			ns2.type = 'text/javascript';
			ns2.async = asnc;
			ns2.src = s;
			var es2 = document.getElementsByTagName('script')[0];
			es2.parentNode.insertBefore(ns2, es2);

		}

	};




	/*
	 * setUpTheme
	 * sets the theme up and renders the
	 * defined elements
	 *
	 * @return void
	 */
	this.setUpTheme = function() {
		var hasData = false;
		for(var p in this._themeData) {
			hasData = true;
			break;
		}
		if(!hasData) {
			return false;
		}
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

		return true;
	};



	/*
	 * setUpEvents
	 * sets up events and the notifications to be displayed
	 *
	 * @return void
	 */
	this.setUpEvents = function(d) {
		var hasData = false;
		for(var p in this._notificationData) {
			hasData = true;
			break;
		}
		if(!hasData) {
			return false;
		}
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

			if(tmp.HasTriggered === true) {
				continue;
			}

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

				// iterate through links to check for their notification id
				for(var n in this._notificationData.links) {

					// validate notification
					if(this._notificationData.links[n].NID == this._notificationData.notifications[j].NID) {
						this._notificationData.notifications[j].links.push(this._notificationData.links[n].LinkUri);
					}

				} // END for loop for links

				// only add if event ids match
				if(this._notificationData.notifications[j].EID == tmp.EID) {
					// push the object to the notification list to pass into event function
					notification_list.push(this._notificationData.notifications[j]);
				}

			} // END for loop for notifications

			this.triggerEvent(identifiers[tmp.EIdentifier]+tmp.EAttrVal,action_str,tmp,notification_list);

		} // END for loop for events

		return true;
	};



	/*
	 * triggerEvent
	 * triggers event with appropriate shit
	 *
	 * @param eid event id int
	 * @param notifs array of notification objects
	 * @return void
	 */
	this.triggerEvent = function(idnt, act_str, e, notifs) {
		var eid = e.EID;
		var me = this;
		this._$(idnt).on(act_str, function() {

			if(e.HasTriggered === true) {
				return false;
			}
			e.HasTriggered = true;
			me.setEventCookie(eid);

			// record the event triggering
			if(!me.eventTriggered(e)) {
				console.warn('Failed to record triggered event [ '+eid+' ]');
			}

			var has_notifs = false, cnt = isNaN(parseInt($('body').find('.notification small').text())) ? 0:parseInt($('body').find('.notification small').text());
			for(var i in notifs) {

				if(notifs[i].NID > 0 && (!!notifs[i].NBody || !!notifs[i].NMedia || !!notifs[i].NTitle)) {

					if(notifs[i].EID == eid && notifs[i].HasSeen !== true)
						cnt++;


					has_notifs = true;

				} else {
					console.error('Invalid notification list passed to triggerEvent');
				}
			}

			var add_to_sidebar = (me._displayState.sidebar && has_notifs);

			if(has_notifs) {
				if(!add_to_sidebar) {
					for(var elm in me._widgetElmsRemoved) {
						me._widget.prepend(me._widgetElmsRemoved[elm]);
					}
					me._widgetElmsRemoved = []; // reset the list
					/* TODO
					* change this to an iteration of the IDs set up in setUpTheme so we can do .text to the correct notification element...
					* if there is more than one element set up in the them to display notif msg boxes or whatever, we need to fill them
					* ONLY if there are the same number (or more) notifications to be displayed
					*/
					me._widget.find('.chatbox span,.chatbox p, .chatbox input, .chatbox label').text(notifs[0].NBody || notifs[0].NTitle || 'View message...');
					me._widget.find('.notification small').text(cnt.toString());
				}
			}

			if(!add_to_sidebar) {
				if(!me._displayState.widget) {
					me.renderWidget(false);
				}

				if(cnt > 0) {
					me.playNotifSound();
				}

			} else {
				me.playNotifSound();
				me.viewNotifications(e, notifs,true);
				me.renderWidget(true);
			}

			me._$('.closer').on('click', function() {
				me._widgetElmsRemoved.push(me._$(this).parent());
				me._$(this).parent().remove();
			});
			me._$('#SCWidget .icon img, #SCWidget .chatbox:nth-child(1)').on('click', function() {
				me.removeWidget(true);
				me.viewNotifications(e, notifs,true);
			});

		});

		// if cookie set with event already triggered & in cookie then manually trigger the event
		if(this.manualTrigger(eid)) {
			this._dispatchedCodes.push(e.DispatchCode);

			var elst = act_str.split(',');
			for(var ev in elst) {
				setTimeout(function(){me._$(idnt).trigger(elst[ev].trim());},1000);
			}
		}


	};




	/*
	 * viewNotifications
	 * opens side bar and stuff
	 *
	 * @param event
	 * @param list of notifications
	 * @param rend bool if sidbar should render
	 * @return void
	 */
	this.viewNotifications = function(E,n,rend) {
		var e = E.EID;

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
			for(var idx in n[i].links) {
				this._sidebar.find('#cb'+i.toString()).append('<p><a href="'+n[i].links[idx]+'" target="_blank">'+n[i].links[idx]+'</a></p>');
			}

			n[i].HasSeen = true;

		}

		if(!this.notificationSeen(E,ids)) {
			console.warn('Failed to record seen notifications');
			console.log(e,ids);
		}

		ids = d = ts = undefined; // clean up

		var me = this;

		if(!me._displayState.sidebar) {
			me.renderSidebar(rend);
		}

		this._$('#ChatClose').on('click', function() {
			me.removeSidebar();
			me.renderWidget(true);
			me._$('#SCWidget .notification small').text("0");
		});

	};




	/*
	 * renderWidget
	 * renders the widget
	 */
	this.renderWidget = function(show_state) {
		show_state = (show_state === true);
		if(this._displayState.widget) {
			return false;
		}
		if(show_state) {
			//this._$('.closer').parent().remove();
			this._$('#SCWidget').show();

		} else {
			this._$('body').append(this._widget);
		}

		this._displayState.widget = true;

		return true;
	};



	/*
	 * removeWidget
	 * removes the widget
	 */
	this.removeWidget = function(hide_state) {
		hide_state = (hide_state === true);
		if(!this._displayState.widget) {
			return false;
		}
		if(hide_state) {
			// add removed items to the cache so we can
			// prepend them back onto the widget later
			var me = this;
			this._$.each(this._$('.closer'), function(i,e) {
				me._widgetElmsRemoved.push(me._$(e).parent());
			});

			me = undefined;

			this._$('.closer').parent().remove();
			this._$('#SCWidget').hide();

		} else {
			this._$('#SCWidget').remove();
		}

		this._displayState.widget = false;

		return true;
	};



	/*
	 * renderSidebar
	 * renders the sidebar
	 */
	this.renderSidebar = function() {
		if(this._displayState.sidebar) {
			return false;
		}
		this._$('body').append(this._sidebar);
		this._displayState.sidebar = true;
		this._$('body').append('<script id="tmpScScr">autosize(document.querySelectorAll("textarea"));</script>');

		return true;
	};



	/*
	 * removeSidebar
	 * removes the sidebar
	 */
	this.removeSidebar = function() {
		if(!this._displayState.sidebar) {
			return false;
		}

		this._$('#SCSB').remove();
		this._displayState.sidebar = false;

		$('#tmpScScr').remove();

		this._sidebar = this._$('<div id="SCSB" class="sc_main" style="z-index:999;"><div class="bigchat"><div id="ChatClose" class="header"><div class="name"></div><div class="time"></div><div class="close">Close</div></div><div class="primarychat"></div></div></div>');

		return true;
	};




	/*
	 * playNotifSound
	 * plays a sound for notifications
	 *
	 * @return void
	 */
	this.playNotifSound = function() {

		if(typeof this._audio == 'object' && this._audio instanceof Audio) {

			this._audio.play();

		} else {

			console.warn('Notification sound not instance of Audio Object.');
			console.log('Audio obj:',this._audio);

		}

	};





	/*
	 * manualTrigger
	 * decides if a manual trigger should be done
	 * based on cookie
	 *
	 * @param eid event id
	 * @return bool true if should manually trigger
	 */
	this.manualTrigger = function(eid) {
		var v = this.getCookie(this._eventCookieName);
		var o;

		if(!!v && v.length > 0) {

			o = JSON.parse(v);

		} else {
			return false;
		}

		var e = '_'+eid.toString()+'_';

		if(!o || !o[e] || typeof o[e] == 'undefined') {
			return false;
		}

		return true;
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
	 * eventDispatched
	 * checks to see if event already dispatched
	 *
	 * @param dc event dispatch code
	 * @return true if already fired
	 */
	this.eventDispatched = function(dc) {

		if(!!dc && dc.length > 0) {
			// iterate through dispatched codes
			for(var s in this._dispatchedCodes) {

				// check for match
				if(dc == this._dispatchedCodes[s]) {
					return true;
				}

			} // end for

		} // end if

		return false;
	};



	/*
	 * eventTriggered
	 * records an event being triggered
	 *
	 * @param event id
	 * @return false if failure
	 */
	this.eventTriggered = function(e) {

		if(!e || 'object' != typeof e) {
			return false;
		}

		if(!e.DispatchCode || e.DispatchCode.length < 1) {
			return false;
		}
		if(this.getCookie(e.DispatchCode).length > 0) {
			return true;
		}

		if(this.eventDispatched(e.DispatchCode)) {
			return true;
		}


		var tmp = this._$('script[data-dispatch='+e.DispatchCode+']');
		if(tmp.length > 0) {
			return true;
		}


		var scriptParams = '?eid='+e.EID+'&dc='+e.DispatchCode;

		this._$('head').prepend(this._$('<script type="text/javascript"></script>').attr('src',this._defaultEventTriggeredUri+scriptParams).attr('data-dispatch',e.DispatchCode).prop('async',true));

		return true;

	};




	/*
	 * notificationSeen
	 * records when notification is seen
	 *
	 * @param e event object
	 * @param array of notification ids
	 * @return false if fails
	 */
	this.notificationSeen = function(e,nids) {
		// make sure event objec is valid
		if(!e || !e.EID || !e.DispatchCode || e.DispatchCode < 1) {
			return false;
		}

		// make sure nids are all valid
		// 	then check to see if there is a
		//	notification that has not been seen
		var unseen_cnt = 0;
		for(var n in nids) {

			if(nids[n] < 1) {
				return false;
			}

			if(!this.notifHasSeen(e.EID,nids[n])) {
				this.setEventNotifCookie(e.EID,nids[n]);
				unseen_cnt++;
			}
		}

		if(unseen_cnt == 0) {
			console.log('all notifications have been seen');
			return true;
		}

		// stirng of nids
		var nid_str = nids.join('-'), dc_nid = e.DispatchCode+'-'+nid_str;

		var tmp = this._$('script[data-n-dispatch='+dc_nid+']');
		if(tmp.length > 0) {
			return true;
		}

		var scriptParams = '?eid='+e.EID+'&dc='+e.DispatchCode+'&nids='+nid_str;

		this._$('head').prepend(this._$('<script type="text/javascript"></script>').attr('src',this._defaultNotifSeenUri+scriptParams).attr('data-n-dispatch',dc_nid).prop('async',true));

		return true;

	};



	/*
	 * setCookie
	 * sets a cookie
	 *
	 * @param n name
	 * @param v value
	 * @param ex expiration
	 * @return void
	 */
	this.setCookie = function(n,v,ex) {
		if((typeof ex).toLowerCase()=='undefined'&&ex!==0) {
			ex=2;
		}
		var d = new Date();
		d.setTime(d.getTime() + (ex*24*60*60*1000));
		var expires = 'expires='+d.toUTCString();
		document.cookie = n+'='+v+'; '+expires;
	};



	/*
	 * getCookie
	 *
	 * @param cname cookie name
	 * @return cookie value
	 */
	this.getCookie = function(cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i=0; i<ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1);
			if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
		}
		return "";
	};




	/*
	 * setEventCookie
	 * sets cookie for when an event is triggered
	 *
	 * @param eid int event id
	 * @return void
	 */
	this.setEventCookie = function(eid) {
		var o = this.getEventCookieObject(eid);
		this.setCookie(this._eventCookieName,JSON.stringify(o),this._defaultCookieExpire);
	};



	/*
	 * setEventNotifCookie
	 * sets cookie for when an event is triggered
	 *
	 * @param eid int event id
	 * @param nid int notification id
	 * @return void
	 */
	this.setEventNotifCookie = function(eid,nid) {
		var o = this.getEventCookieObject(eid);
		var e = '_'+eid.toString()+'_';
		if(!this.notifHasSeen(eid,nid)) {
			o[e].push(nid);
		}
		this.setCookie(this._eventCookieName,JSON.stringify(o),this._defaultCookieExpire);
	};




	/*
	 * notifHasSeen
	 * determines whether or not a notif has been seen
	 *
	 * @param eid int event id
	 * @param nid int netif id
	 * @return true if seen
	 */
	this.notifHasSeen = function(eid,nid) {
		var o = this.getEventCookieObject(eid);
		var e = '_'+eid.toString()+'_';
		var has_seen = false;
		for(var x in o[e]) {
			if(o[e][x] == nid) {
				has_seen  =true;
			}
		}

		return has_seen;
	};



	/*
	 * getEventCookieObject
	 * gets event object from cookie val
	 *
	 * @return object
	 */
	this.getEventCookieObject = function(eid) {
		if(eid < 1) return {};

		var e = '_'+eid.toString()+'_';
		var v = this.getCookie(this._eventCookieName);
		var o = (!!v && v.length > 0) ? JSON.parse(v) : {};
		if(!o || !o[e] || typeof o[e] == 'undefined') {
			o = (typeof o == 'object' || o instanceof Object) ? o : {};
			o[e] = [];
		}
		return o;
	};



	/*
	 * reportEventFailure
	 * reports that there was an error when trying to store
	 * triggered event data
	 *
	 * @param m string message
	 * @return void
	 */
	this.reportEventFailure = function(m) {
		console.warn(m);
	};



	/*
	 * reportNotifSuccess
	 * reports successful notif views
	 *
	 * @param array of ids
	 * @return void
	 */
	this.reportNotifSuccess = function(ids) {
		console.info('following notification ids viewed and tracked: '+ids.toString());
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
