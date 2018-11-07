

$(function () {
    mSIP.init();
    mTransfer.init();
});

let mSIP;
let UserInterface;
let userAgent;
let mTransfer;

let deviceStatus = document.getElementById('device_status').classList;
let deviceStatusText = document.getElementById('device_status');
let busy = document.getElementById('busyTone');
let remoteAudio = document.getElementById('remoteAudio');
let localAudio = document.getElementById('localAudio');
let transferBtn = document.getElementById('transferBtn');
let tForm = document.getElementById('transferForm');
let mBtn = document.getElementById('muteBtn');
let hBtn = document.getElementById('holdBtn');

transferBtn.onclick = function(e) {
    mTransfer.transfer();
};

tForm.onsubmit = function(event) {
    event.preventDefault();
    console.log(event);
    mTransfer.process(event);
};

mBtn.onclick = function() {
    mSIP.toggleMute();
};

hBtn.onclick = function() {
    mSIP.toggleHold();
};

busy.loop = true;

mTransfer = {
    init: function () {

    },
    transfer: () => {
        $('#transferModal').modal('show');
        mSIP.toggleHold();
    },
    process: function (event) {
        console.log(event);
        event.preventDefault();
        let value = document.getElementById('transferNumber').value;
        mSIP.transfer(value);
    }
};

mSIP = {

    init: function () {

        this.register();
    },
    register: function () {

        this.userAgent = new SIP.UA({
            uri: extension + '@' + server + ':' + sipPort,
            transportOptions: {
                wsServers: ['wss://' + server + ':8089/ws'],
                traceSip: false
            },
            authorizationUser: extension,
            password: secret,
            register: true
        });

        this.userAgent.start();
        this.userAgent.on("registered", UserInterface.registered);
        this.userAgent.on("unregistered", UserInterface.unregistered);
    },
    options: function() {
        return {
            sessionDescriptionHandlerOptions: {
                constraints: {
                    audio: true,
                    video: false
                },
            }
        };
    },
    call: function (number) {
        const options = {
            sessionDescriptionHandlerOptions: {
                constraints: {
                    audio: true,
                    video: false
                },
            }
        };
        this.session = this.userAgent.invite(number, options);

        this.session.on("trackAdded", this.trackAdded);

        this.session.on("accepted", this.connected);
        this.session.on("terminated", this.terminated);
        this.session.on("rejected", this.rejected);
        this.session.on("failed", this.failed);
        this.session.on("bye", this.parseBye);

    },
    hangup: function () {
        try {
            this.session.bye();
        } catch (e) {
            this.session.cancel();
            toastr.info(e.message);
        }
    },
    cancel: function () {
        this.session.cancel();
    },
    trackAdded: function () {
        // console.log(this);
        // console.log(this.userAgent);
        // We need to check the peer connection to determine which track was added
        const pc = this.sessionDescriptionHandler.peerConnection;

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
    },
    connected: function () {
        DialPad.connected();
    },
    terminated: function (message, cause) {
        UserInterface.terminate(message, cause);
        mHistory.updateCalls();
    },
    rejected: function (response, cause) {
        console.log(response, cause);
        UserInterface.rejected(response, cause);
    },
    bye: function (request) {
        console.log(request);
        UserInterface.bye(request);
    },
    failed: function (response, cause) {
        UserInterface.failed(response, cause);
    },
    parseBye: function (request) {
        if(request instanceof SIP.IncomingRequest) {
            // This is incoming request handle it accordingly.
            let match = String(request.getHeader('Reason'));
            if(match.includes('cause=17') || match.indexOf('cause=17') !== -1) {
                UserInterface.rejected("Busy", 17);
            }
        } else if(request instanceof SIP.OutgoingRequest) {
            console.log(request.getHeader('Reason'));
            UserInterface.bye("Call has been terminated.");
        }
    },
    transfer: function (number) {
        let holdSession = this.session;
        let nSession = this.userAgent.invite(number, this.options());
        
        nSession.on("accepted", function (data) {
            let response = nSession.refer(holdSession);
            console.log(response);
        });
    },
    toggleHold: function () {
        if(this.session.local_hold) {
            this.session.unhold();
            UserInterface.unhold();
        }
        else {
            this.session.hold();
            UserInterface.hold();
        }
    },
    toggleMute: function () {
        ///mute
        let pc = this.session.sessionDescriptionHandler.peerConnection;
        pc.getLocalStreams().forEach(function (stream) {
            stream.getAudioTracks().forEach(function (track) {
                try {
                    track.enabled = !track.enabled;
                    if(track.enabled)
                        UserInterface.mute();
                    else
                        UserInterface.unmute();
                } catch (e) {
                    UserInterface.error();
                    console.log(e);
                }
            });
        });
    }
};

UserInterface = {
    init: function() {

    },
    registered: function () {
        toastr.success("Device registered successfully.");
        deviceStatusText.innerHTML = "Online";
        if(deviceStatus.contains('m--font-danger')) {
            deviceStatus.remove("m--font-danger");
            deviceStatus.add("m--font-success");
        }
    },
    unregistered: function (response, cause) {
        toastr.error("Device unregistered with cause" + cause + " and response code: " + response);
        deviceStatusText.innerHTML = "Offline";
        if(deviceStatus.contains('m--font-success')) {
            deviceStatus.remove("m--font-success");
            deviceStatus.add("m--font-danger");
        }
    },
    disconnect: function () {
        toastr.success("Call has been disconnected.");
    },
    rejected: function (response, cause) {
        toastr.error("Call rejected with " + cause);
        DialPad.rejected();
        busy.play();
    },
    failed: function (response, cause) {
        toastr.error("Call failed with reason " + cause);
    },
    bye: function (response) {
        toastr.info(response);
    },
    terminate: function (message, cause) {
        toastr.info("Call terminated.");
        // DialPad.endCall();
    },
    mute: function () {
        toastr.success("Your mic is on mute");
        // mMute.style.display = "inline";
    },
    unmute: function () {
        toastr.success("Your mic has been taken off from mute.");
        // mMute.style.display = "none";
    },
    error: function () {
        toastr.error('Error occurred in executing this command.');
    },
    hold: function () {
        toastr.success("Caller put on hold.");
        // mHold.style.display = "inline";
    },
    unhold: function () {
        toastr.success("Caller taken off from hold.");
        // mHold.style.display = "none";
    }
};