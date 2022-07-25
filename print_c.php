<?php

$con=mysqli_connect("localhost", "root", "leso1004", "cool");
//if(mysqli_connect_error($con)){
//   echo "실패" . mysqli_connect_error();
//}
mysqli_set_charset($con, "utf8");

$res=mysqli_query($con, "select * from customer");
$result=array();

while($row=mysqli_fetch_array($res)){
array_push($result,
array('id'=>$row[0], 'name'=>$row[1], 'pw'=>$row[2], 'email'=>$row[3], 'pnum'=>$row[4],
'pnum'=>$row[5], 'grade'=>$row[6], 'admin'=>$row[6]));
}
echo json_encode(array("result"=>$result));


mysqli_close($con);
?>
