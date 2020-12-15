<div class="container-fluid bg-" style="min-height:calc(100vh - 170px)">
    <?php
    $response = '';
    if (isset($_POST['add_user'])) {
        $domain = $_POST['domain'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sidebar = '[{"subMenu": 0,"title": "Dashboard","link": "dashboard","icon": "fa-home"},{"subMenu": 0,"title": "Purchase","icon": "fa-list-alt","link": "purchase/list"},{"subMenu": 0,"title": "Product Stock","icon": "fa-list-alt","link": "product/list"},{"subMenu": 0,"title": "Vendors","icon": "fa-cube","link": "vendor/list"},{"subMenu": 0,"title": "Checkout","icon": "fa-shopping-cart","link": "checkout/list"},{"subMenu": 0,"title": "Customer / Client","icon": "fa-users","link": "customer/list"},{"subMenu": 0,"title": "Due Amount","icon": "fa-book","link": "due/list"},{"subMenu": 0,"title": "Settings","icon": "fa-cog","link": "setting"} ]';
        // print_r($_POST);

        $result = $conn->query("INSERT INTO `system_users` (`domain`, `username`, `password`, `type`, `sidebar`, `invoice_desc`, `logo_ext`, `header_ext`) 
        VALUES ('$domain', '$username', '$password', 'admin', '$sidebar', '', '', '')");

        if ($result === TRUE) {
            $response = alert('success', 'New User Added Successfully');
        } else {
            $response = alert('danger', 'Failed !!! Error');
        }
    }
    if (isset($_POST['edit_user'])) {
        // print_r($_POST);
        $domain = $_POST['domain'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $result = $conn->query("UPDATE `system_users` SET `username` ='$username', `password` = '$password' WHERE `domain` = '$domain'");

        if ($result === TRUE) {
            $response = alert('success', 'User Edited Successfully');
        } else {
            $response = alert('danger', 'Failed !!! Error');
        }
    }
    ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-light"><i class="fa fa-list"></i> List of User</div>
                <div class="card-body">
                    <div class="card shadow">
                        <div class="card-body">

                            <table class="table data-table table-bordered">
                                <thead>
                                    <th>Sr</th>
                                    <th>Domain</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>

                                    <?php
                                    $i = 0;
                                    $result = $conn->query("SELECT * FROM system_users");
                                    while ($row = $result->fetch_assoc()) {
                                        // print_r($row);
                                        $i++;
                                        echo '<tr>' .
                                            '<td>' . $i . '</td>' .
                                            '<td>' . $row['domain'] . '</td>' .
                                            '<td>' . $row['username'] . '</td>' .
                                            '<td>' . $row['password'] . '</td>' .
                                            '<td>' .
                                            '   <a href="?edit=' . $row['domain'] . '" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>' .
                                            '   <a href="?" class="btn btn-danger btn-sm disabled"><i class="fa fa-times"></i> Delete</a>' .
                                            '</td>' .
                                            '</tr>';
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <?php echo $response ?>
            <?php if (!isset($_GET['edit'])) { ?>
                <div class="card shadow">
                    <div class="card-header bg-dark text-light"><i class="fa fa-user-plus"></i> Add New User</div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="">Domain</label>
                                <input type="text" name="domain" class="form-control" required>
                                <small id="helpId" class="text-muted">*Mandatory</small>
                            </div>
                            <div class="form-group">
                                <label for="">Username</label>
                                <input type="text" name="username" class="form-control" required>
                                <small id="helpId" class="text-muted">*Mandatory</small>
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="text" name="password" class="form-control" required>
                                <small id="helpId" class="text-muted">*Mandatory</small>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" name="add_user" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
            <?php if (isset($_GET['edit'])) {
                $domain = $_GET['edit'];
                $user = $conn->query("SELECT * FROM `system_users` WHERE domain ='$domain'")->fetch_assoc(); ?>
                <div class="card shadow">
                    <div class="card-header bg-dark text-light d-flex align-items-center justify-content-between">
                        <span><i class="fa fa-edit"></i> Edit User </span>
                        <a class="btn btn-danger btn-sm" href="?"><i class="fa fa-times"></i></a>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="">Domain</label>
                                <input type="text" value="<?php echo $user['domain'] ?>" name="domain" class="form-control" readonly required>
                                <small id="helpId" class="text-muted">*Mandatory</small>
                            </div>
                            <div class="form-group">
                                <label for="">Username</label>
                                <input type="text" value="<?php echo $user['username'] ?>" name="username" class="form-control" required>
                                <small id="helpId" class="text-muted">*Mandatory</small>
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="text" value="<?php echo $user['password'] ?>" name="password" class="form-control" required>
                                <small id="helpId" class="text-muted">*Mandatory</small>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" name="edit_user" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</div>