<?php
    $servername="localhost";
    $username="root";
    $password="";
    $mydb="exam_portal";
    $conn=new mysqli($servername, $username, $password, $mydb);
    $id=$_POST["id"];
    $pid=$_POST["pid"];
    $time=$_POST["timeStamp"];
    $sql="INSERT INTO answer_details VALUES('$id','$pid','$time');";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
?>
