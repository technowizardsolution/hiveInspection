@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class='container'>
                        Seconds : <div id='seconds'></div>
                    </div>
                    <ul id="activityLogger">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript">
        window.onbeforeunload = function (event) {
            var message = 'Important: Please click on \'Save\' button to leave this page.';
            if (typeof event == 'undefined') {
                event = window.event;
            }
            if (event) {
                event.returnValue = message;
            }
            return message;
        };
        $(document).ready(function()
        {
            $(window).bind("beforeunload", function() { 
                return confirm("Do you really want to close?"); 
            });
        });
        window.addEventListener('beforeunload', function (e) {
            e.preventDefault();
            e.returnValue = '';
        });
        $(document).ready(function() {
            document.addEventListener("visibilitychange", event => {
                if (document.visibilityState == "visible") {
                console.log("tab is active")
                } else {
                console.log("tab is inactive")
                }
            })
            handleVisibilityChange(false);
        });

        var startTime = new Date();
        var hidden;
        var visibilityChange;

        function logData(message) {
            console.log(message);
            var ul = document.getElementById("activityLogger");
            var li = document.createElement("li");
            li.appendChild(document.createTextNode(message));
            ul.appendChild(li);
        }

        function handleVisibilityChange(customState) {
            var date = new Date();
            var currentTime = date.getTime();
            var changeTime = date.getTime() - startTime;
            changeTime = Math.round(changeTime / 1000);

            if (customState !== true && customState !== false) {
                customState = document[hidden] ? false : true;
            }

            if (customState) {
                logData('User came back after ' + changeTime + ' seconds');
            } else {
                logData('User exited after browsing for ' + changeTime + ' seconds');
            }

            startTime = currentTime;
        }

        document.addEventListener("DOMContentLoaded", function(event) {

            if (document.hidden !== undefined) { // Opera 12.10 and Firefox 18 and later support
                hidden = "hidden";
                visibilityChange = "visibilitychange";
            } else if (document.mozHidden !== undefined) {
                hidden = "mozHidden";
                visibilityChange = "mozvisibilitychange";
            } else if (document.msHidden !== undefined) {
                hidden = "msHidden";
                visibilityChange = "msvisibilitychange";
            } else if (document.webkitHidden !== undefined) {
                hidden = "webkitHidden";
                visibilityChange = "webkitvisibilitychange";
            } else if (document.oHidden !== undefined) {
                hidden = "oHidden";
                visibilityChange = "ovisibilitychange";
            }

            window.addEventListener('beforeunload', function(event) {
                handleVisibilityChange(false);
            }, false);

            document.addEventListener(visibilityChange, function(event) {
                handleVisibilityChange();
            }, false);
        });



        ////////////////////////////////////////////////////

        
        var count = 0;
        var myInterval;
        // Active
        window.addEventListener('focus', startTimer);

        // Inactive
        window.addEventListener('blur', stopTimer);

        function timerHandler() {
            count++;
            document.getElementById("seconds").innerHTML = count;
        }

        // Start timer
        function startTimer() {
            console.log('focus');
            myInterval = window.setInterval(timerHandler, 1000);
        }

        // Stop timer
        function stopTimer() {
            window.clearInterval(myInterval);
        }

        $(document).ready(function() {
            startTimer();
        });


        window.addEventListener("beforeunload", function (e) {
            var confirmationMessage = "\o/";

            (e || window.event).returnValue = confirmationMessage; //Gecko + IE
            return confirmationMessage;                            //Webkit, Safari, Chrome
        });
    </script>
@endsection