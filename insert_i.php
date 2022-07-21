<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

$host = 'localhost';
$username = 'root'; # MySQL 계정 아이디
$password = 'leso1004'; # MySQL 계정 패스워드
$dbname = 'cool';  # DATABASE 이름


$con=mysqli_connect($host, $username, $password, $dbname);

mysqli_set_charset($con, "utf8");

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) )
{

    // 안드로이드 코드의 postParameters 변수에 적어준 이름을 가지고 값을 전달 받습니다.
    $pic=$_POST['i_pic'];
    $id=$_POST['i_id'];
    $name=$_POST['i_name'];
    $stprice=$_POST['i_stprice'];
    $type=$_POST['i_type'];
    $state=$_POST['i_state'];
    $intro=$_POST['i_intro'];//bind_param 에 넣을거, 웹, 앱에서 받아온 변수이름

    if(empty($pic)){
        $errMSG = "사진을 입력하세요.";
    }
    else if(empty($id)){
        $errMSG = "id를 입력하세요.";
    }
    else if(empty($name)){
        $errMSG = "제품명를 입력하세요.";
    }
    else if(empty($stprice)){
        $errMSG = "시작가를 입력하세요.";
    }
    else if(empty($type)){
        $errMSG = "상품타입을 입력하세요.";
    }
    else if(empty($state)){
        $errMSG = "상품상태를 입력하세요.";
    }
    else if(empty($intro)){
        $errMSG = "상품설명을 입력하세요.";
    }

    if(!isset($errMSG)) // 모두 입력이 되었다면
    {
        try{
            // SQL문을 실행하여 데이터를 MySQL 서버의 item 테이블에 저장
            $stmt = $con->prepare("INSERT INTO item(i_pic, i_id,  i_name, i_stprice, i_type, i_state, i_intro) VALUES(?, ?, ?, ?, ?, ?, ?) ");
            $stmt->bind_param('sssisss', $pic, $id, $name, $stprice, $type, $state, $intro);




            if($stmt->execute())
            {
                $successMSG = "새로운 상품을 추가했습니다.";
            }
            else
            {
                $errMSG = "품목 추가 에러";
            }

        } catch(Exception $e) {
            echo $e;
        }
    }

}

?>


<?php
if (isset($errMSG)) echo $errMSG;
if (isset($successMSG)) echo $successMSG;

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

if( !$android )
{
    ?>
    <html>
    <body>

    <form action="<?php $_PHP_SELF ?>" method="POST">
        PIC: <input type = "text" name = "i_pic" />
        ID: <input type = "text" name = "i_id" />
        NAME: <input type = "text" name = "i_name" />
        STPRICE: <input type = "text" name = "i_stprice" />
        TYPE<input type = "text" name = "i_type" />
        STATE<input type = "text" name = "i_state" />
        INTRO<input type = "text" name = "i_intro" />
        <input type = "submit" name = "submit" />
    </form>

    </body>
    </html>

    <?php
}
?>