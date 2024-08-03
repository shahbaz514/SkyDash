<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-file menu-icon"></i>
                <span class="menu-title">Files Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="allFiles.php">
                            File Approvals
                        </a>
                    </li>
                    <?php
                    $sqlGetCat = mysqli_query($db,"SELECT * FROM `categories` WHERE parent_id = '0'");
                    while ($rowGetCat = mysqli_fetch_array($sqlGetCat))
                    {
                        ?>
                        <li class="nav-item">
                            <a href="categories.php?cat=<?php echo $rowGetCat['id']; ?>" class="nav-link">
                                <?php
                                echo $rowGetCat['name'];
                                ?>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                <i class="mdi mdi-vector-intersection menu-icon"></i>
                <span class="menu-title">Categories</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="allCategories.php">
                            All Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="addCategories.php">
                            Add New Category
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#users" aria-expanded="false" aria-controls="form-elements">
                <i class="mdi mdi-nature-people menu-icon"></i>
                <span class="menu-title">Users</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="users">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="allUsers.php">
                            All Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="addUser.php">
                            Add New User
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">
                <i class="mdi mdi-exit-to-app menu-icon"></i>
                <span class="menu-title">Logout</span>
            </a>
        </li>
    </ul>
</nav>