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
    $i_price=$_POST['i_price'];
    $i_num=$_POST['i_num'];
    //bind_param 에 넣을거, 웹, 앱에서 받아온 변수이름

    if(empty($i_price)){
        $errMSG = "가격을 입력하세요.";
    }
    else if(empty($i_num)){
        $errMSG = "상품번호를 입력하세요.";
    }
    if(!isset($errMSG)) // 모두 입력이 되었다면
    {
        try{
            // SQL문을 실행하여 데이터를 MySQL 서버의 item 테이블에 저장
            $stmt = $con->prepare("UPDATE item SET i_price =? WHERE i_num='?'");
            
            $stmt->bind_param('ii', $i_price, $i_num);




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
        PRICE: <input type = "text" name = "i_price" />
        ITEM NUMBER: <input type = "text" name = "i_num" />
        <input type = "submit" name = "submit" />
    </form>

    </body>
    </html>

    <?php
}
?>