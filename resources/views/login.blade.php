<!DOCTYPE html>
<html>

<head>
    <title>{{$title}}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <style>
        .loginBgTech{
            /**background-image: url('img/bg-login.jpg); */
            background-color: grey;
            background-repeat: no-repeat;
            background-size: cover;
            background-blend-mode: luminosity;
        }
        .headerLogin{
            font-family: 'Oswald',sans-serif !important;
            text-align: center;
            color: indianred;
            font-size: 40px;
        }
        .tengah {
            position: absolute;
            top: 50%;
            left:50%;
            transform: translate(-50%, -50%);
            /* border: 3px solid green; */
            width: 30%;
        }
    </style>
</head>

<body class="loginBgTech">
    <div class="row">
        <div class="col-md-4 tengah">
            <div class="card shadow">
                <div class="card-header">
                    <h2 class="headerLogin">Login {!! $appTitle !!}</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="label mb-2">Username</label>
                        <input type="text" class="form-control" id="userName" name="username"></input>
                </div>
                <div class="form-group">
                    <label class="label mb-2 mt-2">Password</label>
                    <input type="password" class="form-control" id="passWord" name="password"></input>
                </div>
                <!-- Spacer -->
                <div class="m-2"></div>
                <div class="form-group">
                    <btn class="btn btn-success btnLogin">login</btn>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>
<footer>
    <script type="module">
        $('.btnLogin').on('click',function(a){
            //a.preventDefault();
            //alert('clicked);
            axios.post('login/check',{
                username : $('#userName').val(),
                password : $('#passWord').val(),
                _token : '{{csrf_token()}}'
            }).then(function(response){

                if(response.data.success){
                    window.location.href = response.data.redirect_url;
                }else{
                    Swal.fire('Gagal Login,Username/Password salah','','error');
                }

                }).catch(function(error){
                     
                    if(error.response.status === 422){

                        Swal.fire(error.response.data.message,'','error');
                    }else{
                        Swal.fire('Gagal Login,Username/Password salah','','error');
                    }
                });
            });
        </script>
</footer>
</html>