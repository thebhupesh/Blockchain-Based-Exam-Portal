<?php
    $servername="localhost";
    $username="root";
    $password="";
    $mydb="exam_portal";
    $conn=new mysqli($servername, $username, $password, $mydb);
    $id=$_POST["id"];
    $sql="SELECT * FROM faculty_details WHERE id='$id';";
    $result=mysqli_query($conn, $sql);
    if($result->num_rows==1) {
        while($row=$result->fetch_assoc()) {
            $name=$row["name"];
            $phone=$row["phone"];
            $email=$row["email"];
        }
    }
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
            <a href="login.html" id="logout">Logout</a>
        </div>
        <p id="welcome">Welcome</p>
        <div id="line"></div>
        <div id="details">
            <p id="title">Details</p>
            <div id="line" style="margin-top: -7%; margin-left: 7.5%; width: 85%;"></div>
            <div id="data">
                <p><b>ID:</b> <?php echo $id; ?></p>
                <p><b>Name:</b> <?php echo strtoupper($name); ?></p>
                <p><b>Phone No.:</b> <?php echo "+91-".$phone; ?></p>
                <p><b>Email:</b> <?php echo $email; ?></p>
            </div>
        </div>
        <div id="line" style="margin-top: 3%;"></div>
        <p id="title" style="margin-top: 1%; margin-bottom: 1%;">Exam Details</p>
        <div id="exams">
            <?php
                $sql="SELECT * FROM paper_details WHERE teacher_id='$id' ORDER BY timestamp ASC;";
                if($result=mysqli_query($conn, $sql)) {
                    if($result->num_rows!=0) {
                        echo "<table id='table' class='w3-table w3-striped paper'>";
                        echo "<thead>";
                        echo "<tr style='background-color: #0F2653; color: #FFFFFF;'>";
                        echo "<th class='w3-center' style='padding: 12px;'>S.No.</th>";
                        echo "<th class='w3-center' style='padding: 12px;'>Name</th>";
                        echo "<th class='w3-center' style='padding: 12px;'>Access Code</th>";
                        echo "<th class='w3-center' style='padding: 12px;'>Start</th>";
                        echo "<th class='w3-center' style='padding: 12px;'>End</th>";  
                        echo "<th class='w3-center' style='padding: 12px;'>Duration</th>";
                        echo "<th class='w3-center' style='padding: 12px;'>Evaluate</th>";
                        echo "</tr></thead>";
                        echo "<tbody>";
                        while($row=mysqli_fetch_array($result)) {
                            echo "<tr class='w3-light-grey w3-border w3-border-white'>";
                            echo "<td class='w3-center'></td>";
                            echo "<td class='w3-center'> {$row[2]}</td>";
                            echo "<td class='w3-center'> ".hyphen($row[3])."</td>";
                            echo "<td class='w3-center'> ".date("d-m-Y g:iA", strtotime($row[4]))."</td>";
                            echo "<td class='w3-center'> ".date("d-m-Y g:iA", strtotime($row[5]))."</td>";
                            echo "<td class='w3-center'> ".date("G:i:s", strtotime($row[6]))."</td>"; ?>
                            <td class='w3-center'> <button id='btn' onclick='getStudents("<?php echo base64_encode($row[1]); ?>")'>Evaluate</button></td>
                        <?php 
                        }
                        echo "</tr></tbody></table>";
                    }
                    else {
                        echo "<table class='w3-table w3-striped'>";
                        echo "<thead>";
                        echo "<tr style='background-color: #0F2653; color: #FFFFFF;'>";
                        echo "<th class='w3-center' style='padding: 12px;'>***No Exam Created***</th>";
                        echo "</tr></thead></table><br>";
                    }
                }
            ?>
            <button id="btn" onclick="document.getElementById('create').style.display='block'" style="font-size: 20px; font-weight: bold; padding: 10px;">Create</button>
        </div>
        <div class="w3-container">
			<div id="create" class="w3-modal">
				<div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
					<div class="w3-center"><br>
						<span onclick="document.getElementById('create').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
					</div>
					<form class="w3-container" action="create_exam.php" method="post">
						<div class="w3-section">
                            <input type="hidden" value="<?php echo $id; ?>" name="id">
                            <label style="color: #0F2653;"><b>Exam Name</b></label>
							<input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter exam name" name="name" required>
							<label style="color: #0F2653;"><b>Exam Date</b></label>
							<input class="w3-input w3-border w3-margin-bottom" type="date" name="date" required>
							<label style="color: #0F2653;"><b>Start Time</b></label>
							<input class="w3-input w3-border w3-margin-bottom" type="time" name="start" required>
							<label style="color: #0F2653;"><b>End Time</b></label>
							<input class="w3-input w3-border w3-margin-bottom" type="time" name="end" required>
                            <label style="color: #0F2653;"><b>Exam Duration </b></label>
                            <input class=" w3-input w3-border w3-margin-bottom" style="width: 60px; display: inline-block;" type="number" name="hour" min="0" required> <b>:</b> <input class="w3-input w3-border w3-margin-bottom" style="width: 60px; display: inline-block;" type="number" name="min" min="0" max="59" required>
							<button class="w3-button w3-block w3-section w3-padding" style="color: #FFFFFF; background-color: #0F2653;" type="submit"><b>Create Exam</b></button>
						</div>
					</form>
				</div>
			</div>
		</div>
        <div class="w3-container">
			<div id="evaluate" class="w3-modal">
                <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
					<div class="w3-center"><br>
						<span onclick="document.getElementById('evaluate').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                    </div>
                    <div class="w3-container">
                        <div id="students" class="w3-section">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    var modal1 = document.getElementById('create');
    var modal2 = document.getElementById('evaluate');
    window.onclick = function(event) {
        if (event.target == modal1) {
            modal1.style.display = "none";
        }
        if (event.target == modal2) {
            modal2.style.display = "none";
        }
    }
</script>
<?php
    function hyphen($str) {
        $main="";
        $j=0;
        for($i=0;$i<4;$i+=1) {
            $n=0;
            while($n!=4) {
                $main.=$str[$j];
                $j+=1;
                $n+=1;
            }
            if($i!=3) {
                $main.="-";
            }
        }
        return $main;
    }
    mysqli_close($conn);
?>
