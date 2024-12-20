<!doctype html>
<html lang="en">
@include('front.includes.head')

<body>
    <div id="page-container" class="page-header-dark main-content-boxed dark-mode">
        @include('front.includes.sideBar')
        <main id="main-container">
            @yield('mainContent')
        </main>
        @include('front.includes.footer')
    </div>
    @include('front.includes.scripts')
</body>

</html>
