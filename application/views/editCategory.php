<style>
    #dataTable td{
        vertical-align: top;
        padding: 5px;
    }
</style>
<!-- start: page -->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                                        
                <h2 class="panel-title">Edit Category</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('category/editCategory')?>" method="POST">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Category Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="category" name="prevcategory" required value="<?= $category->categoryName?>" hidden>
                            <input type="text" id="category" name="category"  class="form-control mb-md" required value="<?= $category->categoryName?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="sample">Detail</label>

                        <div class="col-sm-8">
                            <textarea name="detail" rows="4" class="form-control mb-md" required><?= $category->categoryDetail?></textarea>
                        </div>
                    </div>
                    
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-offset-10">
                                <input type="submit" value="Submit" class="btn btn-primary">
                                <input type="reset" value="Reset" class="btn btn-default">
                            </div>
                        </div>
                    </footer>
                </form>
            </div>
        </section>										
    </div>
</div>
<!-- end: page -->