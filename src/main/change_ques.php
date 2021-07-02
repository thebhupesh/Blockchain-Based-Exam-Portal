<?php
    function random($c) {
        $n=range(1,$c);
        shuffle($n);
        return array_slice($n,0,10);
    }
    $count=$_REQUEST["count"];
    $pid=$_REQUEST["pid"];
    $id=$_REQUEST["id"];
    $con=new MongoDB\Driver\Manager('mongodb://localhost:27017');
    $collection=$pid;
    $db="exam_paper";
    $filter = [];
    $option = [];
    $read = new MongoDB\Driver\Query($filter, $option);
    $item = $con->executeQuery("$db.$collection", $read);
    $c=0;
    foreach($item as $q) {
        $c+=1;
    }
    $db="exam_question";
    $filter=['id' => $id];
    $option=[];
    $read=new MongoDB\Driver\Query($filter, $option);
    $seq=$con->executeQuery("$db.$collection", $read);
    foreach($seq as $qseq) {
	    $qarr=$qseq->sequence;
    }
    if(empty($qarr)) {
        $qarr=random($c);
        $data=array(
            'id' => $id,
            'sequence' => $qarr
        );
        $inserts = new MongoDB\Driver\BulkWrite();
        $inserts->insert($data);
        $con->executeBulkWrite("$db.$collection", $inserts);
    }
    $db="exam_paper";
    $filter = ['T' => "$qarr[$count]"];
    $option = [];
    $read = new MongoDB\Driver\Query($filter, $option);
    $item = $con->executeQuery("$db.$collection", $read);
    echo "<p id='title'>Question: ".($count+1)."</p>";
    echo '<div id="question_content">';
    foreach($item as $question) {
        echo "<p>".base64_decode($question->Q)."</p>";
        $op=0;
        foreach($question->A as $option) {
            echo "<input type='radio' class='radio' name ='option' id='".$op."' value='".$count.":".$op."'>
            <label id='label' for='".$op."'>".chr(65+$op).". ".base64_decode($option)."</label><br>";
            $op+=1;
        }
    }
    echo '</div>';
    echo '<br>';
    echo '<button id="submit" onclick="submit()"><b>Submit</b></button>';
    if($count=='9') {
        echo '<button id="finish" onclick="finish()" disabled><b>Finish</b></button>';
    }
?>
