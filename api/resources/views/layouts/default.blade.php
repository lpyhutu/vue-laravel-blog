<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="{{$keywords}}">
    <meta name="description" content="{{$description}}">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/iconfont.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
    <link rel="icon" href="{{asset('favicon.ico')}}">
    <script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.js')}}"></script>
    <style>
        main {
            max-width: 1200px;
            margin: 0px auto;
            display: flex;
            padding-top: 20px;
        }

        .app-left {
            flex: 2.3;
            margin-right: 15px;
        }

        .app-right {
            flex: 1;
        }

        @media (max-width: 767px) {
            main {
                flex-flow: column;
            }

            .app-left {
                order: 2;
                margin-right: 10px;
                margin-left: 10px;
            }

            .app-right {
                order: 1;
                margin-right: 10px;
                margin-left: 10px;

            }

            .app-none {
                display: none;
            }
        }
    </style>
</head>

<body>

<div id="app">
    <x-header></x-header>
    <div style="height: 64px;background-color:#edf2f6;"></div>
    <main>
        <div class="app-left">@yield('main')</div>
        <div class="app-right">
            <x-user></x-user>
            <x-type></x-type>
            <div class="app-none">
                <x-ranking></x-ranking>
                <x-link></x-link>
            </div>
        </div>
    </main>
    <x-footer></x-footer>
    <script>
        $(function () {
            function visitTime() {
                $.get("/visitsTime", function (data, status) {
                    // console.log(data)
                });
            }

            function handleVisitTime() {
                let time = localStorage.getItem("visitTime")
                if (!time) {
                    time = 60;
                    localStorage.setItem("visitTime", time);
                }
                if (time > 0) {
                    setTimeout(() => {
                        localStorage.setItem("visitTime", time - 1);
                        handleVisitTime()
                    }, 1000);
                } else {
                    visitTime()
                    localStorage.setItem("visitTime", 60);
                    handleVisitTime()
                }

            }

            handleVisitTime()
        })
    </script>
    <script>
        (function () {
            var bp = document.createElement('script');
            var curProtocol = window.location.protocol.split(':')[0];
            if (curProtocol === 'https') {
                bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
            } else {
                bp.src = 'http://push.zhanzhang.baidu.com/push.js';
            }
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(bp, s);
        })();
    </script>
</div>

</body>

</html>
