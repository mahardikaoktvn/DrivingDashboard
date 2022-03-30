{{-- // TODO: pecah jadi beberapa bagian navbar, header, body, footer dst dst --}}
<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.header')
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            @include('partials.left-sidebar')
            @include('partials.top-navbar')
            <div class="right_col" role="main">
                <div class="row" style="display: inline-block;">
                    @include('contents.player-in-the-house')
                </div>
                @include('contents.omzet-ytd')
                @include('contents.omzet-mtd')
                @include('contents.omzet-today')
                @include('contents.omzet-ytd-zt')
                @include('contents.omzet-mtd-zt')
                @include('contents.omzet-today-zt')
                <div>
                <h3>10 MEMBER TERAKTIF</h3>
                @include('contents.member-aktif')
                @include('contents.member-aktif-1')
                @include('contents.member-aktif-tdy')
                </div>
                @include('contents.omzet-bulanan')
                @include('contents.omzet-bulanan-zt1')
            </div>
            <footer>
                <div class="pull-right">
                    Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
                </div>
                <div class="clearfix"></div>
            </footer>
        </div>
    </div>
    @include('partials.footer')
</body>

</html>
