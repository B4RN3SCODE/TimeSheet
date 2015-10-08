  </div>
  <footer class="footer">
    <div class="container">
      <p class="text-muted">Arbor Solutions &copy; 2015</p>
    </div>
  </footer>
</body>
  <script>
    $('[data-view]').on('click',function() {
      navForm.view.value = $(this).attr('data-view');
      navForm.submit();
    });
    $('[data-module]').on('click',function() {
      navForm.module.value = $(this).attr('data-module');
      navForm.submit();
    });
  </script>
</html>