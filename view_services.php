<?php 
    require "connect.php";
    if (!isset($_SESSION['auth_login'])) {
        header("location: customer/login.php");
        exit;
    }
    $auth = $_SESSION['auth_login'];
    $auth_id = $auth['id'];


    $wedding_query = "SELECT * FROM wedding WHERE client_id = $auth_id ORDER BY date"; 
    $wedding_result = mysqli_query($conn, $wedding_query);
    if (!$wedding_result) {
        echo "Error fetching wedding data: " . mysqli_error($conn);
        exit;
    }
    $wedding = [];
    while ($item = mysqli_fetch_assoc($wedding_result)) {
        $formatted_date = date("F j, Y", strtotime($item['date']));
        $place_marriage = "Immaculate Conception Parish Pandi";
        $item['formatted_date'] = $formatted_date;
        $wedding[] = $item;
    }


    $mass_query = "SELECT * FROM mass WHERE client_id = $auth_id ORDER BY date"; 
    $mass_result = mysqli_query($conn, $mass_query);
    if (!$mass_result) {
        echo "Error fetching mass data: " . mysqli_error($conn);
        exit;
    }
    $mass = [];
    while ($item = mysqli_fetch_assoc($mass_result)) {
        $formatted_date = date("F j, Y", strtotime($item['date']));
        $item['formatted_date'] = $formatted_date;
        $mass[] = $item;
    }

    $funeral_query = "SELECT * FROM funeral WHERE client_id = $auth_id ORDER BY date_added"; 
    $funeral_result = mysqli_query($conn, $funeral_query);
    if (!$funeral_result) {
        echo "Error fetching funeral data: " . mysqli_error($conn);
        exit;
    }
    $funeral = [];
    while ($item = mysqli_fetch_assoc($funeral_result)) {
        $formatted_date = date("F j, Y", strtotime($item['date']));
        $item['formatted_date'] = $formatted_date;
        $funeral[] = $item;
    }

    $baptism_query = "SELECT * FROM binyag WHERE client_id = $auth_id ORDER BY date_added"; 
    $baptism_result = mysqli_query($conn, $baptism_query);
    if (!$baptism_result) {
        echo "Error fetching baptism data: " . mysqli_error($conn);
        exit;
    }
    $baptism = [];
    while ($item = mysqli_fetch_assoc($baptism_result)) {
        $formatted_date = date("F j, Y", strtotime($item['date']));
        $item['formatted_date'] = $formatted_date;
        $baptism[] = $item;
    }

    $baptismcert_query = "SELECT * FROM binyag_request_certificate WHERE client_id = $auth_id ORDER BY date_added"; 
    $baptismcert_result = mysqli_query($conn, $baptismcert_query);
    if (!$baptismcert_result) {
        echo "Error fetching baptism certificate data: " . mysqli_error($conn);
        exit;
    }
    $baptismcert = [];
    while ($item = mysqli_fetch_assoc($baptismcert_result)) {
        $formatted_date = date("F j, Y", strtotime($item['baptismal_date']));
        $item['formatted_date'] = $formatted_date;
        $baptismcert[] = $item;
    }

    $sickcall_query = "SELECT * FROM sickcall WHERE client_id = $auth_id ORDER BY date_added"; 
    $sickcall_result = mysqli_query($conn, $sickcall_query);
    if (!$sickcall_result) {
        echo "Error fetching sickcall data: " . mysqli_error($conn);
        exit;
    }
    $sickcall = [];
    while ($item = mysqli_fetch_assoc($sickcall_result)) {
        $formatted_date = date("F j, Y", strtotime($item['date']));
        $item['formatted_date'] = $formatted_date;
        $sickcall[] = $item;
    }

    $blessing_query = "SELECT * FROM blessing WHERE client_id = $auth_id ORDER BY date_added"; 
    $blessing_result = mysqli_query($conn, $blessing_query);
    if (!$blessing_result) {
        echo "Error fetching blessing data: " . mysqli_error($conn);
        exit;
    }
    $blessing = [];
    while ($item = mysqli_fetch_assoc($blessing_result)) {
        $formatted_date = date("F j, Y", strtotime($item['date']));
        $item['formatted_date'] = $formatted_date;
        $blessing[] = $item;
    }


    $countWedding = count($wedding);
    $countMass = count($mass);
    $countFuneral = count($funeral);
    $countBaptism = count($baptism);
    $countBaptismcert = count($baptismcert);
    $countSickcall = count($sickcall);
    $countBlessing = count($blessing);
?>


<?php
$status = array(
    1 => "To Process",
    2 => "Approved",
    3 => "Completed",
    4 => "Decline"
);
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" />
    <title>View Services - ICP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="style/nav.css">
    <link rel="stylesheet" href="style/footer.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</head>

<?php include 'nav.php';?>

<body>
    <!-- <a class="btn btn-info btn-sm m-3" href="product.php">Back to Orders</a> -->
    <div style="background-color: #f5f5f5">
        <br>
        <a class="back_button" href="apply.php">
            <i class='bx bx-arrow-back' style='font-size:12px'></i>Back
        </a>

        <section class="">
            <style>
            .orderContainer {
                background-color: #fff;
                width: 60%;
                /* height: 650px; */
                margin: 2rem;
                padding: 1rem 1rem;
                border-radius: 1rem;
                margin: 1% auto;
                padding: 20px;
                /* border: 1px solid #888; */
                box-shadow: 0 0 50px 0 rgba(0, 0, 0, 0.2);

            }

            header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                font-size: 16px;
                /* margin-bottom: 2rem; */
                padding: 0;
            }

            h3 {
                font-size: 18px;
                font-weight: bolder;
            }

            .orderHeader {
                display: flex;
                align-items: center;
            }

            .orderHeader h3 {
                font-size: 18px;
                font-weight: bolder;
            }
            </style>
            <div class="orderContainer">
                <header>
                    <div class="orderHeader">
                        <h3>My Services</h3>
                    </div>
                </header>
                <hr>
                <div class="container">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="OrderPlaced-tab" data-toggle="tab" href="#OrderPlaced"
                                role="tab" aria-controls="OrderPlaced"
                                aria-selected="true">Wedding<?php if ($countWedding > 0): ?><span
                                    id="num-of-notif"><?php echo $countWedding; ?></span><?php endif; ?>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="ToShip-tab" data-toggle="tab" href="#ToShip" role="tab"
                                aria-controls="ToShip" aria-selected="false">Mass<?php if ($countMass > 0): ?><span
                                    id="num-of-notif"><?php echo $countMass; ?></span><?php endif; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ToReceive-tab" data-toggle="tab" href="#ToReceive" role="tab"
                                aria-controls="ToReceive"
                                aria-selected="false">Funeral<?php if ($countFuneral > 0): ?><span
                                    id="num-of-notif"><?php echo $countFuneral; ?></span><?php endif; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="Completed-tab" data-toggle="tab" href="#Completed" role="tab"
                                aria-controls="Completed"
                                aria-selected="false">Baptism<?php if ($countBaptism > 0): ?><span
                                    id="num-of-notif"><?php echo $countBaptism; ?></span><?php endif; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="sickcall-tab" data-toggle="tab" href="#sickcall" role="tab"
                                aria-controls="sickcall"
                                aria-selected="false">Sickcall<?php if ($countSickcall > 0): ?><span
                                    id="num-of-notif"><?php echo $countSickcall; ?></span><?php endif; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="blessing-tab" data-toggle="tab" href="#blessing" role="tab"
                                aria-controls="blessing"
                                aria-selected="false">Blessing<?php if ($countBlessing > 0): ?><span
                                    id="num-of-notif"><?php echo $countBlessing; ?></span><?php endif; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="baptismcertificate-tab" data-toggle="tab" href="#baptismcertificate"
                                role="tab" aria-controls="baptismcertificate" aria-selected="true">Baptism
                                Certificate<?php if ($countBaptismcert > 0): ?><span
                                    id="num-of-notif"><?php echo $countBaptismcert; ?></span><?php endif; ?>
                            </a>
                        </li>
                    </ul>


                    <div class="tab-content" id="myTabContent" style="background-color: #fff; padding: 20px 30px;">

                        <!-- Wedding -->
                        <div class="tab-pane fade show active" id="OrderPlaced" role="tabpanel"
                            aria-labelledby="OrderPlaced-tab">

                            <?php if ($countWedding == 0) { ?>
                            <h1 style="text-align: center; font-size: 16px; color: #a9a2a2; margin: 100px 0;">
                                <i class="fas fa-clockt"></i><br>No Application Yet
                            </h1>
                            <?php } else { ?>
                            <div class="row">
                                <div class="col-lg">
                                    <?php foreach ($wedding as $data) { ?>
                                    <div class="card mt-4">
                                        <div class="card-body p-0 table-responsive ">
                                            <div style="display: flex; justify-content: space-between;">
                                                <h4 class="p-3 mb-0"><?php echo $data['reference_id']; ?></h4>
                                                <h5 class="text-primary p-3 mb-0">
                                                    <?php echo $status[$data['status_id'][0]]; ?></h5>

                                            </div>
                                            <table class="table mb-0 text-right">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Groom</th>
                                                        <th scope="col"></th>
                                                        <th scope="col">Age</th>
                                                        <th scope="col">Mother's Name</th>
                                                        <th scope="col">Father's Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="border-top: none;
                                        border-bottom: none;">
                                                        <td>
                                                            <img src="<?php echo $data['id_picture_groom']; ?>"
                                                                width="50" alt="<?php echo $productName; ?>"><br>
                                                        </td>
                                                        <td class="text-left">
                                                            <?php echo $data['groom_name']; ?><br><br><br></td>
                                                        <td>
                                                            <?php echo $data['groom_age']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['groom_mother_name']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['groom_father_name']; ?><br><br><br>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                            <table class="table mb-0 text-right">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Bride</th>
                                                        <th scope="col"></th>
                                                        <th scope="col">Age</th>
                                                        <th scope="col">Mother's Name</th>
                                                        <th scope="col">Father's Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="border-top: none;
                                        border-bottom: none;">
                                                        <td>
                                                            <img src="<?php echo $data['id_picture_bride']; ?>"
                                                                width="50" alt="<?php echo $productName; ?>"><br>
                                                        </td>
                                                        <td class="text-left">
                                                            <?php echo $data['bride_name']; ?><br><br><br></td>
                                                        <td>
                                                            <?php echo $data['bride_age']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['bride_mother_name']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['bride_father_name']; ?><br><br><br>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                            <div style="display: flex; justify-content: space-between;">
                                                <div class="text-left p-3">
                                                    <span class="text-muted">Date Applied:</span>
                                                    <span
                                                        class="badge badge-success"><?php echo date('M d, Y g:ia', strtotime($data['date_added'])); ?>
                                                    </span><br>
                                                    <span class="text-muted">Target Wedding Date:</span>
                                                    <span><?php echo date('M d, Y', strtotime($data['date'])); ?>
                                                        <br>
                                                        <span class="text-muted">Place of Marriage:</span>
                                                        <strong><?php echo $place_marriage ?></strong>
                                                </div>
                                                <a href="view_services_wedding.php?reference_id=<?php echo $data['reference_id']; ?>"
                                                    class="btn btn-primary btn-sm h-25">View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>


                        <!-- Mass -->
                        <div class="tab-pane fade" id="ToShip" role="tabpanel" aria-labelledby="ToShip-tab">
                        <?php if ($countMass == 0) { ?>
                            <h1 style="text-align: center; font-size: 16px; color: #a9a2a2; margin: 100px 0;">
                                <i class="fas fa-clockt"></i><br>No Application Yet
                            </h1>
                            <?php } else { ?>
                            <div class="row">
                                <div class="col-lg">
                                    <?php foreach ($mass as $data) { ?>
                                    <div class="card mt-4">
                                        <div class="card-body p-0 table-responsive ">
                                            <div style="display: flex; justify-content: space-between;">
                                                <h4 class="p-3 mb-0"><?php echo $data['reference_id']; ?></h4>
                                                <h5 class="text-primary p-3 mb-0">
                                                    <?php echo $status[$data['status_id'][0]]; ?></h5>

                                            </div>
                                            <table class="table mb-0 text-right">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Purpose</th>
                                                        <th scope="col">Time</th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Receipt</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="border-top: none;
                                        border-bottom: none;">
                                                        <td>
                                                            <?php echo $data['name']; ?><br><br><br></td>
                                                        <td>
                                                            <?php echo $data['purpose']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['time']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo date('M d, Y', strtotime($data['date'])); ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <img src="<?php echo $data['reciept']; ?>" width="50"
                                                                alt="receipt"><br>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>

                                            <div style="display: flex; justify-content: space-between;">
                                                <div class="text-left p-3">
                                                    <span class="text-muted">Date Applied:</span>
                                                    <span
                                                        class="badge badge-success"><?php echo date('M d, Y g:ia', strtotime($data['date_added'])); ?></span><br>
                                                </div>
                                                <a href="view_services_mass.php?reference_id=<?php echo $data['reference_id']; ?>"
                                                    class="btn btn-primary btn-sm h-25 m-3">View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                        <!-- Funeral -->
                        <div class="tab-pane fade" id="ToReceive" role="tabpanel" aria-labelledby="ToReceive-tab">
                        <?php if ($countFuneral == 0) { ?>
                            <h1 style="text-align: center; font-size: 16px; color: #a9a2a2; margin: 100px 0;">
                                <i class="fas fa-clockt"></i><br>No Application Yet
                            </h1>
                            <?php } else { ?>
                            <div class="row">
                                <div class="col-lg">
                                    <?php foreach ($funeral as $data) { ?>
                                    <div class="card mt-4">
                                        <div class="card-body p-0 table-responsive ">
                                            <div style="display: flex; justify-content: space-between;">
                                                <h4 class="p-3 mb-0"><?php echo $data['reference_id']; ?></h4>
                                                <h5 class="text-primary p-3 mb-0">
                                                    <?php echo $status[$data['status_id'][0]]; ?></h5>

                                            </div>
                                            <table class="table mb-0 text-center">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Deceased Name</th>
                                                        <th scope="col">Cause of Death</th>
                                                        <th scope="col">Date of Death</th>
                                                        <th scope="col">Burial Place</th>
                                                        <th scope="col">Time/Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="border-top: none;
                                        border-bottom: none;">
                                                        <td>
                                                            <?php echo $data['deceased_fullname']; ?><br><br><br></td>
                                                        <td>
                                                            <?php echo $data['cause_of_death']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['date_of_death']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['burial_place']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo date('g:ia', strtotime($data['time'])); ?><br><?php echo date('M d, Y', strtotime($data['date'])); ?><br><br>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>

                                            <div style="display: flex; justify-content: space-between;">
                                                <div class="text-left p-3">
                                                    <span class="text-muted">Date Applied:</span>
                                                    <span
                                                        class="badge badge-success"><?php echo date('M d, Y g:ia', strtotime($data['date_added'])); ?></span><br>
                                                </div>
                                                <a href="view_services_funeral.php?reference_id=<?php echo $data['reference_id']; ?>"
                                                    class="btn btn-primary btn-sm h-25 m-3">View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                        <!-- Baptism -->
                        <div class="tab-pane fade" id="Completed" role="tabpanel" aria-labelledby="Completed-tab">
                        <?php if ($countBaptism == 0) { ?>
                            <h1 style="text-align: center; font-size: 16px; color: #a9a2a2; margin: 100px 0;">
                                <i class="fas fa-clockt"></i><br>No Application Yet
                            </h1>
                            <?php } else { ?>
                            <div class="row">
                                <div class="col-lg">
                                    <?php foreach ($baptism as $data) { ?>
                                    <div class="card mt-4">
                                        <div class="card-body p-0 table-responsive ">
                                            <div style="display: flex; justify-content: space-between;">
                                                <h4 class="p-3 mb-0"><?php echo $data['reference_id']; ?></h4>
                                                <h5 class="text-primary p-3 mb-0">
                                                    <?php echo $status[$data['status_id'][0]]; ?></h5>

                                            </div>
                                            <table class="table mb-0 text-center">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Complete Name(First,Middle,Last)</th>
                                                        <th scope="col">Birthdate</th>
                                                        <th scope="col">Months</th>
                                                        <th scope="col">Father's Name</th>
                                                        <th scope="col">Mother's Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="border-top: none;
                                        border-bottom: none;">
                                                        <td>
                                                            <?php echo $data['child_first_name']; ?>
                                                            <?php echo $data['mother_maiden_lastname']; ?>
                                                            <?php echo $data['father_lastname']; ?><br><br><br></td>
                                                        <td>
                                                            <?php echo $data['birthdate']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['months']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['father_name']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['mother_maiden_fullname']; ?><br><br><br>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>

                                            <div style="display: flex; justify-content: space-between;">
                                                <div class="text-left p-3">
                                                    <span class="text-muted">Date Applied:</span>
                                                    <span
                                                        class="badge badge-success"><?php echo date('M d, Y g:ia', strtotime($data['date_added'])); ?></span><br>
                                                </div>
                                                <a href="view_services_baptism.php?reference_id=<?php echo $data['reference_id']; ?>"
                                                    class="btn btn-primary btn-sm h-25 m-3">View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                        <!-- Baptism Certificate -->
                        <div class="tab-pane fade" id="baptismcertificate" role="tabpanel"
                            aria-labelledby="baptismcertificate-tab">
                            <?php if ($countBaptismcert == 0) { ?>
                            <h1 style="text-align: center; font-size: 16px; color: #a9a2a2; margin: 100px 0;">
                                <i class="fas fa-clockt"></i><br>No Application Yet
                            </h1>
                            <?php } else { ?>
                            <div class="row">
                                <div class="col-lg">
                                    <?php foreach ($baptismcert as $data) { ?>
                                    <div class="card mt-4">
                                        <div class="card-body p-0 table-responsive ">
                                            <div style="display: flex; justify-content: space-between;">
                                                <h4 class="p-3 mb-0"><?php echo $data['reference_id']; ?></h4>
                                                <h5 class="text-primary p-3 mb-0">
                                                    <?php echo $status[$data['status_id'][0]]; ?></h5>

                                            </div>
                                            <table class="table mb-0 text-center">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Complete Name(First,Middle,Last)</th>
                                                        <th scope="col">Birthdate</th>
                                                        <th scope="col">Birth Place</th>
                                                        <th scope="col">Father's Name</th>
                                                        <th scope="col">Mother's Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="border-top: none;
                                        border-bottom: none;">
                                                        <td>
                                                            <?php echo $data['child_first_name']; ?>
                                                            <?php echo $data['mother_maiden_lastname']; ?>
                                                            <?php echo $data['father_lastname']; ?><br><br><br></td>
                                                        <td>
                                                            <?php echo $data['birthdate']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['birthplace']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['father_fullname']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['mother_maidenname']; ?><br><br><br>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>

                                            <div style="display: flex; justify-content: space-between;">
                                                <div class="text-left p-3">
                                                    <span class="text-muted">Date Applied:</span>
                                                    <span
                                                        class="badge badge-success"><?php echo date('M d, Y g:ia', strtotime($data['date_added'])); ?></span><br>
                                                </div>
                                                <a href="view_services_baptismcert.php?reference_id=<?php echo $data['reference_id']; ?>"
                                                    class="btn btn-primary btn-sm h-25 m-3">View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                        <!-- Sick Call -->
                        <div class="tab-pane fade" id="sickcall" role="tabpanel" aria-labelledby="sickcall-tab">
                        <?php if ($countSickcall == 0) { ?>
                            <h1 style="text-align: center; font-size: 16px; color: #a9a2a2; margin: 100px 0;">
                                <i class="fas fa-clockt"></i><br>No Application Yet
                            </h1>
                            <?php } else { ?>
                            <div class="row">
                                <div class="col-lg">
                                    <?php foreach ($sickcall as $data) { ?>
                                    <div class="card mt-4">
                                        <div class="card-body p-0 table-responsive ">
                                            <div style="display: flex; justify-content: space-between;">
                                                <h4 class="p-3 mb-0"><?php echo $data['reference_id']; ?></h4>
                                                <h5 class="text-primary p-3 mb-0">
                                                    <?php echo $status[$data['status_id'][0]]; ?></h5>

                                            </div>
                                            <table class="table mb-0 text-center">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Patient's Name</th>
                                                        <th scope="col">Age</th>
                                                        <th scope="col">Illness</th>
                                                        <th scope="col">Contact Number</th>
                                                        <th scope="col">Complete Address</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="border-top: none;
                                        border-bottom: none;">
                                                        <td>
                                                            <?php echo $data['patients_name']; ?><br><br><br></td>
                                                        <td>
                                                            <?php echo $data['age']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['illness']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['contact_number']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['complete_address']; ?><br><br><br>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>

                                            <div style="display: flex; justify-content: space-between;">
                                                <div class="text-left p-3">
                                                    <span class="text-muted">Date Applied:</span>
                                                    <span
                                                        class="badge badge-success"><?php echo date('M d, Y g:ia', strtotime($data['date_added'])); ?></span><br>
                                                    <span class="text-muted">Status:</span>
                                                    <span
                                                        class="badge <?php echo ($data['urgent'] == 'Yes') ? 'badge-danger' : 'badge-warning'; ?>">
                                                        <?php echo ($data['urgent'] == 'Yes') ? 'Urgent' : 'Not Urgent'; ?>
                                                    </span><br>

                                                </div>

                                                <a href="view_services_sickcall.php?reference_id=<?php echo $data['reference_id']; ?>"
                                                    class="btn btn-primary btn-sm h-25 m-3">View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                        <!-- Blessing -->
                        <div class="tab-pane fade" id="blessing" role="tabpanel" aria-labelledby="blessing-tab">
                        <?php if ($countBlessing == 0) { ?>
                            <h1 style="text-align: center; font-size: 16px; color: #a9a2a2; margin: 100px 0;">
                                <i class="fas fa-clockt"></i><br>No Application Yet
                            </h1>
                            <?php } else { ?>
                            <div class="row">
                                <div class="col-lg">
                                    <?php foreach ($blessing as $data) { ?>
                                    <div class="card mt-4">
                                        <div class="card-body p-0 table-responsive ">
                                            <div style="display: flex; justify-content: space-between;">
                                                <h4 class="p-3 mb-0"><?php echo $data['reference_id']; ?></h4>
                                                <h5 class="text-primary p-3 mb-0">
                                                    <?php echo $status[$data['status_id'][0]]; ?></h5>

                                            </div>
                                            <table class="table mb-0 text-center">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">place</th>
                                                        <th scope="col">Contact Number</th>
                                                        <th scope="col">Complete Address</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="border-top: none;
                                        border-bottom: none;">
                                                        <td>
                                                            <?php echo $data['owner_name']; ?><br><br><br></td>
                                                        <td>
                                                            <?php echo $data['place']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['contact_number']; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php echo $data['complete_address']; ?><br><br><br>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>

                                            <div style="display: flex; justify-content: space-between;">
                                                <div class="text-left p-3">
                                                    <span class="text-muted">Date Applied:</span>
                                                    <span
                                                        class="badge badge-success"><?php echo date('M d, Y g:ia', strtotime($data['date_added'])); ?></span><br>

                                                </div>

                                                <a href="view_services_blessing.php?reference_id=<?php echo $data['reference_id']; ?>"
                                                    class="btn btn-primary btn-sm h-25 m-3">View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

<?php include 'footer.php';?>
<style>
/* PROCESS STEPS */
/* @import url('https://fonts.googleapis.com/css?family=Muli&display=swap'); */

:root {
    --line-border-fill: #3FB07C;
    --line-border-empty: #bdbdbd;
    --background-fill: #57DB9E;
}

* {
    box-sizing: border-box;
}

.process_steps {
    /* background-color: rgb(223, 255, 244); */
    font-family: 'Muli', sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 20vh;
    overflow: hidden;
    margin: 0;
}

.container_progress {
    text-align: center;
}

.progress-container {
    display: flex;
    justify-content: space-between;
    position: relative;
    max-width: 100%;
    width: 900px;
    margin-bottom: 2.5em;
}

.progress-container::before {
    content: "";
    position: absolute;
    top: 50%;
    left: 0;
    height: 10px;
    width: 100%;
    /* Changed from 350px to 100% */
    background-color: var(--line-border-empty);
    z-index: -1;
}

.progress_line {
    position: absolute;
    top: 50%;
    left: 0;
    width: 0;
    height: 10px;
    background-color: var(--line-border-fill);
    z-index: -1;
    transition: all .5s ease-in;
}


.step-text {
    color: transparent;
    /* Hide the text by default */
    position: absolute;
    bottom: -35px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 15px;
    width: 200px;
    font-weight: bold;
    transition: color 0.4s ease-in;
    /* Smooth transition when displaying the text */
}

.circle.active .step-text {
    color: #000;
    /* Display the text when the circle is active */
}

.step-date {
    color: transparent;
    /* Hide the date by default */
    position: absolute;
    bottom: -55px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 15px;
    width: 200px;
    transition: color 0.4s ease-in;
    /* Smooth transition when displaying the date */
}

.circle.active .step-date {
    color: #000;
    /* Display the date when the circle is active */
}

i.fas.fa-shopping-cart {
    font-size: 60px;
    padding: 20px;
    color: #00800096;
}

.circle {
    position: relative;
    font-size: 50px;
    color: var(--line-border-empty);
    background-color: #fff;
    height: 120px;
    width: 120px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 10px solid var(--line-border-empty);
    border-radius: 50%;
    transition: all .4s ease-in;
}

.circle.active {
    border-color: var(--line-border-fill);
    background-color: var(--background-fill);
    color: #fff;
    /* box-shadow: 0px 0px 31px -2px rgba(0, 105, 37, 0.62); */
}

.nav-tabs .nav-item.show .nav-link,
.nav-tabs .nav-link.active {
    color: white;
    background-color: green;
    border-color: #dee2e6 #dee2e6 #fff
}

.nav-tabs .nav-link {
    border-radius: 10px 10px 0px 0px;
    cursor: pointer;
    padding: 10px 20px;
    border: 1px solid #ccc;
    margin-right: 2px;
    border-bottom: none;
    background-color: #f1f1f1;
    color: #000;
}

#num-of-notif {
    position: absolute;
    background-color: #d03232;
    color: #fff;
    padding: 2px 7px;
    font-size: 10px;
    border-radius: 50%;
    margin-left: 6px;
    margin-top: -15px
}

.btn {
    padding: 0.6em 2em;
    background-color: var(--line-border-fill);
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin: 20px 20px 0;
}

.btn:active {
    transform: scale(0.98);
}

.btn:disabled {
    background-color: var(--line-border-empty);
    cursor: not-allowed;
}

.list-group-item.active {
    background: #ffc107;
}

/* end common class */


/* end top status */

ul.timeline {
    list-style-type: none;
    position: relative;
}

ul.timeline:before {
    content: ' ';
    background: #d4d9df;
    display: inline-block;
    position: absolute;
    left: 29px;
    width: 2px;
    height: 100%;
    z-index: 400;
}

ul.timeline>li {
    margin: 20px 0;
    padding-left: 30px;
}

ul.timeline>li:before {
    content: '\2713';
    background: #fff;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    border: 0;
    left: 5px;
    width: 50px;
    height: 50px;
    z-index: 400;
    text-align: center;
    line-height: 50px;
    color: #d4d9df;
    font-size: 24px;
    border: 2px solid #d4d9df;
}

ul.timeline>li.active:before {
    content: '\2713';
    background: #28a745;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    border: 0;
    left: 5px;
    width: 50px;
    height: 50px;
    z-index: 400;
    text-align: center;
    line-height: 50px;
    color: #fff;
    font-size: 30px;
    border: 2px solid #28a745;
}

/* end timeline */

.back_button {
    display: block;
    width: 120px;
    margin-top: 10px;
    margin-left: 25px;
    padding: 10px 25px 10px 25px;
    border: 2px solid rgb(246, 246, 246);
    border-radius: 30px;
    background-color: green;
    text-decoration: none;
    color: rgb(255, 255, 255);
    text-align: center;
    box-shadow: 0 3px 3px rgba(0, 0, 0, 0.3),
        inset 0 -2px 3px rgba(0, 0, 0, 0.3);
    transition: 0.5s;
}

.back_button:hover {
    background-color: rgb(255, 255, 255);
    color: green;
}
</style>

</html>