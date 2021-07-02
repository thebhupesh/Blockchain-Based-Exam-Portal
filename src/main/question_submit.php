<?php
    function genPID() {
        $data="0123456789";
        $length=strlen($data);
        $string='';
        for($i=0; $i<3; $i++) {
            $character=$data[mt_rand(0, $length - 1)];
            $string.=$character;
        }
        $string="P".$string;
        $servername="localhost";
        $username="root";
        $password="";
        $mydb="exam_portal";
        $conn=new mysqli($servername, $username, $password, $mydb);
        $sql="SELECT paper_id FROM paper_details WHERE paper_id='$string';";
        $result=mysqli_query($conn, $sql);
        if($result->num_rows>0 or $string=="P000") {
            genPID();
        }    
        else {
            return $string;
        }
    }
    function genAccess() {
        $data="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $length=strlen($data);
        $string='';
        for($i=0; $i<16; $i++) {
            $character=$data[mt_rand(0, $length - 1)];
            $string.=$character;
        }
        $servername="localhost";
        $username="root";
        $password="";
        $mydb="exam_portal";
        $conn=new mysqli($servername, $username, $password, $mydb);
        $sql="SELECT access_code FROM paper_details WHERE access_code='$string';";
        $result=mysqli_query($conn, $sql);
        if($result->num_rows>0 or $string=="0000000000000000") {
            genAccess();
        }    
        else {
            return $string;
        }
    }
    $servername="localhost";
    $username="root";
    $password="";
    $mydb="exam_portal";
    $conn=new mysqli($servername, $username, $password, $mydb);
    $id=$_POST["id"];
    $name=$_POST["name"];
    $start=$_POST["start"];
    $end=$_POST["end"];
    $time=$_POST["time"];
    $count=$_POST["count"];
    $ctime=date("Y-m-d H:i:s");
    $pid=genPID();
    $access=genAccess();
    $sql="INSERT INTO paper_details VALUES('$id','$pid','$name','$access','$start','$end','$time','$ctime');";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
    $conn=new MongoDB\Driver\Manager('mongodb://localhost:27017');
    $inserts=new MongoDB\Driver\BulkWrite();
    $db="exam_paper";
    $collection=$pid;
    for($i=1; $i<=$count; $i+=1) {
        $a=[];
        for($j=0; $j<4; $j+=1) {
            array_push($a,base64_encode($_POST[$i.":".$j]));
        }
        $data=array(
            'T' => "$i",
            'Q' => base64_encode($_POST["q".$i]),
            'A' => $a
        );
        $inserts->insert($data);
    }
    $conn->executeBulkWrite("$db.$collection", $inserts);
    echo "<form action='faculty_home.php' name='form' method='post'>
        <input type='hidden' name='id' value='$id'>
    </form>
    <script>alert('Exam Created Successfully!!!');
    document.form.submit();</script>";
?>
