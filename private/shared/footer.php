





</div> <!--end container-->
<footer class="container-fluid mt-5 pt-3 text-light">
  <div>
  <div class="d-flex">

    <p>Copyright <?php echo date('Y') . ', Ben Wille'; ?></p>

    <div class="ml-auto">
      <?php
      $end = microtime(true) - $start;
      // echo '(' . number_format($end, 2) . ' seconds)';
      echo duration($end);
      ?>
    </div>
  </div>
</div>
</footer>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<!-- <script src="<?php echo url_for('/js/jquery.slim.min.js'); ?>"></script>
<script src="<?php echo url_for('/js/popper.min.js'); ?>"></script>
<script src="<?php echo url_for('/js/bootstrap.min.js'); ?>"></script> -->
  </body>

</html>


<?php db_disconnect($database); ?>
