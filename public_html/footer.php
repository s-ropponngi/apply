</div> <!-- wrapper -->
<?php
    $year = date('Y');
?>
<p class="copy"><small>&copy;<?php echo $year; ?>code lab.</small></p>
<script src="./js/bbs.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ja.js"></script>
<script>

  flatpickr(document.getElementById('due_date'), {
    locale: 'ja',
    "enableTime": true,
    dateFormat: "Y/m/d H:i",
  });
</script>
</body>
</html>
