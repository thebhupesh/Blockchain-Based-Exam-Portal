<?php
    $id=$_POST["id"];
    $name=$_POST["name"];
    $date=$_POST["date"];
    $start=$_POST["start"];
    $start=$date." ".$start.":00";
    $end=$_POST["end"];
    $end=$date." ".$end.":00";
    $hour=$_POST["hour"];
    $min=$_POST["min"];
    $time=$hour.":".$min.":00";
?>
<!DOCTYPE html>
<html>
    <title>Exam-Portal</title>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link type="text/css" rel="stylesheet" href="faculty_home.css">
	<script src="functions.js"></script>
	<body class="w3-content">
        <div id="header" class="w3-top">
            <p id="head_title1"><b>Exam-Portal</b></p>
            <p id="head_title2">Secure Examination System</p>
            <form action="faculty_home.php" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <button type="submit" id="logout" style="background-color: darkred;">Cancel</a>
            </form>
        </div>
        <p id="welcome">Enter Questions</p>
        <div id="line"></div>
        <div id="questions">
            <form name="form" id="form" action="question_submit.php" method="post">
                <?php
                    echo "
                    <input type='hidden' name='id' value='$id'>
                    <input type='hidden' name='name' value='$name'>
                    <input type='hidden' name='start' value='$start'>
                    <input type='hidden' name='end' value='$end'>
                    <input type='hidden' name='time' value='$time'>
                    ";
                ?>
            </form>
            <button id="btn" style="padding: 10px; margin-top: 15px;" onclick="appendQuestion()">Add Question</button>
            <button id="btn" style="background-color: darkred; position: relative; left: 77.9%; padding: 10px; margin-top: 15px;" onclick="deleteQuestion()">Delete</button>
            <div style="width: 100%; text-align: center;"><button id="btn" style="padding: 15px; margin-top: 15px; background-color: darkgreen;" onclick="submitQuestions()">Submit</button></div>
        </div>
    </body>
    <script>
        initiate();
    </script>
</html>
