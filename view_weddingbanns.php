<?php 
    require_once "connect.php";
    $is_customer_logged_in = isset($_SESSION['auth_login']);

    $wedding_banns_query = "SELECT * FROM wedding_banns WHERE status = 'ongoing' ORDER BY id"; 
    $wedding_banns_result = mysqli_query($conn, $wedding_banns_query);

    if (!$wedding_banns_result) {
        echo "Error fetching wedding_banns data: " . mysqli_error($conn);
        exit; // Exit if there's an error
    }

    // Initialize an empty array to store wedding_banns data
    $wedding_banns = [];

    // Fetch each row and format the data
    while ($item = mysqli_fetch_assoc($wedding_banns_result)) {
        $formatted_date = date("F j, Y", strtotime($item['date_marriage']));

        // Add formatted date and short content to each item
        $item['formatted_date'] = $formatted_date;
        // Add the formatted item to the $wedding_banns array
        $wedding_banns[] = $item;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/weddingbanns.css">
</head>

<style>
.no-weddings-container {
    text-align: center;
    margin-top: 20%;
}

.no-weddings-container h1 {
    font-size: 20px;
    color: #a9a2a2;
    padding-bottom: 20px;
}

.no-weddings-container i {
    font-size: 70px;
    color: #035d138f;
    padding-bottom: 20px;
}


li {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.slider-carousel {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
}

.slider-container {
    overflow: hidden;

    margin: 0 auto;
    /* Center the container horizontally */
    display: flex;
    flex-wrap: wrap;
    /* Enable wrapping */
    justify-content: center;
    /* Center items horizontally */
}

.slider-container ul {
    width: 90%;
}

.slider-container li {
    width: calc(24.50% - 10px);
    /* Minus gap to prevent overflow */
    min-height: 300px;
    text-align: center;
    padding: 5px;
}

.responsives {
    flex: 1 1 auto;
    /* Allow item to grow and shrink */
}

.carousel-buttons {
    display: flex;
    justify-content: center;
    margin-top: 10px;
}

.carousel-buttons button {
    background: #035d13;
    color: #fff;
    border: none;
    padding: 10px 20px;
    margin: 0 10px;
    cursor: pointer;
}

.wedbanns_container {
    width: 90%;
    background-color: #FFF;
    margin: 0 auto;
    border-radius: 15px;
    padding: 30px 0;
}

@media (max-width: 768px) {
    .slider-container li {
        min-width: calc(50% - 10px);
        /* Two items per row on smaller screens */
    }
}
</style>

<?php include 'nav.php';?>

<body>
    <br><br>
    <div class="wedbanns_container">
        <br>
        <h1 style="text-align:center;">Mga Ikakasal sa Parokya ng Pandi</h1>
        <div class="slider-container">
            <ul class="slider-carousel" data-element="slider-carousel">

                <?php 
$found_wedding = false;
foreach ($wedding_banns as $item) {
    if ($item['place_marriage'] === "Immaculate Conception Parish Pandi") {
        $found_wedding = true;
?>
                <li>
                    <div class="responsives">
                        <div class="gallery">
                            <div class="row">
                                <div class="column1" style="background-color:#fff;">
                                    <img src="<?php echo $item['id_picture_groom']; ?>"
                                        style="width:80px; height:80px;">
                                    <h2><?php echo $item['groom_name']; ?></h2>
                                    <h3><b>Groom</b></h3>
                                    <p><?php echo $item['groom_age']; ?></p>
                                    <p><b>Father: </b><br><?php echo $item['groom_father_name']; ?></p>
                                    <p><b>Mother: </b><br><?php echo $item['groom_mother_name']; ?></p>
                                </div>
                                <div class="column1" style="background-color:#fff;">
                                    <img src="<?php echo $item['id_picture_bride']; ?>"
                                        style="width:80px; height:80px;">
                                    <h2><?php echo $item['bride_name']; ?></h2>
                                    <h3><b>Bride</b></h3>
                                    <p><?php echo $item['bride_age']; ?></p>
                                    <p><b>Father: </b><br><?php echo $item['bride_father_name']; ?></p>
                                    <p><b>Mother: </b><br><?php echo $item['bride_mother_name']; ?></p>
                                </div>
                                <div class="column3" style="background-color:#fff;">
                                    <p><b>Place of Marriage: </b><br><?php echo $item['place_marriage']; ?></p>
                                    <p><b>Date of Marriage: </b><br><?php echo $item['formatted_date']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <?php 
    }
} 

if (!$found_wedding) { ?>
                <li>
                    <div class="no-weddings-container">
                        <h1
                            style="text-align: center; margin: 20% auto; font-size: 20px; color: #a9a2a2; padding-bottom: 20px;">
                            <i class="fa fa-male" style="font-size:70px; color: #035d138f; padding-bottom: 20px;"></i>
                            <i class="fa fa-female" style="font-size:70px; color: #035d138f;"></i><br>No Posts Yet
                        </h1>
                    </div>
                </li>
                <?php } ?>


            </ul>

        </div>
    </div>
    <br>
    <br>
    <br>
    <div class="wedbanns_container">
        <br>
        <h1 style="text-align:center;">Mga Ikakasal sa ibang Parokya</h1>
        <div class="slider-container">
            <ul class="slider-carousel" data-element="slider-carousel">
                <?php 
                $found_wedding = false;
                foreach ($wedding_banns as $item) {
                    if ($item['place_marriage'] != "Immaculate Conception Parish Pandi") {
                        $found_wedding = true;
                ?>
                <li>
                    <div class="responsives">
                        <div class="gallery">
                            <div class="row">
                                <div class="column1" style="background-color:#fff;">
                                    <img src="<?php echo $item['id_picture_groom']; ?>"
                                        style="width:80px; height:80px;">
                                    <h2><?php echo $item['groom_name']; ?></h2>
                                    <h3><b>Groom</b></h3>
                                    <p><?php echo $item['groom_age']; ?></p>
                                    <p><b>Father: </b><br><?php echo $item['groom_father_name']; ?></p>
                                    <p><b>Mother: </b><br><?php echo $item['groom_mother_name']; ?></p>
                                </div>
                                <div class="column1" style="background-color:#fff;">
                                    <img src="<?php echo $item['id_picture_bride']; ?>"
                                        style="width:80px; height:80px;">
                                    <h2><?php echo $item['bride_name']; ?></h2>
                                    <h3><b>Bride</b></h3>
                                    <p><?php echo $item['bride_age']; ?></p>
                                    <p><b>Father: </b><br><?php echo $item['bride_father_name']; ?></p>
                                    <p><b>Mother: </b><br><?php echo $item['bride_mother_name']; ?></p>
                                </div>
                                <div class="column3" style="background-color:#fff;">
                                    <p><b>Place of Marriage: </b><br>Immaculate Conception Parish Pandi</p>
                                    <p><b>Date of Marriage: </b><br><?php echo $item['formatted_date']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <?php 
                    }
                } 

                if (!$found_wedding) { ?>
                <li>
                    <div class="no-weddings-container">
                        <h1
                            style="text-align: center; margin: 20% auto; font-size: 20px; color: #a9a2a2; padding-bottom: 20px;">
                            <i class="fa fa-male" style="font-size:70px; color: #035d138f; padding-bottom: 20px;"></i>
                            <i class="fa fa-female" style="font-size:70px; color: #035d138f;"></i><br>No Posts Yet
                        </h1>
                    </div>
                </li>
                <?php } ?>


            </ul>

        </div>
    </div>
</body>
<?php include 'footer.php';?>

</html>