
<script type="text/javascript" src="<?= base_url();?>assets/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/js/popper.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/js/app.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/js/main.js"></script>
<script type="text/javascript" src="<?= base_url();?>assets/js/plugins/pace.min.js"></script>

<?php if (isset($role_ut)) :?>
    <script type="text/javascript" src="<?= base_url();?>assets/js/plugins/select2.min.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/js/plugins/dataTables.bootstrap.min.js"></script>
    <script>
        $(function () {
            $('table').DataTable();
        });
    </script>
<?php endif; ?>

<script type="text/javascript">
    if(document.location.hostname == 'pratikborsadiya.in') {
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-72504830-1', 'auto');
        ga('send', 'pageview');
    }
    $('#demoDate').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        todayHighlight: true
    });

    $('#demoSelect').select2();
</script>
</body>
</html>