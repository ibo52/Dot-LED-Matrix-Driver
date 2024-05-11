<!-- Main content -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<script type="text/javascript" src="js/search.js"></script>

<!-- search field -->
<section class="content">
    <div class="container-fluid">
        <h2 class="text-center display-4">Components Search</h2>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="search-page.php">
                    <div class="input-group">
                        <input type="search" name="search-field" class="form-control form-control-lg" placeholder="Search any component or category"
                        onkeyup="showResult(this.value)">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!--data table field-->
<section class="content">
      <!-- urun tablosu-->
      <?php include_once("urunTable.php");?>
      <!-- /.container-fluid -->
    </section>
</div>
</div>