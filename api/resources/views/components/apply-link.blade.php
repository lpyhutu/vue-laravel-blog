<form class="apply-link" action="applyLink" novalidate method="post" onsubmit="return handleApplyLink(this)"
      enctype="multipart/form-data">
    {{csrf_field()}}
    <div class="form-row">
        <div class="col-md-6 mb-6">
            <label>站点名称
            </label>
            <input type="text" name="title" class="form-control form-control-sm" required placeholder="请输入站点名称">
            <div class="invalid-feedback">
                请输入站点名称.
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6 mb-6">
            <label>站点地址
            </label>
            <input type="text" name="site" class="site form-control form-control-sm" required placeholder="请输入站点地址">
            <div class="invalid-feedback">
                请输入站点地址.
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6 mb-6">
            <label>联系邮箱
            </label>
            <input type="text" name="email" class="email form-control form-control-sm" required placeholder="请输入联系邮箱">
            <div class="invalid-feedback">
                请输入联系邮箱.
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6 mb-6">
            <div class="form-group">
                <label for="exampleFormControlFile1">网站头像(1M以内)</label>
                <input name="file" type="file" class="form-control-file" id="file" accept="image/*">
            </div>
        </div>
    </div>
    <div style="display: flex;justify-content: flex-end">
        <button class="btn btn-primary btn-sm" type="submit">
            <icon class="iconfont icon-edit-square"></icon>
            <span style="padding-left: 5px;">申请</span>
        </button>
    </div>
</form>
<x-toasts msg="请上传网站头像." current="t-logo"></x-toasts>
<x-toasts msg="请上传1M以内的图片." current="t-logo-size"></x-toasts>
<x-toasts msg="请上传jpeg/png/jpg类型图片." current="t-logo-type"></x-toasts>
<x-toasts msg="邮箱格式错误." current="t-email"></x-toasts>
<x-toasts msg="站点地址格式错误." current="t-site"></x-toasts>
<script>
    function handleApplyLink() {
        const site = $('.site').val();
        const email = $('.email').val();
        const file = $('#file').val();
        if (site === "" || email === "" || file === "") {
            return false
        }
        return true;
    }

    $(function () {
        $("#file").change(function (e) {
            const {type, size} = e.target.files[0];
            const isType = type === "image/jpeg" ||
                type === "image/png" ||
                type === "image/jpg";
            if (!isType) {
                $(".t-logo-type").toast('show')
                return $(this).val("")
            }
            const isSize = size / 1024 / 1024 < 1;
            if (!isSize) {
                $(".t-logo-size").toast('show')
                return $(this).val("")
            }
        })
        $('.site').blur(function () {
            const site = $(this).val();
            const reg = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w.-]+)+[\w\-._~:/?#[\]@!$&'*+,;=.]+$/;
            if (!reg.test(site)) {
                $(this).val("");
                $(".t-site").toast('show')
                return false;
            }
        })
        $('.email').blur(function () {
            const email = $(this).val();
            const reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
            if (!reg.test(email)) {
                $(this).val("");
                $(".t-email").toast('show')
                return false;
            }
        })


        function handleComment() {
            window.addEventListener('load', function () {
                var forms = document.getElementsByClassName('apply-link');
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        const file = $("#file").val();
                        if (file === "") {
                            event.preventDefault();
                            event.stopPropagation();
                            $(".t-logo").toast('show')
                        }
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        }

        handleComment()
    })
</script>
<style>
    .apply-link {
        padding: 0 10px 10px;
    }

    .apply-link .form-row {
        padding: 10px 0;
    }

    .apply-link .btn {
        margin-top: 20px;
    }
</style>
