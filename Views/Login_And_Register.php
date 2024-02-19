<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="../Public/img/icon.png">
    <title>Login And Register</title>
    <link rel="stylesheet" href="../Public/css/logincss.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body>
    <h2>CHÀO MỪNG ĐẾN VỚI DANA PHONE</h2>
    <!-- Đăng Kí -->
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form id="signupForm">
                <h1>Tạo Tài Khoản</h1>
                <div id="result" style="color:red; font-size:small"></div>
                <input name="username" id="username" type="text" placeholder="Tên Đăng Nhập" />
                <div id="usernamecheck" style="color:red; font-size:small" class=""> </div>
                <input name="email" id="email" type="email" placeholder="Email" />
                <div id="emailcheck" style="color:red; font-size:small"> </div>
                <input name="password" id="password" type="password" placeholder="Mật Khẩu" />
                <div id="passwordcheck" style="color:red; font-size:small"> </div>
                <input name="rpassword" id="rpassword" type="password" placeholder="Nhập lại Mật Khẩu" />
                <div id="rpasswordcheck" style="color:red; font-size:small"> </div>
                <button type="submit" id="signupButton" name="signup">Sign Up</button>
            </form>
        </div>

        <!-- Đăng Nhập -->
        <div class="form-container sign-in-container">
            <form id="signinForm">
                <h1>Đăng Nhập</h1>
                <div class="social-container">
                </div>
                <div id="logcheck" style="color:red; font-size:small"> </div>
                <input name="usernamelog" id="usernamelog" type="text" placeholder="Tên Đăng Nhập" />
                <input name="passwordlog" id="passwordlog" type="password" placeholder="Mật Khẩu" />
                <a href="../Views/Forgot_Password.php">Bạn quên mật khẩu?</a>
                <button type="submit" id="signinButton" name="signin">Đăng Nhập</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Chào mừng trở lại !</h1>
                    <p>Để duy trì kết nối với chúng tôi vui lòng đăng nhập bằng thông tin cá nhân của bạn</p>
                    <button class="ghost" id="signIn">Đăng Nhập Tại Đây</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, customer!</h1>
                    <p>Nhập thông tin cá nhân của bạn và bắt đầu hành trình với chúng tôi</p>
                    <button class="ghost" id="signUp">Đăng Ký Tại Đây</button>
                </div>
            </div>
        </div>


    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');
    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
    $(document).ready(function () {
        $("#username").blur(function () {
            var username = $(this).val();
            $.get("../processing/Register.php", { username: username }, function (data) {
                $("#usernamecheck").html(data);
            });
        });

        $("#email").blur(function () {
            var email = $(this).val();
            $.get("../processing/Register.php", { email: email }, function (data) {
                $("#emailcheck").html(data);
            });
        });
        $("#signupForm").submit(function (event) {
            event.preventDefault();

            var formData = $(this).serializeArray();

            var data = {};

            $(formData).each(function (index, obj) {
                data[obj.name] = obj.value;
            });

            console.log(data);
            $.ajax({
                type: 'POST',
                url: '../Processing/Register.php',
                data,
                dataType: 'json',
                success: function (response) {
                    // if (response.success) {
                    //     window.location.href = '../Views/vertifi.php?username=' + response.username;
                    // } else {
                    //     $('#result').text(response.message);
                    // }
                },
                error: function () {
                    $('#result').text('An error occurred during the AJAX request.');
                }
            });
        });
        $("#signinForm").submit(function (event) {
            event.preventDefault();
            var usernamelog = $('#usernamelog').val();
            var passwordlog = $('#passwordlog').val();
            $.ajax({
                type: 'POST',
                url: '../Processing/Login.php',
                data: { usernamelog: usernamelog, passwordlog: passwordlog },
                dataType: 'json',
                success: function (response) {
                    if (response.message == 'xacthuc') {
                        window.location.href = '../Views/vertifi.php?username=' + usernamelog;
                    } else if (response.message === 'user') {
                        window.location.href = '../views/index.php';
                    } else if (response.message === 'admin') {
                        window.location.href = '../views/Sales_chart.php';
                    } else
                        $('#logcheck').text(response.message);
                },
                error: function (response) {
                    console.log(response)
                    $('#logcheck').text('An error occurred during the AJAX request.');
                }
            });
        });
    });
</script>
</html>