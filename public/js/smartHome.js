var canvas = [];
var context = [];
var wsUrl_ = 'ws://' + window.location.hostname + ':1337';
console.log(wsUrl_);
var mess = {
    From: "user",
    To: "light",
    Object: "Toggle",
    message: "on"
};
// Select elements by their data attribute
const $entryLedElements = $('[data-entry-led]');
// Map over each element and extract the data value
const $entryLeds =
    $.map($entryLedElements, item => $(item).data('entryLed'));
// You'll now have array containing string values
//console.log($entryleds); // eg: ["1", "2", "3"]

// Select elements by their data attribute
const $entryLedIdElements = $('[data-entry-ledid]');
// Map over each element and extract the data value
const $entryLedIds =
    $.map($entryLedIdElements, item => $(item).data('entryLedid'));
// You'll now have array containing string values
//console.log($entryEmergencyValues); // eg: ["1", "2", "3"]

function wsMessageProcessing(jsonMessage) {
    var To = jsonMessage.To;
    var From = jsonMessage.From;
    var mess = jsonMessage.message;
    var object = jsonMessage.Object;
    var role = jsonMessage.role;
}
init();

// This is called when the page finishes loading
function init() {

    // Assign page elements to variables
    var led = "";
    var ledId = "";
    $.each($entryLeds, function (index, value) {
        led = "" + value;
        ledId = "" + $entryLedIds[index];
        // Assign page elements to variables
        canvas[led] = document.getElementById(ledId);

        // Draw circle in canvas
        context[led] = canvas[led].getContext("2d");
        context[led].arc(15, 15, 5, 0, Math.PI * 2, false);
        context[led].lineWidth = 3;
        context[led].strokeStyle = "red";
        context[led].stroke();
        context[led].fillStyle = "red";
        context[led].fill();
    });

    // Connect to WebSocket server
    wsConnect(wsUrl_);
}

// Call this to connect to the WebSocket server
function wsConnect(wsUrl) {

    // Connect to WebSocket server
    websocket = new WebSocket(wsUrl);

    // Assign callbacks
    websocket.onopen = function (evt) { onOpen(evt) };
    websocket.onclose = function (evt) { onClose(evt) };
    websocket.onmessage = function (evt) { onMessage(evt) };
    websocket.onerror = function (evt) { onError(evt) };
}

// Called when a WebSocket connection is established with the server
function onOpen(evt) {

    // Log connection state
    console.log("Connected");
    //mess.From = "user";
    mess.To = "Box";
    mess.Object = "Connected clients";
    doSend(JSON.stringify(mess));
    //mess.Object = "Device Output Status";
    //mess.To = "Devices";
    //doSend(JSON.stringify(mess));
}

// Called when the WebSocket connection is closed
function onClose(evt) {
    // Log disconnection state
    console.log("Disconnected");

    // Try to reconnect after a few seconds
    setTimeout(function () { wsConnect(wsUrl_) }, 2000);
}

// Called when a message is received from the server
function onMessage(evt) {

    // Print out our received message
    //console.log("type of evt.data: " + typeof evt.data);
    console.log("Received: " + evt.data);
    var str = String(evt.data);
    //console.log("str: " + str);
    if (str.indexOf("{\"From\":") >= 0) {
        var json = JSON.parse(evt.data);
        //console.log("json : " + json);
        //$("#" + json.To).prop('checked', parseInt(json.message));
        //$("#" + key).closest("label").addClass("checked");
        //console.log(parseInt(json.message));
        var status;

        switch (json.To) {
            case "user":
                if (json.Object === "Device Output Status") {
                    status = (parseInt(json.message) === 1) ? true : false;
                    //$('#' + json.To).closest("label").toggleClass("checked", status);
                    $("#" + json.From).prop('checked', status);
                    if (status) {
                        $('[data-unit="' + json.From + '"]').toggleClass("active");
                        $("#" + json.From).closest("label").addClass("checked");
                    }
                    else {
                        $('[data-unit="' + json.From + '"]').removeClass("active");
                        $("#" + json.From).closest("label").removeClass("checked");
                    }
                }
                else if (json.Object === "Connected Clients") {
                    arr = $.parseJSON(json.message); //convert to javascript array
                    $.each(arr, function (key, value) {
                        //alert(value);
                        context[value].strokeStyle = "green";
                        context[value].stroke();
                        context[value].fillStyle = "green";
                        context[value].fill();
                    });
                    //Get the device's output status
                    mess.Object = "Device Output Status";
                    mess.To = "Devices";
                    doSend(JSON.stringify(mess));

                    //Get the ac-device's remaining time
                    mess.Object = "Remaining Time";
                    mess.To = "Devices";
                    doSend(JSON.stringify(mess));
                }
                else if (json.Object === "Disconnected Client") {
                    var led = json.message;
                    context[led].strokeStyle = "red";
                    context[led].stroke();
                    context[led].fillStyle = "red";
                    context[led].fill();

                    $('[data-unit="' + json.message + '"]').removeClass("active");
                    $("#" + json.message).closest("label").removeClass("checked");
                }
                else if (json.Object === "Remaining Time") {//Init the remaining time countdown
                    var TimeInMs = parseInt(json.message);
                    var id = json.From;
                    acTimer(id, TimeInMs);
                }
                break;
            default:
                break;
        }
    }
}

// Called when a WebSocket error occurs
function onError(evt) {
    console.log("ERROR: " + evt.data);
}

// Sends a message to the server (and prints it to the console)
function doSend(message) {
    console.log("Sending: " + message);
    websocket.send(message);
}

//Init the countdown timer of remaining time
function acTimer(id, ms) {
    //var ms = 298999;
    ms = 1000 * Math.round(ms / 1000); // round to nearest second
    var d = new Date(ms);
    var strTimer = d.getUTCHours() + 'h' + d.getUTCMinutes() + 'm' + d.getUTCSeconds() + 's';
    //var strTimer = msToTime(ms);
    console.log(strTimer);
    $('#RT_' + id).timer('remove');
    //$('#wash-machine').timer('pause');
    $('#RT_' + id).timer({
        countdown: true,
        format: '%H:%M:%S',
        duration: strTimer,
        callback: function () {
            //$('[data-unit="' + id + '"]').removeClass("active");
        }
    });

}

function msToTime(ms) {
    var seconds = (ms / 1000);
    var minutes = parseInt(seconds / 60, 10);
    seconds = seconds % 60;
    var hours = parseInt(minutes / 60, 10);
    minutes = minutes % 60;

    return hours + 'h' + minutes + 'm' + seconds + 's';
}

$(document).ready(function () {

    // Get checkbox statuses from localStorage if available (IE)
    if (localStorage) {

        // Menu minifier status (Contract/expand side menu on large screens)
        var checkboxValue = localStorage.getItem('minifier');

        if (checkboxValue === 'true') {
            $('#sidebar,#menu-minifier').addClass('mini');
            $('#minifier').prop('checked', true);

        } else {

            if ($('#minifier').is(':checked')) {
                $('#sidebar,#menu-minifier').addClass('mini');
                $('#minifier').prop('checked', true);
            } else {
                $('#sidebar,#menu-minifier').removeClass('mini');
                $('#minifier').prop('checked', false);
            }
        }

        // Switch statuses
        //var switchValues = JSON.parse(localStorage.getItem('switchValues')) || {};

        $.each(switchValues, function (key, value) {

            // Apply only if element is included on the page
            if ($('[data-unit="' + key + '"]').length) {

                if (value === true) {

                    // Apply appearance of the "unit" and checkbox element
                    $('[data-unit="' + key + '"]').addClass("active");
                    $("#" + key).prop('checked', true);
                    $("#" + key).closest("label").addClass("checked");

                    //In case of Camera unit - play video
                    if (key === "switch-camera-1" || key === "switch-camera-2") {
                        $('[data-unit="' + key + '"] video')[0].play();
                    }

                } else {
                    $('[data-unit="' + key + '"]').removeClass("active");
                    $("#" + key).prop('checked', false);
                    $("#" + key).closest("label").removeClass("checked");
                    if (key === "switch-camera-1" || key === "switch-camera-2") {
                        $('[data-unit="' + key + '"] video')[0].pause();
                    }
                }
            }
        });

        // Range Slider values
        var rangeValues = JSON.parse(localStorage.getItem('rangeValues')) || {};

        $.each(rangeValues, function (key, value) {

            // Apply only if element is included on the page
            if ($('[data-rangeslider="' + key + '"]').length) {

                if (key === 'fridge-temp') {
                    // Update Range slider - special case Fridge
                    var temperatureFar = value;
                    var temperatureCel = (temperatureFar - 32) * 5 / 9;
                    var roundCel = Number(Math.round(temperatureCel + 'e2') + 'e-2');
                    $('[data-rangeslider="' + key + '"] #fridge-temp-F').html(temperatureFar);
                    $('[data-rangeslider="' + key + '"] #fridge-temp-C').html(roundCel);

                } else {
                    // Update Range slider - universal
                    $('[data-rangeslider="' + key + '"] input[type="range"]').val(value);
                    $('[data-rangeslider="' + key + '"] .range-output').html(value);
                }
            }
        });

    }


    // Contract/expand side menu on click. (only large screens)
    $('#minifier').click(function () {

        $('#sidebar,#menu-minifier').toggleClass('mini');

        // Save side menu status to localStorage if available (IE)
        if (localStorage) {
            checkboxValue = this.checked;
            localStorage.setItem('minifier', checkboxValue);
        }

    });


    // Side menu toogler for medium and small screens
    $('[data-toggle="offcanvas"]').click(function () {
        $('.row-offcanvas').toggleClass('active');
    });


    // Switch (checkbox element) toogler
    $('.switch input[type="checkbox"]').on("change", function (t) {

        // Check the time between changes to prevert Android native browser execute twice
        // If you dont need support for Android native browser - just call "switchSingle" function
        if (this.last) {

            this.diff = t.timeStamp - this.last;

            // Don't execute if the time between changes is too short (less than 250ms) - Android native browser "twice bug"
            // The real time between two human taps/clicks is usually much more than 250ms"
            if (this.diff > 250) {

                this.last = t.timeStamp;
                mess.To = this.id;
                mess.Object = "Toggle";
                mess.message = (this.checked ? 1 : 0);

                //message.To = "moi";
                doSend(JSON.stringify(mess));
                this.checked = !this.checked;
                //$('[data-unit="' + this.id + '"]').toggleClass("active");
                //$('#' + this.id).closest("label").toggleClass("checked", this.checked);
                console.log('id = ' + this.id);
                console.log('checked = ' + this.checked);
                //iot.switchSingle(this.id, this.checked);

            } else {
                return false;
            }

        } else {

            // First attempt on this switch element
            this.last = t.timeStamp;
            mess.To = this.id;
            mess.Object = "Toggle";
            mess.message = (this.checked ? 1 : 0);

            doSend(JSON.stringify(mess));
            this.checked = !this.checked;
            //$('[data-unit="' + this.id + '"]').toggleClass("active");
            //$('#' + this.id).closest("label").toggleClass("checked", this.checked);
            console.log('id = ' + this.id);
            console.log('checked = ' + this.checked);
            //iot.switchSingle(this.id, this.checked);

        }
    });

    // All ON/OFF controls
    $('.lights-control').click(function () {

        var target = $(this).closest('.lights-controls').data('controls');
        var action = $(this).data('action');
        console.log('target = ' + target);
        console.log('action = ' + action);
        //iot.switchGroup(target, action);
        var el = '[data-unit-group="' + target + '"]';
        var key;
        var id;
        var status;
        // Apply changes based on action
        switch (action) {

            case 'all-on':
                $(el + ' [data-unit]').each(function () {
                    //console.log(this);
                    key = $(this).data('unit');
                    id = "#" + key;
                    //$(this).addClass("active");
                    //$("#" + key).prop('checked', true);
                    //$("#" + key).closest("label").addClass("checked");

                    status = $(id).is(':checked');
                    if (!status) {
                        mess.To = key;
                        mess.message = 1;
                        mess.Object = "Toggle";
                        //message.To = "moi";
                        doSend(JSON.stringify(mess));
                        //$(id).prop('checked', !status);
                        //$('[data-unit="' + this.id + '"]').toggleClass("active");
                        //$('#' + this.id).closest("label").toggleClass("checked", this.checked);
                        console.log('id = ' + key);
                        console.log('checked = ' + status);
                        //switchValues[key] = true;
                    }

                });
                break;
            case 'all-off':
                $(el + ' [data-unit]').each(function () {
                    key = $(this).data('unit');
                    id = "#" + key;
                    //$(this).addClass("active");
                    //$("#" + key).prop('checked', true);
                    //$("#" + key).closest("label").addClass("checked");

                    status = $(id).is(':checked');
                    if (status) {
                        mess.To = key;
                        mess.message = 0;
                        mess.Object = "Toggle";

                        //message.To = "moi";
                        doSend(JSON.stringify(mess));
                        //$(id).prop('checked', !status);
                        //$('[data-unit="' + this.id + '"]').toggleClass("active");
                        //$('#' + this.id).closest("label").toggleClass("checked", this.checked);
                        console.log('id = ' + key);
                        console.log('checked = ' + status);
                        //switchValues[key] = true;
                    }
                });
                break;
        }

    });

    // Reposition to center when a modal is shown
    $('.modal.centered').on('show.bs.modal', iot.centerModal);

    // Reset/Stop countdown timer (EXIT NOW)
    $('#armModal').on('hide.bs.modal', iot.clearCountdown);

    // Garage doors controls
    /*
    $('.doors-control').click(function () {
    
        var target = $(this).closest('.timer-controls').data('controls');
        var action = $(this).data('action');
    
        iot.garageDoors(target, action);
    });
    */

    // Alerts "Close" callback - hide modal and alert indicator dot when user closes all alerts
    $('#alertsModal .alert').on('close.bs.alert', function () {
        var sum = $('#alerts-toggler').attr('data-alerts');
        sum = sum - 1;
        $('#alerts-toggler').attr('data-alerts', sum);

        if (sum === 0) {
            $('#alertsModal').modal('hide');
            $('#alerts-toggler').attr('data-toggle', 'none');

        }

    });

    // Show/hide tips (popovers) - FAB button (right bottom on large screens)
    $('#info-toggler').click(function () {

        if ($('body').hasClass('info-active')) {
            $('[data-toggle="popover-all"]').popover('hide');
            $('body').removeClass('info-active');
        } else {
            $('[data-toggle="popover-all"]').popover('show');
            $('body').addClass('info-active');
        }
    });

    // Hide tips (popovers) by clicking outside
    $('body').on('click', function (pop) {

        if (pop.target.id !== 'info-toggler' && $('body').hasClass('info-active')) {
            $('[data-toggle="popover-all"]').popover('hide');
            $('body').removeClass('info-active');
        }

    });

});

// Apply necessary changes, functionality when content is loaded
$(window).on('load', function () {

    // This script is necessary for cross browsers icon sprite support (IE9+, ...) 
    svg4everybody();
    var ms = 298999;
    ms = 1000 * Math.round(ms / 1000); // round to nearest second
    var d = new Date(ms);
    var strTimer = d.getHours() + 'h' + d.getMinutes() + 'm' + d.getSeconds() + 's';
    console.log(strTimer); // "4:59"
    // Washing machine - demonstration of running program/cycle
    $('#wash-machine').timer({
        countdown: true,
        format: '%H:%M:%S',
        duration: strTimer,//'1h17m10s',
        callback: function () {
            $('[data-unit="wash-machine"]').removeClass("active");
        }
    });

    // Washing machine - demonstration of running program/cycle
    $('#wash-machine').timer({
        countdown: true,
        format: '%H:%M:%S',
        duration: '1m10s',
        //                duration: '1h17m10s',
        callback: function () {
            $('[data-unit="wash-machine"]').removeClass('active');
            $('[data-unit="wash-machine"] .status').html('OFF');
        }
    });

    $('[data-unit="wash-machine"] .timer-controls button[data-action="pause"]').css("display", "block");


    // "Timeout" function is not neccessary - important is to hide the preloader overlay
    setTimeout(function () {

        // Hide preloader overlay when content is loaded
        $('#iot-preloader,.card-preloader').fadeOut();
        $("#wrapper").removeClass("hidden");

        // Initialize range sliders
        $('input[type="range"]').rangeslider({
            polyfill: false,
            onSlideEnd: function (position, value) {

                var rangeValues = JSON.parse(localStorage.getItem('rangeValues')) || {};
                // Update localStorage
                if (localStorage) {
                    rangeValues[this.$element[0].id] = value;
                    localStorage.setItem("rangeValues", JSON.stringify(rangeValues));
                }
            }

        });

        // Check for Main contents scrollbar visibility and set right position for FAB button
        iot.positionFab();

    }, 800);

});

// Apply necessary changes if window resized
$(window).on('resize', function () {

    // Modal reposition when the window is resized
    $('.modal.centered:visible').each(iot.centerModal);

    // Check for Main contents scrollbar visibility and set right position for FAB button
    iot.positionFab();
});