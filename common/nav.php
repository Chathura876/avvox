<nav class="navbar navbar-expand-md navbar-light border-bottom shadow-sm" style="background-color: white">
    <a class="navbar-brand" href="../index.php"><img class="" src="../images/ac_logo.jpg" alt="Avvox logo" height="48"></a>
    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01"
            aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarTogglerDemo01">
        <div class='mr-0'>&nbsp;&nbsp;&nbsp;&nbsp;Hello, <?php echo $_SESSION['fullname'] ?>
            (<?php echo $_SESSION['usertype'] ?>)
        </div>
        <ul class="navbar-nav mt-2 mt-lg-0 ml-auto mr-2">
            <li class="nav-item active mr-2">
                <a class="nav-link text-white" style="border-radius: 10px; background-color: #D81B60 !important"
                   href="../index.php">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 172 172"
                         style=" fill:#000000;">
                        <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
                           stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
                           font-family="none" font-weight="none" font-size="none" text-anchor="none"
                           style="mix-blend-mode: normal">
                            <path d="M0,172v-172h172v172z" fill="none"></path>
                            <g fill="#ffffff">
                                <path d="M86,24.08c-43.63156,0 -79.12,35.48844 -79.12,79.12c0,11.81156 2.35156,22.52125 7.06813,32.5725c0.215,0.47031 0.44344,0.92719 0.65844,1.3975c0.3225,0.63156 0.63156,1.27656 0.9675,1.90813c1.27656,2.48594 2.63375,4.93156 4.17906,7.28312c0.63156,0.9675 1.70656,1.55875 2.87562,1.55875h126.7425c1.16906,0 2.24406,-0.59125 2.87563,-1.55875c1.54531,-2.35156 2.9025,-4.79719 4.17906,-7.28312c0.3225,-0.63156 0.645,-1.27656 0.9675,-1.90813c0.215,-0.47031 0.44344,-0.92719 0.65844,-1.3975c4.71656,-10.05125 7.06812,-20.76094 7.06812,-32.5725c0,-43.63156 -35.48844,-79.12 -79.12,-79.12zM106.64,134.16h-41.28c-1.90812,0 -3.44,-1.54531 -3.44,-3.44c0,-1.89469 1.53188,-3.44 3.44,-3.44h41.28c1.90813,0 3.44,1.54531 3.44,3.44c0,1.89469 -1.53187,3.44 -3.44,3.44zM124.99563,84.30688l-32.12906,18.82594c0,0.02687 0.01344,0.04031 0.01344,0.06719c0,3.80281 -3.07719,6.88 -6.88,6.88c-3.80281,0 -6.88,-3.07719 -6.88,-6.88c0,-3.80281 3.07719,-6.88 6.88,-6.88c1.22281,0 2.35156,0.34938 3.34594,0.90031l32.1425,-18.83938c1.62594,-0.9675 3.74906,-0.43 4.71656,1.20938c0.9675,1.63937 0.43,3.74906 -1.20937,4.71656zM148.49781,139.32c-0.645,1.10188 -1.80063,1.72 -2.98313,1.72c-0.16125,0 -0.33594,-0.04031 -0.49719,-0.06719c-0.17469,0.02687 -0.36281,0.06719 -0.5375,0.06719c-0.65844,0 -1.31687,-0.18812 -1.90812,-0.57781l-10.32,-6.88c-1.58563,-1.04812 -2.01563,-3.18469 -0.95406,-4.77031c1.04812,-1.58563 3.18469,-2.01563 4.77031,-0.95406l7.94156,5.29437c0.04031,-0.08062 0.08063,-0.16125 0.12094,-0.22844c0.01344,-0.20156 0.01344,-0.40312 0.16125,-0.36281c0.01344,0 0.02687,0 0.02687,0c4.085,-8.08937 6.45,-16.93125 6.93375,-25.92094h-10.2125c-1.90812,0 -3.44,-1.53187 -3.44,-3.44c0,-1.89469 1.53188,-3.44 3.44,-3.44h10.14531c-0.48375,-9.245 -2.87563,-17.96594 -6.82625,-25.81344c-0.08063,-0.14781 -0.20156,-0.26875 -0.28219,-0.43l-8.11625,4.98531c-0.56438,0.34937 -1.1825,0.51062 -1.80063,0.51062c-1.15562,0 -2.28437,-0.59125 -2.92937,-1.65281c-0.99438,-1.6125 -0.48375,-3.73562 1.12875,-4.73l8.2775,-5.06594c-0.25531,-0.38969 -0.45688,-0.77937 -0.67188,-1.16906c-5.13312,-7.49812 -11.81156,-13.84062 -19.55156,-18.65125c-0.13437,-0.08062 -0.29562,-0.16125 -0.43,-0.24187l-4.95844,8.98969c-0.63156,1.12875 -1.80062,1.77375 -3.02344,1.77375c-0.55094,0 -1.12875,-0.13437 -1.65281,-0.43c-1.66625,-0.91375 -2.27094,-3.01 -1.34375,-4.67625l4.93156,-8.93594c-0.08063,-0.04031 -0.16125,-0.09406 -0.24188,-0.13438c-7.44437,-3.50719 -15.62781,-5.61687 -24.26812,-6.07375v10.14531c0,1.89469 -1.53188,3.44 -3.44,3.44c-1.89469,0 -3.44,-1.54531 -3.44,-3.44v-10.14531c-9.36594,0.49719 -18.22125,2.94281 -26.14938,6.9875c-0.28219,0.17469 -0.57781,0.34938 -0.86,0.49719l5.29438,8.55969c0.99437,1.6125 0.49719,3.73562 -1.12875,4.73c-0.56438,0.34937 -1.1825,0.51062 -1.80063,0.51062c-1.15562,0 -2.27094,-0.57781 -2.92937,-1.62594l-5.33469,-8.65375c-0.24188,0.16125 -0.48375,0.28219 -0.72563,0.41656c-7.49812,5.20031 -13.81375,11.91906 -18.58406,19.69937l8.57313,4.66281c1.67969,0.91375 2.29781,2.99656 1.38406,4.66281c-0.61813,1.15562 -1.80063,1.80062 -3.02344,1.80062c-0.55094,0 -1.11531,-0.13437 -1.63937,-0.41656l-8.58656,-4.66281c-3.58781,7.525 -5.76469,15.81594 -6.22156,24.57719h10.14531c1.90813,0 3.44,1.54531 3.44,3.44c0,1.89469 -1.53187,3.44 -3.44,3.44h-10.2125c0.48375,8.9225 2.795,17.68375 6.82625,25.71938c0.02688,0.06719 0.09406,0.13437 0.13438,0.18812c0.1075,0.215 0.3225,0.57781 0.3225,0.57781l7.90125,-5.2675c1.58562,-1.06156 3.72219,-0.63156 4.77031,0.95406c1.06156,1.57219 0.63156,3.70875 -0.95406,4.77031l-10.32,6.88c-0.59125,0.38969 -1.24969,0.57781 -1.90813,0.57781c-0.04031,0 -0.09406,-0.1075 -0.16125,-0.17469c-1.45125,0.38969 -3.06375,-0.16125 -3.85656,-1.54531c-6.36937,-11.00531 -9.74219,-23.48875 -9.74219,-36.12c0,-39.82875 32.41125,-72.24 72.24,-72.24c39.82875,0 72.24,32.41125 72.24,72.24c0,12.63125 -3.37281,25.11469 -9.74219,36.12z"></path>
                            </g>
                        </g>
                    </svg>
                    Dashboard <span class="sr-only">(current)</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white bg-primary" style="border-radius: 10px;" href="../view/sales_inv.php">
                    <i class="fas fa-file-invoice-dollar"></i> Sales Invoice <span class="sr-only">(current)</span></a>
            </li>


            <?php $permissions = array("admin", "salesrep", "dealer", "shop", "accountant", "operator"); //users who can see this main menu item
            if (in_array($_SESSION['usertype'], $permissions)) { ?>
                <div class="dropdown show bg-success mx-2"
                     style="border-radius: 10px; background-color: #00a65a !important">
                    <a class="btn btn-white dropdown-toggle text-white" href="#" role="button" id="dropdownMenuLink"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24"
                             viewBox="0 0 172 172" style=" fill:#000000;">
                            <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
                               stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
                               font-family="none" font-weight="none" font-size="none" text-anchor="none"
                               style="mix-blend-mode: normal">
                                <path d="M0,172v-172h172v172z" fill="none"></path>
                                <g fill="#ffffff">
                                    <path d="M58.48,10.32c-1.90232,0 -3.44,1.53768 -3.44,3.44v10.32h61.92v-10.32c0,-1.90232 -1.53768,-3.44 -3.44,-3.44zM117.36313,27.52l-10.72313,21.45297v112.70703h17.2c1.89888,0 3.44,-1.54112 3.44,-3.44v-110.89297zM52.74219,30.96l-9.16437,13.76h57.49906l6.88,-13.76zM41.28,51.6v106.64c0,1.90232 1.53768,3.44 3.44,3.44h55.04v-110.08z"></path>
                                </g>
                            </g>
                        </svg>
                        Products
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                        <?php $permissions = array("admin");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <!-- <a class="dropdown-item" href="addinventory.php">Add Inventory</a> -->
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin", "operator","salesrep","dealer", "shop", "accountant",);
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../view/pending_issue_invoice.php">Product Issue</a>
                        <?php } ?>

                        <?php $permissions = array("admin", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../addmaininventory.php">Update Main Inventory</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../manageproducts.php">Manage Products</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin", "dealer", "shop", "salesrep", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../addorder.php">Order Products</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin", "dealer", "shop", "salesrep", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../manageorders.php">Manage Orders</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin", "salesrep", "accountant", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../managemaininventory.php">Manage Main Inventory</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin", "accountant", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../inventoryhistory.php">Inventory History</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                    </div>
                </div>
            <?php } ?>

            <?php $permissions = array("admin", "salesrep", "dealer", "shop", "director", "operator"); //users who can see this main menu item
            if (in_array($_SESSION['usertype'], $permissions)) { ?>
                <div class="dropdown show bg-danger mx-2" style="border-radius: 10px;">
                    <a class="btn btn-white dropdown-toggle text-white" style="color: white !important" href="#"
                       role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24"
                             viewBox="0 0 172 172" style=" fill:#000000;">
                            <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
                               stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
                               font-family="none" font-weight="none" font-size="none" text-anchor="none"
                               style="mix-blend-mode: normal">
                                <path d="M0,172v-172h172v172z" fill="none"></path>
                                <g fill="#ffffff">
                                    <path d="M92.5575,17.2c-30.50312,0 -41.83094,23.56938 -33.11,43.5375c-1.08844,0.72563 -2.83531,2.99656 -2.4725,6.9875c0.72563,7.25625 3.99094,8.98969 5.805,9.3525c0.72563,6.89344 5.09281,14.92906 7.6325,16.0175c0,4.71656 -0.06719,8.66719 -0.43,13.76c-5.56312,14.60656 -41.11875,11.22031 -45.6875,37.41c-0.20156,1.14219 0.98094,3.655 3.3325,3.655h116.8525c3.49375,0 3.42656,-2.58 3.225,-3.7625c-4.64937,-26.08219 -40.12437,-22.70937 -45.6875,-37.3025c-0.36281,-5.45562 -0.43,-9.04344 -0.43,-13.76c2.53969,-1.08844 6.58438,-9.48687 7.31,-16.0175c1.81406,0 4.71656,-2.19031 5.805,-9.46c0.36281,-3.99094 -1.12875,-6.51719 -2.58,-6.88c5.805,-7.25625 4.75688,-36.98 -16.6625,-36.98zM52.1375,34.4c-22.96469,0.38969 -33.02937,18.66469 -26.1225,34.2925c-0.73906,0.36281 -2.19031,2.28438 -1.8275,5.59c0.73906,5.88563 2.92938,7.31 4.4075,7.31c0.72563,5.50938 3.9775,11.69063 5.805,12.7925c0,3.66844 0.04031,3.56094 -0.3225,7.955c-2.98312,9.40625 -34.0775,8.7075 -34.0775,31.82c0,0 0,3.44 3.44,3.44h15.5875c5.25406,-14.86187 19.53813,-20.58625 30.315,-24.8325c5.93938,-2.33812 12.02656,-4.70312 13.8675,-7.6325c0.20156,-3.19812 0.30906,-5.9125 0.3225,-8.9225c-3.26531,-3.73562 -5.6975,-9.55406 -6.88,-14.5125c-2.795,-2.06937 -5.81844,-6.04687 -6.5575,-13.4375c-0.3225,-3.50719 0.41656,-6.42312 1.6125,-8.7075c-2.72781,-8.47906 -2.55312,-17.33437 0.43,-25.155zM130.72,34.4c-3.29219,0 -7.17562,0.26875 -10.8575,0.86c2.75469,8.07594 2.86219,17.72406 0.43,24.6175c1.075,2.365 1.57219,5.24063 1.29,8.385l-0.1075,0.215v0.215c-1.02125,6.75906 -3.50719,10.87094 -6.45,13.115c-1.11531,4.64938 -3.38625,10.52156 -6.5575,14.2975c0.01344,2.95625 0.12094,5.61688 0.3225,9.03c1.84094,2.92938 7.94156,5.29438 13.8675,7.6325c10.76344,4.23281 25.0475,9.97063 30.315,24.8325h15.5875c3.44,0 3.44,-3.3325 3.44,-3.3325c0.01344,-26.60625 -29.44156,-20.30406 -33.8625,-32.465c-0.37625,-4.05812 -0.43,-3.68187 -0.43,-7.74c1.84094,-1.10187 5.22719,-7.29656 5.59,-12.47c1.47813,0 3.66844,-1.51844 4.4075,-7.4175c0.36281,-2.94281 -0.72562,-5.11969 -1.8275,-5.4825c4.43438,-5.89906 3.70875,-29.1325 -12.9,-29.1325z"></path>
                                </g>
                            </g>
                        </svg>
                        People
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                        <?php $permissions = array("admin", "salesrep", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../managedealers.php">Manage Dealers</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->


                        <?php $permissions = array("admin", "dealer", "salesrep", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../manageshops.php">Manage Shops</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->


                        <?php $permissions = array("admin", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../managetechnicians.php">Manage Technicians</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../managesalesreps.php">Manage Sales Reps</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin", "dealer", "shop", "director", "operator", "salesrep");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../managecustomers.php">Manage Customers</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../manageAccountant.php">Manage Accountants</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../manageStoresKeepers.php">Manage Stores Keepers</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../manageDirectors.php">Manage Directors</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../manageOperators.php">Manage Operators</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../managepasswords.php">Manage Passwords</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                    </div>
                </div>
            <?php } ?>

            <?php $permissions = array("admin", "technician", "dealer", "shop", "accountant", "director", "operator"); //users who can see this main menu item
            if (in_array($_SESSION['usertype'], $permissions)) { ?>
                <div class="dropdown show bg-success mx-2"
                     style="border-radius: 10px; background-color: #FF851B !important">
                    <a class="btn btn-white dropdown-toggle text-white" href="#" role="button" id="dropdownMenuLink"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24"
                             viewBox="0 0 172 172" style=" fill:#000000;">
                            <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
                               stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
                               font-family="none" font-weight="none" font-size="none" text-anchor="none"
                               style="mix-blend-mode: normal">
                                <path d="M0,172v-172h172v172z" fill="none"></path>
                                <g fill="#ffffff">
                                    <path d="M68.8,6.88c-5.65719,0 -10.32,4.66281 -10.32,10.32v6.88h-41.56219c-5.53625,0 -10.03781,4.46125 -10.03781,9.94375v51.97625c0,1.89469 1.41094,3.44 3.15781,3.44h104.78562c6.54406,-4.34031 14.36469,-6.88 22.77656,-6.88c10.57531,0 20.21,4.03125 27.52,10.58875v-59.125c0,-5.4825 -4.50156,-9.94375 -10.03781,-9.94375h-41.56219v-6.88c0,-5.65719 -4.66281,-10.32 -10.32,-10.32zM68.8,13.76h34.4c1.935,0 3.44,1.505 3.44,3.44v6.88h-41.28v-6.88c0,-1.935 1.505,-3.44 3.44,-3.44zM86,68.8c3.80281,0 6.88,3.07719 6.88,6.88c0,3.80281 -3.07719,6.88 -6.88,6.88c-3.80281,0 -6.88,-3.07719 -6.88,-6.88c0,-3.80281 3.07719,-6.88 6.88,-6.88zM137.6,89.44c-18.96031,0 -34.4,15.43969 -34.4,34.4c0,8.25063 2.92938,15.81594 7.79375,21.75531l-20.54594,20.5325l4.86437,4.86437l20.5325,-20.54594c5.93938,4.86438 13.50469,7.79375 21.75531,7.79375c18.96031,0 34.4,-15.43969 34.4,-34.4c0,-18.96031 -15.43969,-34.4 -34.4,-34.4zM6.88,95.74219v42.23406c0,5.4825 4.50156,9.94375 10.03781,9.94375h82.00906l3.13094,-3.1175c-3.72219,-6.32906 -5.73781,-13.58531 -5.73781,-20.9625c0,-10.57531 4.03125,-20.21 10.58875,-27.52h-96.87094c-1.10188,0 -2.16344,-0.22844 -3.15781,-0.57781zM137.6,96.32c15.23813,0 27.52,12.28188 27.52,27.52c0,15.23813 -12.28187,27.52 -27.52,27.52c-15.23812,0 -27.52,-12.28187 -27.52,-27.52c0,-15.23812 12.28188,-27.52 27.52,-27.52z"></path>
                                </g>
                            </g>
                        </svg>
                        Jobs
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                        <?php $permissions = array("admin", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../addjob.php">Add New Job</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin", "accountant", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../nonapprovedjobs.php">NonApproved Jobs</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin", "dealer", "shop", "technician", "accountant", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../pendingjobs.php">Pending Jobs</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin", "dealer", "shop", "technician", "accountant", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../completedjobs.php">Completed Jobs</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin", "dealer", "shop", "technician", "accountant", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../alljobs.php">View All Jobs</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                    </div>
                </div>
            <?php } ?>

            <?php $permissions = array("admin", "salesrep", "accountant", "director", "operator"); //users who can see this main menu item
            if (in_array($_SESSION['usertype'], $permissions)) { ?>
                <div class="dropdown show bg-success mx-2"
                     style="border-radius: 10px; background-color: #367fa9 !important">
                    <a class="btn btn-white dropdown-toggle text-white" href="#" role="button" id="dropdownMenuLink"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24"
                             viewBox="0 0 172 172" style=" fill:#000000;">
                            <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
                               stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
                               font-family="none" font-weight="none" font-size="none" text-anchor="none"
                               style="mix-blend-mode: normal">
                                <path d="M0,172v-172h172v172z" fill="none"></path>
                                <g fill="#ffffff">
                                    <path d="M24.08,6.88v158.24h123.84v-158.24zM82.56,30.96h6.88v14.68047l12.71187,-7.33687l3.44,5.95281l-12.71187,7.3436l12.71187,7.3436l-3.44,5.95281l-12.71187,-7.33687v14.68047h-6.88v-14.68047l-12.71187,7.33687l-3.44,-5.95281l12.71187,-7.3436l-12.71187,-7.3436l3.44,-5.95281l12.71187,7.33687zM48.16,89.44h75.68v6.88h-75.68zM48.16,110.08h75.68v6.88h-75.68zM48.16,130.72h41.28v6.88h-41.28z"></path>
                                </g>
                            </g>
                        </svg>
                        Reports
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                        <?php $permissions = array("admin", "accountant", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../view/sales_invoice_report.php">Sales Invoice Report</a>
                        <?php } ?>

                        <?php $permissions = array("admin", "accountant", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../view/issue_product_report.php">Issue Product Report</a>
                        <?php } ?>


                        <?php $permissions = array("admin", "accountant", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../completejobreport.php">Jobs Report</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin", "salesrep", "accountant", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../pending_job_report.php">Pending Jobs Report</a>
                        <?php } ?>

                        <?php $permissions = array("admin", "salesrep", "accountant", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../complete_job_report.php">Completed Jobs Report</a>
                        <?php } ?>


                        <?php $permissions = array("admin", "accountant", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../orderreport.php">Order Details Report</a>
                        <?php } ?>
                        <!-- ----------------------------------------------------------------------- -->

                        <?php $permissions = array("admin", "accountant", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../salesreport.php">Sales Report</a>
                        <?php } ?>

                        <?php $permissions = array("admin", "accountant", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../issuedordersreport.php">Issued Orders Report</a>
                        <?php } ?>

                        <?php $permissions = array("admin", "salesrep", "accountant", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../pendingOrderReport.php">Pending Orders Report</a>
                        <?php } ?>

                        <?php $permissions = array("admin", "accountant", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../approvedordersreport.php">Approved Orders Report</a>
                        <?php } ?>

                        <?php $permissions = array("admin", "accountant", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../ordersummary.php">Orders Summary Report</a>
                        <?php } ?>

                        <?php $permissions = array("admin", "accountant", "director", "operator");
                        if (in_array($_SESSION['usertype'], $permissions)) { ?>
                            <a class="dropdown-item" href="../inventoryreport.php">Inventory Report</a>
                        <?php } ?>


                    </div>
                </div>
            <?php } ?>

            <li class="nav-item">
                <?php
                if ($userloggedin) { ?>
                    <a class="nav-link btn btn-secondary text-white" href="../logout.php" style="border-radius: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24"
                             viewBox="0 0 172 172" style=" fill:#000000;">
                            <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
                               stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0"
                               font-family="none" font-weight="none" font-size="none" text-anchor="none"
                               style="mix-blend-mode: normal">
                                <path d="M0,172v-172h172v172z" fill="none"></path>
                                <g fill="#ffffff">
                                    <path d="M86,6.88c-43.62952,0 -79.12,35.49392 -79.12,79.12c0,43.62608 35.49048,79.12 79.12,79.12c43.62952,0 79.12,-35.49392 79.12,-79.12c0,-43.62608 -35.49048,-79.12 -79.12,-79.12zM86,27.52c1.90232,0 3.44,1.54112 3.44,3.44v55.04c0,1.89888 -1.53768,3.44 -3.44,3.44c-1.90232,0 -3.44,-1.54112 -3.44,-3.44v-55.04c0,-1.89888 1.53768,-3.44 3.44,-3.44zM103.25375,30.38891c0.44554,-0.03472 0.89983,0.01919 1.35047,0.16797c23.84952,8.00488 39.87578,30.28641 39.87578,55.44313c0,32.24656 -26.23344,58.48 -58.48,58.48c-32.24656,0 -58.48,-26.23344 -58.48,-58.48c0,-25.15672 16.02626,-47.43496 39.87578,-55.43641c1.79912,-0.59856 3.74831,0.36088 4.35375,2.16344c0.60544,1.80256 -0.36088,3.75503 -2.16344,4.36047c-21.04592,7.05888 -35.1861,26.71418 -35.1861,48.9125c0,28.45224 23.14776,51.6 51.6,51.6c28.45224,0 51.6,-23.14776 51.6,-51.6c0,-22.19832 -14.14018,-41.8569 -35.1861,-48.91922c-1.79912,-0.60544 -2.76888,-2.55119 -2.16344,-4.35375c0.45666,-1.34934 1.66668,-2.23396 3.00328,-2.33813z"></path>
                                </g>
                            </g>
                        </svg>
                        Logout</a>
                <?php } else { ?>
                    <a class="nav-link" href="../login.php">Login</a>
                <?php } ?>

            </li>
        </ul>

    </div>
</nav>
<div class="container-fluid" style="min-height:70vh; max-width:90%">
    <!-- START MAIN CONTENTS -->