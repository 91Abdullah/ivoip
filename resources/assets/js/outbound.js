

"use strict";

$(document).ready(function() {

	// Variables

	let callConnected = false;

	// End Variables

	document.getElementById('m_quick_sidebar_toggle').style.display = "none";

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
			uniqueId.push(response.data);
			toastr.success("Call ID retrieved from server: " + response.data);
		}).catch((error) => {
			toastr.error("Error in sending request to server. Please contact application administrator. message: " + error);
		});
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

	function resetInCallControls()
	{
		$("#incall_controls_mute").bootstrapSwitch('state') == false ? '' : $("#incall_controls_mute").bootstrapSwitch('state', false);
		$("#incall_controls_hold").bootstrapSwitch('state') == false ? '' : $("#incall_controls_hold").bootstrapSwitch('state', false);
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

	function showWorkcodes()
	{

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
			inputOptions: workcodes
		}).then((result) => {
			let callid = uniqueId[uniqueId.length - 1];
			submitWorkcode(result.value, callid);
		});
	}

	async function submitWorkcode(workcode, uniqueid)
	{
		// let workcode = workcode;
		// let uniqueid = uniqueid;
		let agent = user_name;

		await axios.post(url_outworkcode, {
			agent: agent,
			uniqueid: uniqueid,
			workcode: workcode
		}).then((response) => {
			console.log(response);
			toastr.success(response.data);
		}).catch((error) => {
			toastr.error(error);
		});
	}

	// END helper methods

	// START UA Methods

	const user_agent = new SIP.UA({
		uri: user_extension + '@' + server,
		transportOptions: {
			wsServers: ['wss://' + server + ':8089/ws'],
			traceSip: false
		},
		authorizationUser: user_extension,
		password: sip_password,
		register: true
	});

	user_agent.start();

	// Echo.channel(`agent.connect.` + user_extension)
	// 	.listen('AgentConnectedEvent', (e) => {
	// 		console.log(e);
	// 	});

	// End Websocket

	// START EVent Methods

	document.getElementById("outcall_dial").onclick = function(e) {
		let number = document.getElementById("outbound_number");
		if(number.value == 0 || isNaN(number.value)) {
			toastr.error("Invalid or empty number entered.");
		} else {

			let options =  {
                sessionDescriptionHandlerOptions: {
                    constraints: {
                        audio: true,
                        video: false
                    },
                }
            };

			let session = user_agent.invite(number.value, options);

			console.log(session);

			let remoteNumber = session.remoteIdentity.displayName == undefined ? session.remoteIdentity.friendlyName : session.remoteIdentity.displayName;

			const remoteAudio = document.getElementById("remoteAudio");
			const localAudio = document.getElementById("localAudio");
			
			if(remoteNumber.indexOf('@') > -1) {
				remoteNumber = remoteNumber.split("@")[0];
			}

			document.getElementById("m_incoming_call_number").innerHTML = remoteNumber;

			timer.start();

			document.getElementById("outcall_dialer").style.display = "none";
			document.getElementById("incall_info").classList.remove("invisible");


			document.getElementById("call_number").innerHTML = remoteNumber;
			document.getElementById("incall_status_text").innerHTML = "INCALL";

			$("#m_incoming_call").modal('hide');

			document.getElementById('incall_hangup').onclick = function(e) {
				try {
					if(!callConnected) {
						// Its and outgoing call
						session.cancel();
						console.log("cancel");
					} else {
						session.bye();
						console.log("bye");
					}
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
						l//ogHold();
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
						//logUnHold();
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

			session.on("accepted", function(data) {
				callConnected = true;
				get_callid(user_extension);
				document.getElementById("incall_controls").classList.remove("invisible");
			});

			session.on("bye", function(data) {
				document.getElementById("incall_info").classList.add("invisible");
				document.getElementById("incall_controls").classList.add("invisible");
			});

			session.on("terminated", function(data) {

				timer.stop();

				document.getElementById("outcall_dialer").style.display = "block";

				if(!document.getElementById("incall_info").classList.contains("invisible")) {
					document.getElementById("incall_info").classList.add("invisible");
				}
				if(!document.getElementById("incall_controls").classList.contains("invisible")) {
					document.getElementById("incall_controls").classList.add("invisible");
				}
				$("#m_incoming_call").modal('hide');

				resetInCallControls();

				if(callConnected) {
					showWorkcodes();
				}

				callConnected = false;
			});
		}
	}

	timer.addEventListener('secondsUpdated', function(e) {
		document.getElementById("timer").innerHTML = timer.getTimeValues().toString();
	});

	document.onbeforeunload = function() {
		user_agent.stop();
	};

	user_agent.on("registered", function() {
		changeDeviceStatus("Registered");
	});

	user_agent.on("invite", function(session) {
		console.log(session);

		const remoteNumber = session.remoteIdentity.displayName == undefined ? session.remoteIdentity.friendlyName : session.remoteIdentity.displayName;

		const remoteAudio = document.getElementById("remoteAudio");
		const localAudio = document.getElementById("localAudio");

		document.getElementById("m_incoming_call_number").innerHTML = remoteNumber;

		swal({
			title: 'Incoming Call',
			text: remoteNumber,
			type: 'success',
			allowOutsideClick: false,
			showCancelButton: true,
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
					//logHold();
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
					//logUnHold();
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

		session.on("accepted", function(data) {

			timer.start();

			document.getElementById("outcall_dialer").style.display = "none";
			document.getElementById("incall_info").classList.remove("invisible");
			document.getElementById("incall_controls").classList.remove("invisible");

			document.getElementById("call_number").innerHTML = remoteNumber;
			document.getElementById("incall_status_text").innerHTML = "INCALL";

			$("#m_incoming_call").modal('hide');
		});

		session.on("bye", function(data) {
			document.getElementById("incall_info").classList.add("invisible");
			document.getElementById("incall_controls").classList.add("invisible");
		});

		session.on("terminated", function(data) {

			timer.stop();

			document.getElementById("outcall_dialer").style.display = "block";

			if(!document.getElementById("incall_info").classList.contains("invisible")) {
				document.getElementById("incall_info").classList.add("invisible");
			}
			if(!document.getElementById("incall_controls").classList.contains("invisible")) {
				document.getElementById("incall_controls").classList.add("invisible");
			}
			$("#m_incoming_call").modal('hide');

			resetInCallControls();
		});

	});

	user_agent.on("unregistered", function() {
		changeDeviceStatus("Offline");
	});

	// END Even Methods

	document.getElementById("m_quick_sidebar_toggle").onclick = function(e) {

	}

});