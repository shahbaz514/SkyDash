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
if (isset($_GET['cat']))
{
    $sqlGetCatData = mysqli_fetch_array(mysqli_query($db,"SELECT * FROM `categories` WHERE id = '".$_GET['cat']."'"));
}
include 'inc/head.php';
include "inc/sidebar.php";
?>
    <div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title" style="text-align:center;">EXPLORE YOUR DOCUMENT BY CATEGORY</h3><br>
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
                            <?php
                            if (isset($_GET['cat'])){
                                $sqlGetSubCat = mysqli_query($db,"SELECT * FROM `categories` WHERE parent_id = '".$_GET['cat']."'");
                                while ($rowGetSubCat = mysqli_fetch_array($sqlGetSubCat)) {
                                    ?>
                                    <div class="col-md-3 mb-4 mb-lg-0" style="margin-top: 20px;">
                                        <a href="categories.php?cat=<?php echo $rowGetSubCat['id']; ?>" type="button" class="btn btn-warning btn-lg btn-block" style="font-size:16px;">
                                            <?php
                                            echo $rowGetSubCat['name'];
                                            ?>
                                        </a>
                                    </div>
                                    <?php
                                }
                            }
                            ?>


                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Advanced Table</p>
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
                                        $sqlGetData = mysqli_query($db, "SELECT * FROM data_uploader");
                                        while ($rowGetData = mysqli_fetch_array($sqlGetData))
                                        {

                                            $parent_id = "";
                                            $catGetId = @$_GET['cat'];
                                            $list = @$rowGetData['cat_id'];
                                            $previous_cat = "";
                                            $sub_sub_cat = "";
                                            $tag_array = explode(',', $list );
                                            foreach ($tag_array as $x)
                                            {
                                                if ($x == $catGetId)
                                                {
                                                    $parent_id = $x;
                                                }
                                                elseif ($x > $catGetId)
                                                {
                                                    $sub_sub_cat = $x;
                                                    break;
                                                }
                                                elseif ($x < $catGetId)
                                                {
                                                    $previous_cat = $x;
                                                }
                                            }
                                            if ($parent_id == @$_GET['cat']) {
                                                $i++;
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $i; ?>.
                                                    </td>
                                                    <td>
                                                        <?php echo $rowGetData['id']; ?>.
                                                    </td>
                                                    <td><?php echo $rowGetData['file_type'] ; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($rowGetData['name'] == null) {
                                                            echo $rowGetData['file_name'];
                                                        }
                                                        else {
                                                            echo $rowGetData['name'];
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
                                                    <td><?php echo $rowGetData['username'] ; ?></td>
                                                    <td><?php echo $rowGetData['date'] ; ?></td>
                                                    <td><?php echo $rowGetData['status'] ; ?></td>
                                                    <td>
                                                        <a class="btn btn-danger" href="fileView.php?id=<?php echo $rowGetData['id']; ?>">
                                                            <i class="mdi mdi-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
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
    <!-- content-wrapper ends -->
<?php
include "inc/footer.php";
?>