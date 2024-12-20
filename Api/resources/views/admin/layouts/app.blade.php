<!doctype html>
<html lang="en">
@include('admin.includes.head')

<body>
    <div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
        @include('admin.includes.sideBar')
        @include('admin.includes.topNavigation')
        <main id="main-container">
                @yield('mainContent')
        </main>
        @include('admin.includes.footer')
    </div>
    @include('admin.includes.scripts')
</body>

</html>
