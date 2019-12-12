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
                <h2 class="panel-title">Edit User</h2>
            </header>
            <div class="panel-body">
                <form class="form-horizontal form-bordered" action="<?= base_url('user/editUser')?>" method="POST">

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">User Id</label>

                        <div class="col-sm-8">
                            <input type="text" id="userId" name="userId" class="form-control mb-md" required value="<?= $user->userId?>" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Name</label>

                        <div class="col-sm-8">
                            <input type="text" id="name" name="name" class="form-control mb-md" required value="<?= $user->userName?>" maxlength="30">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Email</label>

                        <div class="col-sm-8">
                            <input type="text" id="email" name="email"  class="form-control mb-md" required value="<?= $user->userEmail?>" maxlength="30">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Username</label>

                        <div class="col-sm-8">
                            <input type="text" id="username" name="username" class="form-control mb-md" required value="<?= $user->userUsername?>" maxlength="30">
                            <input type="text" id="usernameOld" name="usernameOld" required value="<?= $user->userUsername?>" hidden>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">New Password (optional)</label>

                        <div class="col-sm-8">
                            <input type="text" id="password" name="password" class="form-control mb-md">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Phone</label>

                        <div class="col-sm-8">
                            <input type="text" id="phone" name="phone"  class="form-control mb-md" required value="<?= $user->userPhone?>" maxlength="30">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="position">Position</label>

                        <div class="col-sm-8">
                            <select id="position" name="position"  class="form-control mb-md" required>
                                <option value="">Select Position</option>
                                <option <?php if($user->userPosition == "admin"){echo "selected";}?> value="admin">Admin</option>
                                <option <?php if($user->userPosition == "user"){echo "selected";}?> value="user">User</option>
                            </select>
                        </div>
                    </div>
                    
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-offset-9">
                                <a href="<?= base_url("user/all_user")?>" class="btn btn-warning">Back</a>
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