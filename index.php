<?php
session_start();
session_abort();
include "db/db.php";
if (!isset($_SESSION['username']))
{
    header("Location: login.php");
}

if ($_SESSION['role'] == 'Data Uploader')
{
    header("Location: dataUploader.php");
}
include 'inc/head.php';
include "inc/sidebar.php";
?>
<!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">WELCOME TO AMR PORTAL</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card tale-bg">
                        <div class="card-people mt-auto" style="padding-top:0px !important;">
                            <img src="images/dashboard/main.jpg" alt="people">

                        </div>
                    </div>
                </div>
                <div class="col-md-6 grid-margin transparent">
                    <div class="row">
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card card-tale">
                                <div class="card-body">
                                    <p class="mb-4">Total Consultant Documents</p>
                                    <p class="fs-30 mb-2">
                                        <?php
                                        $count  = 0;
                                        $sql = mysqli_query($db,"SELECT * FROM `data_uploader` WHERE file_type = 'Document'");
                                        while ($row = mysqli_fetch_array($sql))
                                        {
                                            $list = @$row['cat_id'];
                                            $tag_array = explode(',', $list );
                                            foreach ($tag_array as $x)
                                            {
                                                if ($x == '1')
                                                {
                                                    $count++;
                                                }
                                            }

                                        }
                                        echo $count;
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card card-dark-blue">
                                <div class="card-body">
                                    <p class="mb-4">Total Contract Documents</p>
                                    <p class="fs-30 mb-2">
                                        <?php
                                        $count  = 0;
                                        $sql = mysqli_query($db,"SELECT * FROM `data_uploader` WHERE file_type = 'Document'");
                                        while ($row = mysqli_fetch_array($sql))
                                        {
                                            $list = @$row['cat_id'];
                                            $tag_array = explode(',', $list );
                                            foreach ($tag_array as $x)
                                            {
                                                if ($x == '2')
                                                {
                                                    $count++;
                                                }
                                            }

                                        }
                                        echo $count;
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                            <div class="card card-light-blue">
                                <div class="card-body">
                                    <p class="mb-4">Total Sites Snaps</p>
                                    <p class="fs-30 mb-2">
                                        <?php
                                        echo mysqli_num_rows(mysqli_query($db,"SELECT * FROM `data_uploader` WHERE file_type = 'Image'"));
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 stretch-card transparent">
                            <div class="card card-light-danger">
                                <div class="card-body">
                                    <p class="mb-4">Total Members</p>
                                    <p class="fs-30 mb-2">
                                        <?php
                                        echo mysqli_num_rows(mysqli_query($db,"SELECT * FROM `users`"));
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">EXPLORE YOUR DOCUMENT BY CATEGORY</h3>
                            <div class="row">
                                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                                    <div class="card-body">
                                        <a  href="categories.php?cat=1" type="button" class="btn btn-primary btn-lg btn-block" style="font-size:24px;">Consultant</a>
                                    </div>
                                </div>
                                <div class="col-md-6 stretch-card transparent">
                                    <div class="card-body">
                                        <a href="categories.php?cat=2" type="button" class="btn btn-danger btn-lg btn-block" style="font-size:24px;" >Contracts</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="display expandable-table" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>File Code</th>
                                                <th>File Type</th>
                                                <th>File Name</th>
                                                <th>Category</th>
                                                <th>Username</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>View</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            $i = 0;
                                            $sqlUsers = mysqli_query($db, "SELECT * FROM data_uploader ORDER BY id DESC LIMIT 0,10");
                                            while ($rowUser = mysqli_fetch_array($sqlUsers))
                                            {
                                                $parent_id = "";
                                                $list = $rowUser['cat_id'];
                                                $previous_cat = "";
                                                $sub_sub_cat = "";
                                                $tag_array = explode(',', $list );
                                                foreach ($tag_array as $x)
                                                {
                                                    $parent_id = $x;
                                                    break;
                                                }
                                                $i++;
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $i; ?>.
                                                    </td>
                                                    <td>
                                                        <?php echo $rowUser['id']; ?>.
                                                    </td>
                                                    <td><?php echo $rowUser['file_type'] ; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($rowUser['name'] == null) {
                                                            echo $rowUser['file_name'];
                                                        }
                                                        else {
                                                            echo $rowUser['name'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($parent_id != null) {
                                                            $main = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM categories WHERE id = '$parent_id'"));
                                                            echo $main['name'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $rowUser['username'] ; ?></td>
                                                    <td><?php echo $rowUser['date'] ; ?></td>
                                                    <td><?php echo $rowUser['status'] ; ?></td>
                                                    <td>
                                                        <a class="btn btn-danger" href="fileView.php?id=<?php echo $rowUser['id']; ?>">
                                                            <i class="mdi mdi-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<?php
include "inc/footer.php";
?>