<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">
            <img src="{{asset('img/logo.png')}}" width="30" height="30" class="d-inline-block align-top" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto" style="font-size: 15px;">
                @foreach($menus as $menu)
                    <li class="nav-item {{Request()->path()===$menu['path']?'active':''}}">
                        <a class="nav-link" href="{{asset($menu['path'])}}">
                            <icon class="iconfont {{$menu['icon']}}"></icon> {{$menu["title"]}}
                        </a>
                    </li>
                @endforeach
            </ul>
            <form class="form-inline my-2 my-lg-0" action="{{route('search')}}" method="get">
                <input class="form-control mr-sm-2" name="title" type="search" placeholder="Search" aria-label="Search">
                <button class="btn-search btn btn-outline-primary  my-2 my-sm-0">Search</button>
            </form>
        </div>
    </nav>
</header>
<div class="back-top ">
    <div class="back-top-content">
        <div class="back-top-icon"></div>
    </div>
</div>
<script>
    $(function () {

        var oldScroll = 0;

        function handleScroll() {
            window.addEventListener("scroll", function () {
                let scrollTop =
                    window.pageYOffset ||
                    document.documentElement.scrollTop ||
                    document.body.scrollTop;
                if (scrollTop > 1200) {
                    $(".back-top").addClass("back-top-show");
                }else{
                    $(".back-top").removeClass("back-top-show");
                }
                let newScroll = scrollTop - oldScroll;
                oldScroll = scrollTop;
                let flag = $("header").attr("class") === "";
                $("header").addClass("up-transition");
                if (newScroll < 0) {
                    if (!flag) {
                        $("header").removeClass("up-scroll");
                    }
                } else {
                    $("header").addClass("up-scroll");

                }
            })
        }

        $(".back-top").click(function () {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            })
        })
        handleScroll()
    })
</script>
<style>
    .back-top {
        display: none;
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        color: rgba(0, 0, 0, .65);
        font-size: 14px;
        font-variant: tabular-nums;
        line-height: 1.5;
        list-style: none;
        font-feature-settings: "tnum";
        position: fixed;
        right: 50px;
        bottom: 50px;
        z-index: 10;
        width: 40px;
        height: 40px;
        cursor: pointer;
    }
    .back-top-show {
        display: block;
    }

    .back-top-content {
        width: 40px;
        height: 40px;
        overflow: hidden;
        color: #fff;
        text-align: center;
        background-color: rgba(0, 0, 0, .45);
        border-radius: 20px;
        transition: all .3s cubic-bezier(.645, .045, .355, 1);
    }

    .back-top-icon {
        width: 14px;
        height: 16px;
        margin: 12px auto;
        background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAoCAYAAACWwljjAAAABGdBTUEAALGPC/xhBQAAAbtJREFUWAntmMtKw0AUhhMvS5cuxILgQlRUpIggIoKIIoigG1eC+AA+jo+i6FIXBfeuXIgoeKVeitVWJX5HWhhDksnUpp3FDPyZk3Nm5nycmZKkXhAEOXSA3lG7muTeRzmfy6HneUvIhnYkQK+Q9NhAA0Opg0vBEhjBKHiyb8iGMyQMOYuK41BcBSypAL+MYXSKjtFAW7EAGEO3qN4uMQbbAkXiSfRQJ1H6a+yhlkKRcAoVFYiweYNjtCVQJJpBz2GCiPt7fBOZQpFgDpUikse5HgnkM4Fi4QX0Fpc5wf9EbLqpUCy4jMoJSXWhFwbMNgWKhVbRhy5jirhs9fy/oFhgHVVTJEs7RLZ8sSEoJm6iz7SZDMbJ+/OKERQTttCXQRLToRUmrKWCYuA2+jbN0MB4OQobYShfdTCgn/sL1K36M7TLrN3n+758aPy2rrpR6+/od5E8tf/A1uLS9aId5T7J3CNYihkQ4D9PiMdMC7mp4rjB9kjFjZp8BlnVHJBuO1yFXIV0FdDF3RlyFdJVQBdv5AxVdIsq8apiZ2PyYO1EVykesGfZEESsCkweyR8MUW+V8uJ1gkYipmpdP1pm2aJVPEGzAAAAAElFTkSuQmCC) 100%/100% no-repeat;
    }

    header {
        position: fixed;
        top: 0px;
        width: 100%;
        height: 64px;
        background: #fff;
        box-shadow: 0 0 10px #dadada;
        z-index: 100;
    }

    .up-transition {
        -webkit-transition: all 0.3s;
        -o-transition: all 0.3s;
        -moz-transition: all 0.3s;
        transition: all 0.3s;
    }

    .up-scroll {
        top: -64px;

    }


    header > .navbar {
        max-width: 1200px;
        margin: 0px auto;
        background: #fff;
        padding: 12px 16px;
    }

    header > .navbar ul li {
        margin-right: 10px;
    }
</style>
