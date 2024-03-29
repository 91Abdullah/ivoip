

"use strict";

$(document).ready(function() {

	toastr.options = {
	  "closeButton": true,
	  "debug": false,
	  "newestOnTop": false,
	  "progressBar": false,
	  "positionClass": "toast-top-right",
	  "preventDuplicates": false,
	  "onclick": null,
	  "showDuration": "300",
	  "hideDuration": "1000",
	  "timeOut": "5000",
	  "extendedTimeOut": "1000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	};

	// Helper methods

	function changePhoneStatus(status)
	{
		let phone_status = document.getElementById("phone_status");
		phone_status.innerHTML = status;
		if(status == "Online") {
			phone_status.classList.remove('m--font-danger');
			phone_status.classList.add('m--font-success');
		} else if(status == "Offline") {
			phone_status.classList.remove('m--font-success');
			phone_status.classList.add('m--font-danger');
		} else if(status == "On Call") {
			phone_status.classList.remove('m--font-success');
			phone_status.classList.add('m--font-warning');
		}
	}

	function changeDeviceStatus(status)
	{
		let device_status = document.getElementById("device_status");
		device_status.innerHTML = status;
		if(status == "Registered") {
			device_status.classList.remove('m--font-danger');
			device_status.classList.add('m--font-success');
		} else if(status == "Offline") {
			device_status.classList.remove('m--font-success');
			device_status.classList.add('m--font-danger');
		}
	}

	function makeAjaxCall(url, data, callback)
	{
		return $.ajax({
			url: url,
			dataType: "JSON",
			type: "POST",
			data: data,
			success: callback,
			error: function(error) {
				toastr.error("Error in send request to server. Please contact application administrator. message: " + error.message);
			}
		});
	}

	function login(queue, agent_name, agent_interface)
	{
		axios.post(url_login, {
			_token: token,
			queue: queue,
			agent_name: agent_name,
			agent_interface: agent_interface
		}).then((response) => {
			axios.post(url_status, {
				queue: queue,
				agent_interface: agent_interface,
				_token: token
			}).then((response) => {
				// console.log(response);
				if(response.data.paused == 1) {
					changePhoneStatus("Offline - Reason: " + response.data.pausedreason);
					document.getElementById("ready_btn").dataset.reason = response.data.pausedreason;
				} else {
					changePhoneStatus("Online");
				}
			}).catch((error) => {
				toastr.error("Error in send request to server. Please contact application administrator. message: " + error);
			});
			toastr.success(response.data);
			// console.log(response);
		}).catch((error) => {
			// console.log(error);
			toastr.error("Error in send request to server. Please contact application administrator. message: " + error);
		});
		// $.ajax({
		// 	url: url_login,
		// 	dataType: "JSON",
		// 	type: "POST",
		// 	data: {
		// 		_token: "{!! csrf_token() !!}",
		// 		queue: queue,
		// 		agent_name: agent_name,
		// 		agent_interface: agent_interface
		// 	},
		// 	error: function(xhr, status, error) {
		// 		toastr.error("Error in send request to server. Please contact application administrator. message: " + error.message);
		// 	},
		// 	success: function(result, status, xhr) {
		// 		changePhoneStatus("Online");
		// 		toastr.success(result);
		// 	}
		// });
	}

	function logout(queue, agent_name, agent_interface)
	{
		axios.post(url_logout, {
			queue: queue,
			agent_name: agent_name,
			agent_interface: agent_interface
		}).then((response) => {
			toastr.success(response.data);
		}).catch((error) => {
			toastr.error("Error in send request to server. Please contact application administrator. message: " + error.message);
		});

		// $.ajax({
		// 	url: url_logout,
		// 	dataType: "JSON",
		// 	type: "POST",
		// 	data: {
		// 		_token: "{!! csrf_token() !!}",
		// 		queue: queue,
		// 		agent_name: agent_name,
		// 		agent_interface: agent_interface
		// 	},
		// 	error: function(xhr, status, error) {
		// 		toastr.error("Error in send request to server. Please contact application administrator. message: " + error.message);
		// 	},
		// 	success: function(result, status, xhr) {
		// 		toastr.success(result);
		// 	}
		// });
	}

	function pause(queue, agent_interface, reason)
	{
		axios.post(url_pause, {
			queue: queue,
			reason: reason,
			agent_interface: agent_interface
		}).then((response) => {
			changePhoneStatus("Offline - Reason: " + reason);
			set_reason(reason);
			toastr.success(response.data);
		}).catch((error) => {
			toastr.error("Error in send request to server. Please contact application administrator. message: " + error.message);
		});

		// $.ajax({
		// 	url: url_pause,
		// 	dataType: "JSON",
		// 	type: "POST",
		// 	data: {
		// 		_token: "{!! csrf_token() !!}",
		// 		queue: queue,
		// 		reason: reason,
		// 		agent_interface: agent_interface
		// 	},
		// 	error: function(xhr, status, error) {
		// 		toastr.error("Error in send request to server. Please contact application administrator. message: " + error.message);
		// 	},
		// 	success: function(result, status, xhr) {
		// 		toastr.success(result);
		// 		changePhoneStatus("Offline - Reason: " + reason);
		// 		set_reason(reason);
		// 	}
		// });
	}

	function unpause(queue, agent_interface, reason)
	{
		axios.post(url_unpause, {
			queue: queue,
			reason: reason,
			agent_interface: agent_interface
		}).then((response) => {
			changePhoneStatus("Online");
			toastr.success(response.data);
		}).catch((error) => {
			toastr.error("Error in send request to server. Please contact application administrator. message: " + error.message);
		});

		// $.ajax({
		// 	url: url_unpause,
		// 	dataType: "JSON",
		// 	type: "POST",
		// 	data: {
		// 		_token: "{!! csrf_token() !!}",
		// 		queue: queue,
		// 		reason: reason,
		// 		agent_interface: agent_interface
		// 	},
		// 	error: function(xhr, status, error) {
		// 		toastr.error("Error in sending request to server. Please contact application administrator. message: " + error.message);
		// 	},
		// 	success: function(result, status, xhr) {
		// 		toastr.success(result);
		// 		changePhoneStatus("Online");
		// 	}
		// });
	}

	function logHold()
	{
		axios.post(url_hold, {
			queue: forQueue,
			agent: user_name,
			uniqueid: uniqueId[uniqueId.length - 1]
		}).then((response) => {
			console.log(response.data);
			toastr.success(response.data);
		}).catch((error) => {
			console.log(error);
			toastr.error(error);
		})
	}

	function logUnHold()
	{
		axios.post(url_unhold, {
			queue: forQueue,
			agent: user_name,
			uniqueid: uniqueId[uniqueId.length - 1]
		}).then((response) => {
			console.log(response);
			toastr.success(response.data);
		}).catch((error) => {
			console.log(error);
			toastr.error(error);
		})
	}

	function get_callid(agent_interface)
	{
		axios.post(url_callid, {
			_token: token,
			agent: agent_interface
		}).then((response) => {
			callId.push(response.data);
			toastr.success("Call ID retrieved from server: " + response.data);
		}).catch((error) => {
			toastr.error("Error in sending request to server. Please contact application administrator. message: " + error);
		});
	}

	function get_queue(connected)
	{
		axios.post(url_queue, {
			_token: token,
			connected: connected
		}).then((response) => {
			forQueue = response.data;
			console.log(response.data);
			toastr.success("Queue retrieved from server: " + response.data);
		}).catch((error) => {
			toastr.error("Error in sending request to server. Please contact application administrator. message: " + error);
		});
	}

	function set_reason(reason)
	{
		document.getElementById("ready_btn").dataset.reason = reason;
	}

	async function getAgentStats(queue)
	{
		try	{
			const response = await axios.post(url_stats, {
				agent_interface: user_extension,
				queue: queue	
			});
			// console.log(response.data);
			mapResponseToUI(response);

		} catch (error) {
			console.log(error);
		}
	}

	function mapInitialState(response) 
	{
		let agent_data = response.data[1];
		if(agent_data["paused"] == 1)
		{
			changePhoneStatus("Offline - Reason: " + agent_data["pausedreason"]);
			set_reason(agent_data["pausedreason"]);
		}	
	}

	function mapResponseToUI(response)
	{
		let parent = document.getElementById('agent_stats_list_items');

		if(parent.childElementCount > 0) {
			while(parent.firstChild) {
				parent.removeChild(parent.firstChild);
			}
		}					

		let child = [];
		let span_child = [];
		let span_child_text = [];
		let list_elems = ['name', 'callstaken', 'lastcall', 'lastpause', 'paused', 'pausedreason', 'status', 'incall'];
		let agent_data = response.data[1];
		
		for (var i = 0; i <= list_elems.length - 1; i++) {
			child[i] = document.createElement('div');
			child[i].classList.add("m-list-timeline__item");
			span_child[i] = document.createElement('span');
			span_child[i].classList.add("m-list-timeline__badge", "m-list-timeline__badge--success");
			span_child_text[i] = document.createElement('span');
			span_child_text[i].classList.add("m-list-timeline__text");
			span_child_text[i].innerHTML = mapStringToLabel(list_elems[i]) + ": " + "<b>" + mapValuetoString(list_elems[i], agent_data[list_elems[i]]) + "</b>";
			child[i].append(span_child[i]);
			child[i].append(span_child_text[i]);
			parent.append(child[i]);
		}

		let queue_parent = document.getElementById('queue_stats_list_items');

		if(queue_parent.childElementCount > 0) {
			while(queue_parent.firstChild) {
				queue_parent.removeChild(queue_parent.firstChild);
			}
		}

		let qchild = [];
		let span_qchild = [];
		let span_qchild_text = [];
		let qlist_elems = ['queue', 'calls', 'holdtime', 'talktime', 'completed', 'abandoned', 'servicelevelperf', 'servicelevelperf2'];
		let q_data = response.data[0];

		for (var i = 0; i <= qlist_elems.length - 1; i++) {
			qchild[i] = document.createElement('div');
			qchild[i].classList.add("m-list-timeline__item");
			span_qchild[i] = document.createElement('span');
			span_qchild[i].classList.add("m-list-timeline__badge", "m-list-timeline__badge--success");
			span_qchild_text[i] = document.createElement('span');
			span_qchild_text[i].classList.add("m-list-timelime__text");
			span_qchild_text[i].innerHTML = mapQueueStringToLabel(qlist_elems[i]) + ": " + "<b>" + q_data[qlist_elems[i]] + "</b>";
			qchild[i].append(span_qchild[i]);
			qchild[i].append(span_qchild_text[i]);
			queue_parent.append(qchild[i]);
		}
	}

	function mapQueueStringToLabel(string)
	{
		switch(string) {
			case 'queue':
				return 'Queue Name';
				break;
			case 'calls':
				return 'Calls in Queue';
				break;
			case 'holdtime':
				return 'Avg Queue hold time';
				break;
			case 'talktime':
				return 'Avg Queue talk time';
				break;
			case 'completed':
				return 'Total Completed Calls';
				break;
			case 'abandoned':
				return 'Total Abandoned Calls';
				break;
			case 'servicelevelperf':
				return 'Queue Service Level';
				break;
			case 'servicelevelperf2':
				return 'Queue Service Level (Under development)';
				break;
			default:
				return '';
				break;
		}
	}

	function mapValuetoString(string, value)
	{
		if(string === 'incall' || string == 'paused' || string == 'status') {
			switch(string) {
				case 'incall':
					if(value == '0' || value == 0) {
						return 'No';
					} else {
						return 'Yes';
					}
					break;
				case 'paused':
					if(value == '0' || value == 0) {
						return 'No';
					} else {
						return 'Yes';
					}
					break;
				case 'status':
					if(value == '0' || value == 0) {
						return 'Busy';
					} else {
						return 'Free';
					}
					break;
				default:
					return '';
				break;
			}
		} else {
			return value;
		}
	}

	function mapStringToLabel(string)
	{
		switch(string) {
			case 'status':
				return 'Current Status';
				break;
			case 'pausedreason':
				return "Last 'Not Ready' reason";
				break;
			case 'paused':
				return 'Not Ready';
				break;
			case 'lastpause':
				return 'Last Not Ready Time';
				break;
			case 'lastcall':
			 	return 'Last call taken';
			 	break;
		 	case 'callstaken':
		 		return 'No. of calls taken';
		 		break;
	 		case 'incall':
	 			return 'Busy';
	 			break;
		 	case 'name':
		 		return 'Name';
		 		break;
	 		default:
	 			return '';
	 			break;
		}
	}

	function resetInCallControls()
	{
		$("#incall_controls_mute").bootstrapSwitch('state') == false ? '' : $("#incall_controls_mute").bootstrapSwitch('state', false);
		$("#incall_controls_hold").bootstrapSwitch('state') == false ? '' : $("#incall_controls_hold").bootstrapSwitch('state', false);
	}


	function showWorkcodes()
	{
		// Pause agent until workcode is submitted

		for (var i = queues.length - 1; i >= 0; i--) {
			pause(queues[i], user_extension, "Wrapup-Start");
		}

		// End

		swal({
			type: 'question',
			title: 'Select Workcode',
			backdrop: false,
			input: 'select',
			allowOutsideClick: false,
			allowEscapeKey: false,
			allowEnterKey: false,
			showConfirmButton: true,
			confirmButtonText: 'Submit',
			inputOptions: workcodes,
			timer: 1000,
		}).then((result) => {
			console.log(result);
			console.log(uniqueId[uniqueId.length - 1], callId);
			let uniqueID = uniqueId[uniqueId.length - 1] == undefined ? callId[callId.length - 1] : uniqueId[uniqueId.length - 1];
			console.log(uniqueID);
			if(result.dismiss === "timer") {
				submitWorkcode("Unassigned", uniqueID)
			} else {
				submitWorkcode(result.value, uniqueID);
			}
			// console.log(res);
			for (var i = queues.length - 1; i >= 0; i--) {
				unpause(queues[i], user_extension, "Wrapup-End");
			}
		});
	}

	async function submitWorkcode(workcode, uniqueid)
	{
		// let workcode = workcode;
		// let uniqueid = uniqueid;
		let queue = forQueue;
		let agent = user_name;

		await axios.post(url_workcode, {
			agent: agent,
			queue: queue,
			uniqueid: uniqueid,
			workcode: workcode
		}).then((response) => {
			console.log(response);
			toastr.success(response.data);
		}).catch((error) => {
			toastr.error(error);
		});
	}

	let randomString = function(length) {
	   var text = "";
	   var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	    for(var i = 0; i < length; i++) {
	        text += possible.charAt(Math.floor(Math.random() * possible.length));
	    }
	    return text;
	}

	function createCallRecordData(data)
	{
		let randomStr = randomString(5);
		let parentClass = document.getElementById("call_stats_list_items");
		let elem = document.createElement("div");
		elem.classList.add("m-accordion__item");
		let accordianHead = document.createElement("div");
		accordianHead.classList.add("m-accordion__item-head", "collapsed");
		accordianHead.setAttribute("id", "call_stats_list_items_" + randomStr + "_head");
		accordianHead.setAttribute("data-toggle", "collapse");
		accordianHead.setAttribute("href", "#call_stats_list_items_" + randomStr + "_body");
		let spanClass = document.createElement("div");
		spanClass.classList.add("m-accordion__item-icon");
		let iconClass = document.createElement("i");
		iconClass.classList.add("fa", "flaticon-support");
		spanClass.append(iconClass);
		let spanClassTitle = document.createElement("span");
		spanClassTitle.classList.add("m-accordion__item-title");
		spanClassTitle.innerHTML = data.calleridnum;
		let spanClassMode = document.createElement("span");
		spanClassMode.classList.add("m-accordion__item-mode");
		accordianHead.append(spanClass);
		accordianHead.append(spanClassTitle);
		accordianHead.append(spanClassMode);

		let accordianBody = document.createElement("div");
		accordianBody.classList.add("m-accordion__item-body", "collapse");
		accordianBody.setAttribute("id", "call_stats_list_items_" + randomStr + "_body");
		accordianBody.setAttribute("data-parent", "call_stats_list_items");
		let accordianBodyChild = document.createElement("div");
		accordianBodyChild.classList.add("m-accordion__item-content");
		accordianBody.append(accordianBodyChild);
		let pList = document.createElement("ul");
		Object.keys(data).forEach((index) => {
			let elem = document.createElement("li");
			elem.innerHTML = index + ": <b>" + data[index] + "</b>";
			pList.append(elem);
		});

		accordianBodyChild.append(pList);
		elem.append(accordianHead);
		elem.append(accordianBody);
		parentClass.append(elem);
	}

	// END helper methods

	// START UA Methods

	const user_agent = new SIP.UA({
		uri: user_extension + '@' + server + ':5061',
		transportOptions: {
			wsServers: ['wss://' + server + ':8089/ws'],
			traceSip: false
		},
		authorizationUser: user_extension,
		password: sip_password,
		register: true
	});

	user_agent.start();

	// END UA Methods

	// Websocket 

	// let es = new EventSource("{{ route('ws.demo') }}");

	// es.onmessage = function(event) {
	// 	// let data = JSON.parse(event.data);
//         	console.log(event);
//         	// if(data.event == "AgentConnect") {
//         	// 	uniqueId.push(data.uniqueid);
 //          // 	forQueue = data.queue;
 //          // 	createCallRecordData(data);
//         	// }
//     	}

//     	es.onerror = function(event) {
//     		console.log(event);
//     	}

	// Echo.channel(`agent.connect.` + user_extension)
	// 	.listen('AgentConnectedEvent', (e) => {
	// 		console.log(e);
	// 	});

	// End Websocket

	// START EVent Methods

	timer.addEventListener('secondsUpdated', function(e) {
		document.getElementById("timer").innerHTML = timer.getTimeValues().toString();
	});

	document.getElementById("ready_btn").onclick = function(e) {
		// console.log(e);
		const reason = e.target.dataset.reason;
		for (var i = queues.length - 1; i >= 0; i--) {
			let data = {
				_token: token,
				agent_interface: user_extension,
				queue: queues[i]
			};
			makeAjaxCall(url_status, data, function(result, status, xhr) {
				if(result.paused == 0) {
					toastr.warning("You are already in 'Ready' state in all queues!")
				} else {
					unpause(queues[i], user_extension, reason);
				}
			});
		}
	};

	for (var i = pause_buttons.length - 1; i >= 0; i--) {
		pause_buttons[i].onclick = function(e) {
			const reason = e.target.dataset.reason;
			for (var i = queues.length - 1; i >= 0; i--) {
				let data = {
					_token: token,
					agent_interface: user_extension,
					queue: queues[i]
				};
				makeAjaxCall(url_status, data, function(result, status, xhr) {
					if(result.paused == 1) {
						toastr.warning("You are already in 'Not Ready' state in all queues!")
					} else {
						pause(queues[i], user_extension, reason);
					}
				});
			}
		}
	}

	document.getElementsByClassName("notready_btn").onclick = function(e) {
		reason = e.currentTarget.dataset.reason;
		console.log(reason);
	};

	document.getElementById("agent_logout").onclick = function(e) {
		e.preventDefault();
		swal({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, Close it!"
        }).then(function(e) {

            user_agent.stop();
            for (var i = queues.length - 1; i >= 0; i--) {
            	logout(queues[i], user_name, user_extension);
            }
            document.getElementById('logout-form').submit();
        });
	};	

	document.onbeforeunload = function() {
		user_agent.stop();
	};

	user_agent.on("registered", function() {
		changeDeviceStatus("Registered");
		console.log(queues);
		for (var i = queues.length - 1; i >= 0; i--) {
			login(queues[i], user_name, user_extension);
			// console.log(queues[i]);
		}
	});

	user_agent.on("invite", function(session) {
		ring.play();

		const remoteNumber = session.remoteIdentity.displayName == undefined ? session.remoteIdentity.friendlyName : session.remoteIdentity.displayName;

		const remoteAudio = document.getElementById("remoteAudio");
		const localAudio = document.getElementById("localAudio");

		document.getElementById("m_incoming_call_number").innerHTML = remoteNumber;

		// $("#m_incoming_call").modal({
		// 	backdrop: 'static',
		// 	keyboard: false,
		// 	focus: false
		// });

		swal({
			title: 'Incoming Call',
			text: remoteNumber,
			type: 'success',
			allowOutsideClick: false,
			showCancelButton: false,
			allowEscapeKey: false,
			confirmButtonText: 'Accept',
			cancelButtonText: 'Reject'
		}).then(function(value) { 
			if(value.dismiss && value.dismiss === "cancel") {
				try	{
					session.reject();
				} catch (error) {
					console.log(error);
				}
			} else if(value) {
				let options =  {
                    sessionDescriptionHandlerOptions: {
                        constraints: {
                            audio: true,
                            video: false
                        },
                        // peerConnectionOptions: {
                        // 	iceCheckingTimeout: 1000
                        // }
                    }
                };
				try	{
					session.accept(options);
				} catch (error) {
					console.log(error);
					toastr.error("Error accepting call. Please contact application administrator. Error: " +  error);
				}
			}
		});

		// document.getElementById('m_incoming_call_dismiss').onclick = function(e) {
		// 	session.bye();
		// }

		document.getElementById('incall_hangup').onclick = function(e) {
			try {
				session.bye();
			} catch (error) {
				toastr.error("Unable to disconnect call. Please contact application administrator. Error: " + error);
			}
		}

		document.getElementById("incall_controls_hold").onchange = function(e) {
			if(e.target.checked) {
				try {
					let options =  {
	                    sessionDescriptionHandlerOptions: {
	                        constraints: {
	                            audio: true,
	                            video: false
	                        },
	                        // peerConnectionOptions: {
	                        // 	iceCheckingTimeout: 1000
	                        // }
	                    }
	                };
	                console.log(session);
					session.hold(options);
					logHold();
				} catch (error) {
					console.log(error);
					toastr.error("Unable to put call on hold. Please contact application administrator. Error: " + error);
				}
				document.getElementById("incall_status_text").innerHTML = "HOLD";

			} else {
				console.log("session unhold hitting");
				try {
					let options =  {
	                    sessionDescriptionHandlerOptions: {
	                        constraints: {
	                            audio: true,
	                            video: false
	                        },
	                        // peerConnectionOptions: {
	                        // 	iceCheckingTimeout: 1000
	                        // }
	                    }
	                };
					session.unhold(options);
					logUnHold();
				} catch (error) {
					console.log(error);
					toastr.error("Unable to put call on unhold. Please contact application administrator. Error: " + error);
				}
				
				document.getElementById("incall_status_text").innerHTML = "INCALL";
			}
		}

		document.getElementById("incall_controls_mute").onchange = function(e) {
			if(e.target.checked) {
				let pc = session.sessionDescriptionHandler.peerConnection;
				pc.getLocalStreams().forEach(function (stream) {
				    stream.getAudioTracks().forEach(function (track) {
				        track.enabled = false;
				    });
				});
				document.getElementById("incall_status_text").innerHTML = "MUTE";
			} else {
				let pc = session.sessionDescriptionHandler.peerConnection;
				pc.getLocalStreams().forEach(function (stream) {
				    stream.getAudioTracks().forEach(function (track) {
				        track.enabled = true;
				    });
				});
				document.getElementById("incall_status_text").innerHTML = "INCALL";
			}
		}

		session.on("trackAdded", function() {
			// We need to check the peer connection to determine which track was added
			const pc = session.sessionDescriptionHandler.peerConnection;

			try {
				// Gets remote tracks
				let remoteStream = new MediaStream();
				pc.getReceivers().forEach(function(receiver) {
					remoteStream.addTrack(receiver.track);
				});
				remoteAudio.srcObject = remoteStream;
				remoteAudio.play();

				// Gets local tracks
				let localStream = new MediaStream();
				pc.getSenders().forEach(function(sender) {
					localStream.addTrack(sender.track);
				});
				localAudio.srcObject = localStream;
				localAudio.play();
			} catch (error) {
				console.log(error);
			}
		});

		session.on("bye", function(data) {
			document.getElementById("incall_info").classList.add("invisible");
			document.getElementById("incall_controls").classList.add("invisible");
			showWorkcodes();
		});

		session.on("accepted", function(data) {

			// console.log(remoteNumber);
			// console.log(data);

			ring.pause();
			timer.start();

			get_callid(user_extension);
			get_queue(remoteNumber);

			document.getElementById("incall_info").classList.remove("invisible");
			document.getElementById("incall_controls").classList.remove("invisible");

			document.getElementById("call_number").innerHTML = remoteNumber;
			document.getElementById("incall_status_text").innerHTML = "INCALL";

			$("#m_incoming_call").modal('hide');
		});

		session.on("terminated", function(data, cause) {
			// console.log(data, cause);
			if(!ring.paused) {
				ring.pause();
			}
			timer.stop();

			if(!document.getElementById("incall_info").classList.contains("invisible")) {
				document.getElementById("incall_info").classList.add("invisible");
			}
			if(!document.getElementById("incall_controls").classList.contains("invisible")) {
				document.getElementById("incall_controls").classList.add("invisible");
			}
			$("#m_incoming_call").modal('hide');

			resetInCallControls();
		});

		session.on("failed", function(response, cause) {
			toastr.error("Failed", "Call has been failed. Reason: " + cause);
		});

		session.on("rejected", function(response, cause) {
			toastr.error("Rejected", "Call has been rejected. Reason: " + cause);
		});

	});

	user_agent.on("unregistered", function() {
		changeDeviceStatus("Offline");
		changePhoneStatus("Offline");
	});

	user_agent.transport.on("transportError", function(data) {
		console.log(data);
		swal({
			titleText: "Add Exception",
			text: "Please click following link and add exception to certificate authority",
			type: "info",
			backdrop: false,
			allowOutsideClick: false,
			allowEscapeKey: false,
			allowEnterKey: false,
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Click Here'
		}).then((response) => {
			if(response.value) {
				window.open("https://" + server + ":8089/httpstatus", "_blank");
			}
		}).catch((error) => {
			console.log(error);
		});
	});

	// END Even Methods

	document.getElementById("m_quick_sidebar_toggle").onclick = function(e) {
		for (var i = queues.length - 1; i >= 0; i--) {
			getAgentStats(queues[i]);
		}

	}

});
