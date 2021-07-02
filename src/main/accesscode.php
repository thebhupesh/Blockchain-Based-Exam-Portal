<!DOCTYPE html>
<html>
    <title>Exam-Portal</title>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link type="text/css" rel="stylesheet" href="login.css">
	<script src="functions.js"></script>
	<?php
        $servername="localhost";
        $username="root";
        $password="";
        $mydb="exam_portal";
        $conn=new mysqli($servername, $username, $password, $mydb);
        $id=$_POST["id"];
        $sql="SELECT * FROM student_details WHERE id='$id';";
        $result=mysqli_query($conn, $sql);
        if($result->num_rows==1) {
            while($row=$result->fetch_assoc()) {
                $name=$row["name"];
                $name=explode(' ',$name,2);
                $fname=$name[0];
            }
        }
        mysqli_close($conn);
    ?>
    <style>
         div.line1 {
            height: 0.6%;
            width: 90%;
            background-color: #FFFFFF;
            position: absolute;
            left: 5%;
            top: 22%;
        }
        div.line2 {
            height: 0.6%;
            width: 90%;
            background-color: #FFFFFF;
            position: absolute;
            left: 5%;
            top: 38%;
        }
        img.icon {
            width: 6.5%;
            position: relative;
            top: 27px;
        }
        input.in {
            width: 92%;
            height: 10%;
            border: none;
            background-color: rgba(0, 0, 0, 0);
            color: #FFFFFF;
            font-family: Montserrat;
            font-size: 17px;
            font-weight: normal;
            font-style: normal;
            position: relative;
            top: 32px;
        }  
    </style>
    <body class="bdy">
		<div style="padding-top: 0.7%;">
			<h1>Exam-Portal</h1>
			<div class="line"></div>
			<h2>Secure Examination System</h2>
		</div>
		<div class="w3-panel w3-round-xlarge w3-white box1"></div>
		<div class="w3-panel w3-round-xlarge box2">
			<div style="position: relative; top: -5%;">
				<br><br><div class="line1"></div><h3 class="w3-text-white">Welcome <?php echo ucwords($fname); ?></h3><div class="line2"></div><br>
                <form action="login.php" method="post">
                    <div><img src="images/password.png" class="icon"> <input class="in" contenteditable="true" type="text" maxlength="19" minlength="19" placeholder="Enter Access Code" name="access" id="access" onkeyup="addHyphen(this); this.value = this.value.toUpperCase();" required></div>
                    <div style="position: relative; top: 15px;"><hr></div>
                    <input type="hidden" value="accesscode" name="type">
                    <input type="hidden" value="<?php echo $id ?>" name="id">
					<br><div class="w3-center" style="font-family: Montserrat; color: #0F2653; font-weight: bold; position: relative; top: 30px;"><button class="w3-button w3-white w3-hover-black w3-round-xxlarge" type="sign_in">Submit</button></div>
                </form>
			</div>
		</div>
    </body>
</html>
