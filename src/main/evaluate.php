<?php
    $pid=base64_decode($_GET["pid"]);
    $type=$_GET["type"];
    $ctime=date("Y-m-d H:i:s");
    $servername="localhost";
    $username="root";
    $password="";
    $mydb="exam_portal";
    $conn=new mysqli($servername, $username, $password, $mydb);
    $sql="SELECT * FROM paper_details WHERE paper_id='$pid';";
    $result=mysqli_query($conn, $sql);
    if($result->num_rows==1) {
        while($row=$result->fetch_assoc()) {
            $tid=$row["teacher_id"];
            $ename=$row["name"];
        }
    }
    if($type=='initiate') {
        $sql="SELECT end FROM paper_details WHERE paper_id='$pid';";
        $result=mysqli_query($conn, $sql);
        if($result->num_rows==1) {
            while($row=$result->fetch_assoc()) {
                if(date($row["end"])>$ctime) {
                    echo "<br><table class='w3-table w3-striped'>";
                    echo "<thead>";
                    echo "<tr style='background-color: #0F2653; color: #FFFFFF;'>";
                    echo "<th class='w3-center' style='padding: 12px;'>***Exam Not Yet Finished***</th>";
                    echo "</tr></thead></table><br>";
                }
                else {
                    $sql1="SELECT * FROM answer_details WHERE paper_id='$pid' ORDER BY submit_time ASC;";
                    if($result1=mysqli_query($conn, $sql1)) {
                        if($result1->num_rows!=0) {
                            echo "<p id='title'>Students</p>";
                            echo "<table id='table' class='w3-table w3-striped students'>";
                            echo "<thead>";
                            echo "<tr style='background-color: #0F2653; color: #FFFFFF;'>";
                            echo "<th class='w3-center' style='padding: 12px;'>S.No.</th>";
                            echo "<th class='w3-center' style='padding: 12px;'>Reg. No.</th>";
                            echo "<th class='w3-center' style='padding: 12px;'>Name</th>";
                            echo "<th class='w3-center' style='padding: 12px;'>Submit Time</th>";
                            echo "<th class='w3-center' style='padding: 12px;'>View</th>";
                            echo "</tr></thead>";
                            echo "<tbody>";
                            while($row1=mysqli_fetch_array($result1)) {
                                echo "<tr class='w3-light-grey w3-border w3-border-white'>";
                                echo "<td class='w3-center'> </td>";
                                echo "<td class='w3-center'> {$row1[0]}</td>";
                                $sql2="SELECT name FROM student_details WHERE id='$row1[0]';";
                                if($result2=mysqli_query($conn, $sql2)) {
                                    while($row2=mysqli_fetch_array($result2)) {
                                        echo "<td class='w3-center'> ".strtoupper($row2[0])."</td>";
                                    }
                                }
                                echo "<td class='w3-center'> ".date("d-m-Y g:iA", strtotime($row1[2]))."</td>";
                                echo "<td class='w3-center'>
                                <form action='evaluate.php' method='get'>
                                    <input type='hidden' value='".base64_encode($row1[0])."' name='sid'>
                                    <input type='hidden' value='".base64_encode($pid)."' name='pid'>
                                    <input type='hidden' value='".sha1('final')."' name='type'>";
                                echo " <button id='btn' type='submit'>View</button></form></td>";
                            }
                            echo "</tr></tbody></table>";
                        }
                        else {
                            echo "<br><table class='w3-table w3-striped'>";
                            echo "<thead>";
                            echo "<tr style='background-color: #0F2653; color: #FFFFFF;'>";
                            echo "<th class='w3-center' style='padding: 12px;'>***No One Has Submitted Yet***</th>";
                            echo "</tr></thead></table><br>";
                        }
                    }
                }
            }
        }
    }
    elseif($type==sha1('final')) {
        $sid=$_GET["sid"];
?>
<!DOCTYPE html>
<html>
    <title>Exam-Portal</title>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link type="text/css" rel="stylesheet" href="faculty_home.css">
    <script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.36/dist/web3.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="functions.js"></script>
	<body class="w3-content">
        <div id="header" class="w3-top">
            <p id="head_title1"><b>Exam-Portal</b></p>
            <p id="head_title2">Secure Examination System</p>
            <button id="logout" style="background-color: darkred;" onclick="history.go(-1);">Exit</a>
        </div>
        <p id="welcome" style="font-size: 35px;"><?php echo $ename; ?></p>
        <div id="line"></div>
        <br><p id="title" style="font-size: 25px; font-weight: normal;"><b>Registration No.:</b> <?php echo base64_decode($sid); ?></p>
        <div id="question">
        </div>
    </body>
</html>
<script>
    var sid = '<?php echo $sid; ?>';
    var pid = '<?php echo base64_encode($pid); ?>';
    answer();
    review(0);
</script>
<?php
    }
    mysqli_close($conn);
?>
