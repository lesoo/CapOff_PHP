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
    $id=$_POST['id'];
    $name=$_POST['name'];
    $pw=$_POST['pw'];
    $email=$_POST['email'];
    $pnum=$_POST['pnum'];

    if(empty($name)){
        $errMSG = "이름을 입력하세요.";
    }
    else if(empty($id)){
        $errMSG = "id를 입력하세요.";
    }
    else if(empty($pw)){
        $errMSG = "비밀번호를 입력하세요.";
    }
    else if(empty($email)){
        $errMSG = "이메일을 입력하세요.";
    }
    else if(empty($pnum)){
        $errMSG = "전화번호를 입력하세요.";
    }

    if(!isset($errMSG)) // 모두 입력이 되었다면
    {
        try{
            // SQL문을 실행하여 데이터를 MySQL 서버의 customer 테이블에 저장합니다.
            $stmt = $con->prepare("INSERT INTO customer(c_id, c_name, c_pw, c_email, c_pnum) VALUES(?, ?, ?, ?, ?) ");
            $stmt->bind_param('sssss', $id, $name, $pw, $email, $pnum);




            if($stmt->execute())
            {
                $successMSG = "새로운 사용자를 추가했습니다.";
            }
            else
            {
                $errMSG = "사용자 추가 에러";
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
        Name: <input type = "text" name = "name" />
        ID: <input type = "text" name = "id" />
        PW: <input type = "text" name = "pw" />
        Email<input type = "text" name = "email" />
        PNum<input type = "text" name = "pnum" />
        <input type = "submit" name = "submit" />
    </form>

    </body>
    </html>

    <?php
}
?>