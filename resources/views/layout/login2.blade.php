<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <link rel="shortcut icon" type="image/x-icon" href="./assets/img/favicon.png" />
    <title>Sistem Monitoring Karyawan</title>
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="./assets/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="animate.css@3.5.1.css" />
    <!--[if lt IE 9]>
    <script src="./assets/js/html5shiv.min.js"></script>
    <script src="./assets/js/respond.min.js"></script>
  <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    <div class="main-wrapper">
        <div class="account-page">
            <div class="container">
                <br>
                <br>
                <br>
                <div class="account-box animated " style="display: none;" id="just">
                    <div class="account-wrapper">
                        <div class="account-logo">
                            <center>
                                <h1><i class="fa fa-bar-chart-o"></i>Sistem Monitoring Karyawan</h1>
                            </center>
                        </div>
                        <form method="post" />
                        {{ csrf_field() }}
                        <div class="form-group form-focus">
                            <label class="control-label">Username </label>
                            <input class="form-control floating" type="text" name="user" placeholder="Username" required="" />
                        </div>
                        <div class="form-group form-focus">
                            <label class="control-label">Password</label>
                            <input class="form-control floating" type="password" name="pass" placeholder="Password" required="" />
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary btn-block account-btn" type="submit">Login</button>
                            <button onClick="aniout('#just','rotateOutDownRight',function(){aniin('#all','rotateInDownRight')})" class="btn btn-warning btn-block account-btn" type="button">Lupa Password?</button>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="account-box animated rotateInDownRight" id="all">
                    <div class="account-wrapper">
                        <div class="account-logo">
                            <center>
                                <h1>Reset Password</h1>
                            </center>
                        </div>
                        <form method="post" action="reset2" />
                        {{ csrf_field() }}
                        @foreach ($tb as $e)
                        {{-- expr --}}
                        <div class="form-group form-focus">
                            <label class="control-label">Username </label>
                            <input class="form-control floating" type="text" readonly="" value="{{$e->user}}" name="user" placeholder="Username" required="" />
                        </div>
                        <div class="form-group form-focus">
                            <label class="control-label">Password Baru </label>
                            <input class="form-control floating" type="password" name="pass" placeholder="Password Baru" required="" />
                        </div>
                        <div class="form-group form-focus">
                            <label class="control-label">Pertanyaan Keamanan </label>
                            <input class="form-control floating" type="text" autocomplete="off" value="{{$e->tanya}}" name="tanya" readonly="" required="" />
                        </div>
                        <div class="form-group form-focus">
                            <label class="control-label">Jawaban </label>
                            <input class="form-control floating" type="text" autocomplete="off" name="jawab" required="" />
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary btn-block account-btn" type="submit">Reset</button>
                            <button onClick="aniout('#all','rotateOutDownRight',function(){aniin('#just','rotateInDownRight')})" class="btn btn-warning btn-block account-btn" type="button">Login</button>
                        </div>
                        @endforeach
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="./assets/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./assets/js/app.js"></script>
    <script type="text/javascript">
    function aniin(element, animationName, callback) {
        $(element).show();

        const node = document.querySelector(element)
        node.classList.add(animationName)

        function handleAnimationEnd() {
            node.classList.remove(animationName)

            node.removeEventListener('animationend', handleAnimationEnd)

            if (typeof callback === 'function') callback()
        }

        node.addEventListener('animationend', handleAnimationEnd)
    }

    function aniout(element, animationName, callback) {
        const node = document.querySelector(element)
        node.classList.add(animationName)

        function handleAnimationEnd() {
            $(element).hide();
            node.classList.remove(animationName)
            node.removeEventListener('animationend', handleAnimationEnd)

            if (typeof callback === 'function') callback()
        }

        node.addEventListener('animationend', handleAnimationEnd)
    }
    </script>
</body>

</html>
