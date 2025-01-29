<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $targetDate = $_POST['target_date'];
    // Validate the input date
    if (strtotime($targetDate)) {
        $targetTimestamp = strtotime($targetDate);
    } else {
        $error = "Please enter a valid date.";
    }
} else {
    $targetTimestamp = null;
    $error = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Countdown Timer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        .timer {
            font-size: 2rem;
            margin-top: 20px;
        }
        .error {
            color: red;
            font-size: 1.2rem;
        }
        input[type="datetime-local"] {
            padding: 10px;
            font-size: 1rem;
        }
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 1rem;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Countdown Timer</h1>

    <!-- Display error if date is invalid -->
    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- Countdown Form -->
    <form method="POST">
        <label for="target_date">Enter Date and Time:</label><br>
        <input type="datetime-local" id="target_date" name="target_date" required><br><br>
        <input type="submit" value="Start Countdown">
    </form>

    <?php if ($targetTimestamp): ?>
        <div class="timer" id="countdown"></div>

        <script>
            // Set the target date and time
            const targetDate = new Date("<?php echo date('Y-m-d\TH:i:s', $targetTimestamp); ?>").getTime();

            // Update the countdown every 1 second
            const x = setInterval(function() {
                // Get the current date and time
                const now = new Date().getTime();
                const distance = targetDate - now;

                // Calculate days, hours, minutes, and seconds
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result
                document.getElementById("countdown").innerHTML =
                    days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

                // If the countdown is over, display a message
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("countdown").innerHTML = "EXPIRED";
                }
            }, 1000);
        </script>
    <?php endif; ?>

</body>
</html>
