<?php
    $servername="localhost";
    $username="root";
    $password="";
    $mydb="exam_portal";
    $conn=new mysqli($servername, $username, $password, $mydb);
    $id=$_POST["id"];
    $pid=$_POST["pid"];
    $time=$_POST["time"];
    $sql="SELECT * FROM paper_details WHERE paper_id='$pid';";
    $result=mysqli_query($conn, $sql);
    if($result->num_rows==1) {
        while($row=$result->fetch_assoc()) {
            $tid=$row["teacher_id"];
            $name=$row["name"];
            $start=date($row["start"]);
            $end=date($row["end"]);
        }
    }
    $duration=strtotime("1970-01-01 ".$time." UTC");
    $date=date("Y-m-d H:i:s");
    $sql="SELECT * FROM student_details WHERE id='$id';";
    $result=mysqli_query($conn, $sql);
    if($result->num_rows==1) {
        while($row=$result->fetch_assoc()) {
            $sname=$row["name"];
            $phone=$row["phone"];
            $email=$row["email"];
        }
    }
    /*if($start>$date) {
        echo '<script>alert("You do not have exam right now.");
        window.location.href="login.html";</script>';
    }
    elseif($date>(date("Y-m-d H:i:s", date_timestamp_get(date_create($end))-$duration+60)) && $end>$date) {
        echo '<script>alert("Can not join exam.\nYou are late.");
        window.location.href="login.html";</script>';
    }
    elseif($end<$date) {
        echo '<script>alert("The exam is over.");
        window.location.href="login.html";</script>';
    }
    else {*/
?>
<!DOCTYPE html>
<html>
    <title>Exam-Portal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link type="text/css" rel="stylesheet" href="exam.css">
    <script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.36/dist/web3.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="functions.js"></script>
    <body class="w3-content">
        <div id="header" class="w3-top">
            <p id="exam_name"><b><?php echo $name; ?></b></p>
            <p id="timer"><?php echo $time; ?></p>
            <img src="images/timer.png" id="time">
        </div>
        <div id="gen_inst">
            <p id="title">General Instructions</p>
            <div id="content">
                <p><b>1.</b> Visited & unanswered question appear red.</p>
                <p><b>2.</b> Answered questions will appear green.</p>
                <p><b>3.</b> Click 'Submit' button to save the answer.</p>
                <p><b>4.</b> To finish exam go to last question.</p>
                <p><b>5.</b> The exam will submit itself when time ends.</p>
            </div>
        </div>
        <div id="info">
            <p id="title">Student Details</p>
            <div id="content">
                <p><b>Student Name:</b> <?php echo strtoupper($sname); ?></p>
                <p><b>Registration No.:</b> <?php echo strtoupper($id); ?></p>
                <p><b>Phone No.:</b> <?php echo "+91-".$phone; ?></p>
                <p><b>Email:</b> <?php echo $email; ?></p>
            </div>
        </div>
        <div id="switch">
            <button id="q_no" name="0" onclick="change('0')"><b>Q.1</b></button>
            <button id="q_no" name="1" onclick="change('1')"><b>Q.2</b></button>
            <button id="q_no" name="2" onclick="change('2')"><b>Q.3</b></button>
            <button id="q_no" name="3" onclick="change('3')"><b>Q.4</b></button>
            <button id="q_no" name="4" onclick="change('4')"><b>Q.5</b></button>
            <button id="q_no" name="5" onclick="change('5')"><b>Q.6</b></button>
            <button id="q_no" name="6" onclick="change('6')"><b>Q.7</b></button>
            <button id="q_no" name="7" onclick="change('7')"><b>Q.8</b></button>
            <button id="q_no" name="8" onclick="change('8')"><b>Q.9</b></button>
            <button id="q_no" name="9" onclick="change('9')"><b>Q.10</b></button>
        </div>
        <div id="question">
        </div>
    </body>
    <script>
        var pid = "<?php echo $pid; ?>";
        var id = "<?php echo $id; ?>";
        change(count);
        counter();
    </script>
</html>
<?php
    /*}*/
    mysqli_close($conn);
?>
