<?php
    session_start();
    require_once '../Processing/connect.php';
    //email
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require '../vendor/autoload.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernamelog = $_POST["usernamelog"];
    $passwordlog = $_POST["passwordlog"];
    $response = array(); 
    
    if (empty(trim($usernamelog))) {
        $response['message'] = 'Vui lòng nhập tên đăng nhập.';
    } else if (empty(trim($passwordlog))) {
        $response['message'] = 'Vui lòng nhập mật khẩu.';
    } else if (strlen($passwordlog) < 6) {
        $response['message'] = 'Mật khẩu phải có ít nhất 6 kí tự.';
    } else {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $usernamelog);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];
            $vertified = $row['vertified'];
            $email = $row['email'];
            if(password_verify($passwordlog, $hashedPassword)) {       
                if($vertified==0){
                    $mail = new PHPMailer(true);
                    try {
                        $mail->SMTPDebug = 0;               
                        $mail->isSMTP();               
                        $mail->Host = 'smtp.gmail.com';                 
                        $mail->SMTPAuth = true;
                        $mail->Username = 'djteam9999@gmail.com';
                        $mail->Password = 'rlhqwnwwszjvuirh';   
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;
                        $mail->setFrom('djteam9999@gmail.com', '');               
                        $mail->addAddress($email);
                        $mail->isHTML(true);                 
                        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
                        $mail->Subject = 'Email verification';
                        $mail->Body    = '<p>Chào Mừng Đến Với DANA PHONE, Mã Xác Thực Của Bạn Là:: <b style="font-size: 30px;">' . $verification_code . '</b></p>';
                        $mail->send();        
                        $sql = "UPDATE users SET verificationcodes = ? WHERE username = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ss", $verification_code, $usernamelog);  
                        if ($stmt->execute()) {
                            $response['message'] = 'xacthuc'; 
                        }
                      } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                }else{     
                    $_SESSION['username'] =$usernamelog;   
                    $permission = $row['permission']; 
                    if ($permission == 0) {
                        $response['message'] = 'user';
                    } else if ($permission == 1) {
                        $response['message'] = 'admin';
                    }   
                }               
            } else {
                $response['message'] = 'Tên Đăng Nhập Hoặc Mật Khẩu Không Đúng.';
            }
        } else {
            $response['message'] = 'Tên Đăng Nhập Hoặc Mật Khẩu Không Đúng.';
        }
    }       
    echo json_encode($response);
}

    $conn->close();
?>