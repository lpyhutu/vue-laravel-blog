<footer>
    @foreach($info as $item)
        <div>{{$item->copyright}}
        </div>
        <div>
        <span>运行时间：<span class="time"></span>
        </span><a href="{{url('sitemap.xml')}}" target="_blank">网站地图</a>
        </div>
        <a href="{{$item->record_link}}" class="record" target="_blank"><span>备案号</span><span>{{$item->record}}</span></a>
    @endforeach
</footer>
<script>
    $(function () {
        function runTime(val) {
            let end = parseInt(val);
            let start = (new Date('2020-8-20')).getTime()
            let time = end - start
            let D = time / (1000 * 60 * 60 * 24);
            let h = (D - Math.floor(D)) * 24;
            let m = (h - Math.floor(h)) * 60
            let s = (m - Math.floor(m)) * 60
            let text = ` ${Math.floor(D)} 天 ${checkTime(Math.floor(h))} 小时 ${checkTime(Math.floor(m))} 分 ${checkTime(Math.floor(s))} 秒`;
            $(".time").text(text)
        }

        function checkTime(val) {
            if (val < 10) {
                return `0${val}`
            }
            return val;
        }

        function handleRunTime() {
            setTimeout(() => {
                runTime(Date.now())
                handleRunTime()
            }, 1000)
        }

        handleRunTime()
    })
</script>
<style>
    footer {
        display: flex;
        flex-flow: column;
        align-items: center;
        margin-top: 20px;
        padding: 8px 0;
        background-color: #fff;
        font-size: 12px;
    }

    footer > div {
        padding-bottom: 6px;
    }

    footer > .record span {
        padding: 3px;
        color: #fff;

    }

    footer > .record span:first-child {

        border-radius: 3px 0 0 3px;
        background: #000;
    }

    footer > .record span:last-child {
        border-radius: 0 3px 3px 0;
        background: #007bff;
    }
</style>
