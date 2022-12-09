<!-- Footer Start -->
<footer class="footer">
    <div class="container-fluid">
        Copyright &copy; <script>
            document.write(new Date().getFullYear())
        </script> bikroy by <a href="">therssoftware</a>
    </div>
</footer>
<!-- end Footer -->

</div>
<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->

</div>
<!-- END wrapper -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
 
<!--Morris Chart-->

@yield('script')
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>

</body> 
</html>