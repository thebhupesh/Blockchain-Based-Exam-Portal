<?php
    $pid=base64_decode($_GET["pid"]);
    $sid=base64_decode($_GET["sid"]);
    $count=$_GET["c"];
    $con=new MongoDB\Driver\Manager('mongodb://localhost:27017');
    $collection=$pid;
    $db="exam_question";
    $filter=['id' => $sid];
    $option=[];
    $read=new MongoDB\Driver\Query($filter, $option);
    $seq=$con->executeQuery("$db.$collection", $read);
    foreach($seq as $qseq) {
        $qarr=$qseq->sequence;
    }
    $db="exam_paper";
    $filter = ['T' => "$qarr[$count]"];
    $option = [];
    $read = new MongoDB\Driver\Query($filter, $option);
    $item = $con->executeQuery("$db.$collection", $read);
    echo "<br><p id='title' name='title'>Question: ".($count+1)."</p>";
    echo '<div id="question_content">';
    foreach($item as $question) {
        echo "<p style='font-size: 20px;'><b>".base64_decode($question->Q)."</b></p>";
        $op=1;
        foreach($question->A as $option) {
            echo "<p class='option' id='".$op."'>".chr(65+$op-1).". ".base64_decode($option)."</p>";
            $op+=1;
        }
    }
    $back=(int)$count-1;
    $fwd=(int)$count+1;
    if($back>=0) {
        echo "<div style='text-align: left;'><button id='btn' style='padding: 10px; margin-top: 15px;' onclick='review($back)'>Previous</button></div>";
    }
    if($fwd!=10) {
        echo "<div style='text-align: right; margin-top: -57.5px;'><button id='btn' style='padding: 10px; margin-top: 15px;' onclick='review($fwd)'>Next</button></div>";
    }
    echo '</div>';
?>
