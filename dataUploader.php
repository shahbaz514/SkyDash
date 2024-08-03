<?php
session_start();
session_abort();
include "db/db.php";
if (!isset($_SESSION['username']))
{
    header("Location: login.php");
}
if ($_SESSION['role'] != 'Data Uploader')
{
    header("Location: index.php");
}
include 'inc/head.php';
include 'inc/sidebar.php';

if (isset($_GET['id']))
{
    $sqlDel = mysqli_query($db, "DELETE FROM data_uploader WHERE id = '".$_GET['id']."'");
    if ($sqlDel)
    {
        echo "<script>window.open('dataUploader.php', '_self')</script>";
    }
}
?>
    <div class="main-panel">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title" style="text-align:center;">
                                        DATA UPLOADER FOR IMAGES
                                    </h3>
                                    <form action="dataUploader.php" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-sm-6" style="padding: 20px;">
                                                <input type="file" name="img" title="Select Image fILE" class="form-control" accept="image/*">
                                            </div>
                                            <div class="col-sm-6" style="padding: 20px;">
                                                <center>
                                                    <input type="submit" name="uploadImg" value="Upload Image File" class="btn btn-warning">
                                                </center>
                                            </div>
                                        </div>
                                    </form>
                                    <?php
                                    if (isset($_POST['uploadImg']))
                                    {
                                        $temp = explode(".", $_FILES["img"]["name"]);
                                        $newfilename = $_SESSION['username'] . '.' . rand() . '.' . end($temp);
                                        $sqlU = mysqli_query($db, "INSERT INTO `data_uploader`(`username`, `file_name`, `file_type`) VALUES ('".$_SESSION['username']."','$newfilename','Image')");
                                        if ($sqlU)
                                        {

                                            $move = move_uploaded_file($_FILES["img"]["tmp_name"], "upImages/" . $newfilename);
                                            if ($move)
                                            {
                                                echo "<script>window.open('dataUploader.php', '_self')</script>";
                                            }

                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title" style="text-align:center;">
                                DATA UPLOADER FOR DOCUMENTS
                            </h3>
                            <form action="dataUploader.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-6" style="padding: 20px;">
                                        <input type="file" name="doc" title="Select Doc fILE" class="form-control" accept="application/pdf">
                                    </div>
                                    <div class="col-sm-6" style="padding: 20px;">
                                        <center>
                                            <input type="submit" name="uploadDoc" value="Upload Doc File" class="btn btn-warning">
                                        </center>
                                    </div>
                                </div>
                            </form>
                            <?php
                            if (isset($_POST['uploadDoc']))
                            {
                                $temp = explode(".", $_FILES["doc"]["name"]);
                                $newfilename = $_SESSION['username'] . '.' . rand() . '.' . end($temp);
                                $sqlU = mysqli_query($db, "INSERT INTO `data_uploader`(`username`, `file_name`, `file_type`) VALUES ('".$_SESSION['username']."','$newfilename','Document')");
                                if ($sqlU)
                                {

                                    $move = move_uploaded_file($_FILES["doc"]["tmp_name"], "upDoc/" . $newfilename);
                                    if ($move)
                                    {
                                        echo "<script>window.open('dataUploader.php', '_self')</script>";
                                    }

                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row clearfix">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title" style="text-align:center;">
                                UPLOADED DATA
                            </h3>
                            <div class="table-responsive">
                                <table class="display expandable-table" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>File Name</th>
                                        <th>File Type</th>
                                        <th>Uploaded BY</th>
                                        <th>Uploaded Date</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>File Name</th>
                                        <th>File Type</th>
                                        <th>Uploaded BY</th>
                                        <th>Uploaded Date</th>
                                        <th>Delete</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>

                                    <?php
                                    $sqlUsers = mysqli_query($db, "SELECT * FROM data_uploader WHERE username = '".$_SESSION['username']."' ORDER BY id DESC");
                                    while ($rowUser = mysqli_fetch_array($sqlUsers))
                                    {
                                        ?>
                                        <tr>
                                            <td>
                                                <?php
                                                if ($rowUser['file_type'] == 'Image')
                                                {
                                                    ?>
                                                    <a target="_blank" href="upImages/<?php echo $rowUser['file_name'] ; ?>"><?php echo $rowUser['file_name'] ; ?></a>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <a target="_blank" href="upDoc/<?php echo $rowUser['file_name'] ; ?>"><?php echo $rowUser['file_name'] ; ?></a>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $rowUser['file_type'] ; ?></td>
                                            <td><?php echo $rowUser['username'] ; ?></td>
                                            <td><?php echo $rowUser['date'] ; ?></td>
                                            <td>
                                                <a class="btn btn-danger" href="dataUploader.php?id=<?php echo $rowUser['id']; ?>">
                                                    <i class="mdi mdi-delete"></i>
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

<?php
include 'inc/footer.php';
?>