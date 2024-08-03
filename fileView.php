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

if (!isset($_GET['id']))
{
    header("Location: allFiles.php");
}
else
{
    $sqlGetData = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM data_uploader WHERE id = ".$_GET['id'].""));
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
                        <h3 class="card-title" style="text-align:center;">
                            <?php echo $sqlGetData['name']; ?> | Approval Page
                        </h3><br>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">File Preview</p>
                        <div class="row">
                            <div class="col-12">
                                <?php
                                if ($sqlGetData['file_type'] == 'Image')
                                {
                                    ?>
                                    <a href="upImages/<?php echo $sqlGetData['file_name'] ; ?>">
                                        <img class="img-thumbnail img-fluid" src="upImages/<?php echo $sqlGetData['file_name'] ; ?>" alt="<?php echo $sqlGetData['file_name'] ; ?>">
                                    </a>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <a href="upDoc/<?php echo $sqlGetData['file_name'] ; ?>">
                                        <iframe src="upDoc/<?php echo $sqlGetData['file_name'] ; ?>" style="width: 100%; height: 450px;"></iframe>
                                    </a>
                                    <?php
                                }
                                if ($_SESSION['role'] == 'Admin Manager')
                                {
                                    function showcategory($parentid)
                                    {
                                        $sql = "select * from categories where parent_id='".$parentid."'";
                                        $result = mysqli_query($GLOBALS['db'],$sql);
                                        $output ="<ul>\n";

                                        while($data=mysqli_fetch_array($result))
                                        {
                                            $output.="<input name='categories[]' type='checkbox' value='".$data['id']."' id='md_checkbox_".$data['id']."' class='filled-in chk-col-red' ><label for='md_checkbox_".$data['id']."'>".$data['name']."</label>\n";
                                            $output.=showcategory($data['id']);
                                        }
                                        $output.="</ul>";
                                        return $output;
                                    }
                                    ?>

                                    <form action="" enctype="multipart/form-data" method="post">
                                        <div class="row">
                                            <div class="col-sm-6" style="margin-top: 20px;">
                                                <input type="text" name="name" class="form-control" placeholder="ENTER FILE NAME">
                                            </div>
                                            <div class="col-sm-6" style="margin-top: 20px;">
                                                <select name="status" id="" class="form-control" required>
                                                    <option value="">--Select Status--</option>
                                                    <option>Submitted</option>
                                                    <option>Review</option>
                                                    <option>Objection</option>
                                                    <option>Resubmission</option>
                                                    <option>Approved</option>
                                                    <option>Rejected</option>
                                                    <option>Read Only</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-8" style="margin-top: 20px;">
                                                <?php
                                                echo showcategory(0);
                                                ?>
                                            </div>
                                            <div class="col-sm-4" style="margin-top: 20px;">
                                                <center>
                                                    <button type="submit" name="approve_file" value="Approve" class="btn btn-warning">
                                                        Approve
                                                    </button>
                                                </center>
                                            </div>
                                        </div>
                                    </form>
                                    <?php

                                    if (isset($_POST['approve_file']))
                                    {
                                        $name = mysqli_real_escape_string($db, $_POST['name']);
                                        $cat_id = implode(',', $_POST['categories']);
                                        $status = mysqli_real_escape_string($db, $_POST['status']);

                                        $sqlUp = mysqli_query($db,"UPDATE `data_uploader` SET `name`='$name',`cat_id`='$cat_id',`status`='$status' WHERE id = ".$_GET['id']."");
                                        if ($sqlUp)
                                        {
                                            echo "<script>window.open('allFiles.php', '_self')</script>";
                                        }
                                    }
                                }
                                ?>
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
                        <p class="card-title">Latest Comments</p>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="display expandable-table" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Comment</th>
                                            <th>Username/Role</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i = 0;
                                        $sqlUsers = mysqli_query($db, "SELECT * FROM `comments` WHERE file_id = '".$_GET['id']."' ORDER BY id DESC");
                                        while ($rowUser = mysqli_fetch_array($sqlUsers))
                                        {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $rowUser['comment'] ; ?></td>
                                                <td>
                                                    Username:<?php echo $rowUser['username']; ?>
                                                    <br>
                                                    Role:<?php echo $rowUser['role']; ?>
                                                </td>
                                                <td><?php echo $rowUser['date'] ; ?></td>
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
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Board Members Comments</p>
                        <div class="row">
                            <div class="col-12">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="col-sm-12">
                                        <div>
                                            <div class="form-line">
                                                <textarea type="text" class="form-control" name="comment" placeholder="Comment" required rows="5" cols="130"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <br>
                                        <button style="width:100%;" class="btn btn-success" type="submit" name="addS">Submit Comment</button>
                                    </div>
                                </form>
                                <?php
                                if (isset($_POST['addS']))
                                {
                                    $comment = mysqli_real_escape_string($db, $_POST['comment']);
                                    $sql = mysqli_query($db, "INSERT INTO `comments`(`file_id`, `username`, `role`, `comment`) VALUES ('".$_GET['id']."','".$_SESSION['username']."','".$_SESSION['role']."','$comment')");
                                    if ($sql)
                                    {
                                        echo "<script>window.open('fileView.php?id=".$_GET['id']."','_self')</script>";
                                    }
                                }
                                ?>
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