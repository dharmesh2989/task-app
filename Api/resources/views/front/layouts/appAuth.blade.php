<!doctype html>
<html lang="en">
@include('front.includes.headAuth')
<div id="page-container">
    <main id="main-container">
        <div class="hero-static d-flex align-items-center">
            <div class="content">
                @yield('authContent')
            </div>
        </div>
    </main>
</div>
@include('front.includes.scriptsAuth')
</body>

</html>
