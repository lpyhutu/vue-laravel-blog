<div class="ht-card">
    <div class="title ht-font-size-16px">{{ $title }}</div>
    <div class="content">
        {{ $slot }}
    </div>
</div>
<style>
    .ht-card {
        padding: 20px;
        background: #fff;

    }

    .ht-card>.title {
        padding-bottom: 10px;
        border-bottom: 1.5px solid #1890ff;
    }

    .ht-card>.content {
        padding-top: 10px;
    }
</style>