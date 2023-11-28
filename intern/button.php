<!DOCTYPE html>
<html>
<head>
    <!-- Include necessary stylesheets and scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <button id="startButton">Start Exam</button>
    <div id="countdownDisplay"></div>
    <script>
        document.getElementById("startButton").addEventListener("click", function() {
            // Fetch the duration from the database using AJAX
            $.ajax({
                url: "fetch_duration.php",
                success: function(response) {
                    var duration = parseInt(response);
                    if (!isNaN(duration)) {
                        var countdownDisplay = document.getElementById('countdownDisplay');
                        startCountdown(duration * 60, countdownDisplay);
                    }
                }
            });
        });

        function startCountdown(duration, display) {
            var timer = duration, minutes, seconds;
            var countdownTimer = setInterval(function () {
                // Countdown logic as before...

                if (timer <= 0) {
                    clearInterval(countdownTimer);
                    display.textContent = "Time's up! Submitting exam...";
                    // AJAX call to submit the exam using PHP
                    $.ajax({
                        url: "submit_exam.php",
                        success: function(response) {
                            // Handle the response if needed
                        }
                    });
                }
            }, 1000);
        }
    </script>
</body>
</html>
