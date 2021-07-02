<?php
    $servername="localhost";
    $username="root";
    $password="";
    $mydb="exam_portal";
    $conn=new mysqli($servername, $username, $password, $mydb);
    $type=$_POST["type"];
    if($type=="login") {
        $user=strtolower($_POST["user"]);
        $pwd=sha1($_POST["pwd"].strrev($_POST["pwd"]));
        $sql="SELECT * FROM accounts WHERE username='".$user."';";
        $result=mysqli_query($conn, $sql);
        if($result->num_rows==1) {
            while($row=$result->fetch_assoc()) {		
                if($user==strtolower($row["username"]) && $pwd==$row["password"]) {
                    $id=$row["username"];
                    echo "<form action='security.php' method='post' name='form'>
                        <input type='hidden' name='id' value='$id'>
                        </form>";
                    echo "<script>document.form.submit();</script>";
                }
                else {
                    echo '<script>alert("Incorrect Password!!!\nRetry...");
                        window.location.href = "login.html";</script>';
                }
            }
        }
        else {
            echo '<script>alert("Incorrect Credentials!!!\nRetry...");
                window.location.href = "login.html";</script>';
        }
    }
    elseif($type=="security") {
        $id=$_POST["id"];
        $code=sha1($_POST["code"]);
        $sql="SELECT * FROM accounts WHERE username='".$id."';";
        $result=mysqli_query($conn, $sql);
        if($result->num_rows==1) {
            while($row=$result->fetch_assoc()) {
                if($code==$row["security"]) {
                    $type=$row["type"];
                    if($type=="s") {
                        echo "<form action='accesscode.php' method='post' name='form'>
                        <input type='hidden' name='id' value='$id'>
                        </form>";
                    echo "<script>document.form.submit();</script>";
                    }
                    elseif($type=="f") {
                        echo "<form action='faculty_home.php' method='post' name='form'>
                            <input type='hidden' name='id' value='$id'>
                            </form>";
                        echo "<script>document.form.submit();</script>";
                    }
                }
                else {
                    echo '<script>alert("Incorrect Code!!!\nRetry...");</script>';
                    echo "<form action='security.php' method='post' name='form'>
                        <input type='hidden' name='id' value='$id'>
                        </form>";
                    echo "<script>document.form.submit();</script>";
                }
            }
        }
        else {
            echo '<script>alert("Incorrect Data!!!\nRetry...");
                window.location.href = "login.html";</script>';
        }
    }
    elseif($type=="accesscode") {
        $id=$_POST["id"];
        $accesscode=removeHyphen(strtoupper($_POST["access"]));
        $sql="SELECT paper_id,duration FROM paper_details WHERE access_code='$accesscode';";
        $result=mysqli_query($conn, $sql);
        if($result->num_rows==1) {
            while($row=$result->fetch_assoc()) {
                $pid=$row["paper_id"];
                $sql="SELECT * FROM answer_details WHERE paper_id='$pid' AND student_id='$id';";
                $result_=mysqli_query($conn, $sql);
                if($result_->num_rows==1) {
                    echo '<script>alert("You have already submitted the exam.");
                        window.location.href = "login.html";</script>';
                    break;
                }
                echo "<form action='question_paper.php' method='post' name='form'>
                    <input type='hidden' name='id' value='$id'>
                    <input type='hidden' name='pid' value='$pid'>
                    <input type='hidden' name='time' value='".$row["duration"]."'>
                    </form>";
                echo "<script>document.form.submit();</script>";
            }
        }
        else {
            echo '<script>alert("Incorrect Access Code!!!\nRetry...");</script>';
            echo "<form action='accesscode.php' method='post' name='form'>
                <input type='hidden' name='id' value='$id'>
                </form>";
            echo "<script>document.form.submit();</script>";
        }
    }
    function removeHyphen($str) {
        $str = str_replace("-", '', $str);
        return $str;
    }
    mysqli_close($conn);
?>
