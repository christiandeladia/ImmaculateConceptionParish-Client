<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/weddingbanns.css">
</head>
<style>
    .carousels {
        background: #f5f5f5;
        <?php
            // Check the count of wedding banns
            $count = $result->num_rows;
            if ($count <= 3 || $count == 0) {
                echo "display: grid;";
                echo "place-items: center;";
            }
        ?>
    }

    .no-weddings-container {
        text-align: center; /* Center the text */
    }

    <?php
        // Disable slider carousel function if count is less than or equal to 3 or zero
        if ($count <= 3 || $count == 0) {
            echo ".slider-container ul {";
            echo "    pointer-events: none;";
            echo "    justify-content: center;";
            echo "}";
        }
    ?>

    .slider-container ul,
    li {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .slider-carousel {
        display: flex;
        flex: none;
        column-gap: 10px;
        transition: transform 0.9s ease;
        /* Adjust transition duration and timing function for smoothness */
    }

    .slider-container li {
        min-width: 24.50%;
        min-height: 300px;
        text-align: center;
        padding: 5px 5px;
        /* background: rgba(255, 0, 255, 0.3) */
    }

    .slider-container {
        overflow: hidden;
        /* width: 90%; */
        /* background: rgba(0, 255, 255, 0.1); */
    }

    .responsives {
        padding: 0 6px;
        /* float: left; */
        min-width: 24.50%;
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
    @media only screen and (max-width: 320px) {
        .no-weddings-container h1 {
            font-size: 20px !important;
        }
        .picture {
            width: 60px !important;
            height: 60px !important;
        }
        .h2, h2 {
            font-size: .5rem;
            font-weight: bold;
        }
        .column1 p {
            font-size: 8px;
        }
        .column1 {
            height: 230px !important;
        }
    }
</style>

<body>
    <div class="carousels">
        <div class="slider-container">
            <ul class="slider-carousel" data-element="slider-carousel">
                <?php
                // Connect to MySQL database
                $DB_HOST = 'localhost';
                $DB_USER = 'root';
                $DB_PASS = '';
                $DB_NAME = 'icp_database';

                

                $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // $sql = "SELECT * FROM wedding_banns";
                $sql = "SELECT * FROM wedding_banns WHERE status = 'ongoing'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<li>';
                        echo '<div class="responsives">';
                        echo '<div class="gallery">';
                        echo '<div class="row">';
                        echo '<div class="column1" style="background-color:#fff;">';
                        echo '<img src="' . $row['id_picture_groom'] . '" class="picture" style="width:80px; height:80px;">';
                        echo '<h2>' . $row['groom_name'] . '</h2>';
                        echo '<h3><b>Groom</b></h3>';
                        echo '<p>' . $row['groom_age'] . '</p>';
                        echo '<p><b>Father: </b><br>' . $row['groom_father_name'] . '</p>';
                        echo '<p><b>Mother: </b><br>' . $row['groom_mother_name'] . '</p>';
                        echo '</div>';
                        echo '<div class="column1" style="background-color:#fff;">';
                        echo '<img src="' . $row['id_picture_bride'] . '" class="picture" style="width:80px; height:80px;">';
                        echo '<h2>' . $row['bride_name'] . '</h2>';
                        echo '<h3>Bride</h3>';
                        echo '<p>' . $row['bride_age'] . '</p>';
                        echo '<p><b>Father: </b><br>' . $row['bride_father_name'] . '</p>';
                        echo '<p><b>Mother: </b><br>' . $row['bride_mother_name'] . '</p>';
                        echo '</div>';
                        echo '<div class="column3" style="background-color:#fff;">';
                        echo '<p><b>Place of Marriage: </b><br>' . $row['place_marriage'] . '</p>';
                        echo '<p><b>Date of Marriage: </b><br>' . date("F j, Y", strtotime($row['date_marriage'])) . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</li>';
                        $additional_sql = "SELECT 'status' FROM wedding_banns WHERE reference_id = " . $row['id'];
                        $additional_result = $conn->query($additional_sql);
                        if ($additional_result->num_rows > 0) {
                            while ($additional_row = $additional_result->fetch_assoc()) {
                                echo '<li>';
                                echo '<div class="responsives">';
                                echo '<div class="gallery">';
                                echo '<div class="row">';
                                echo '<div class="column1" style="background-color:#fff;">';
                                echo '<img src="' . $row['id_picture_groom'] . '" class="picture" style="width:40; height:auto;">';
                                echo '<h2>' . $row['groom_name'] . '</h2>';
                                echo '<h3>Groom</h3>';
                                echo '<p>' . $row['groom_age'] . '</p>';
                                echo '<p><b>Father: </b>' . $row['groom_father_name'] . '</p>';
                                echo '<p><b>Mother: </b>' . $row['groom_mother_name'] . '</p>';
                                echo '</div>';
                                echo '<div class="column1" style="background-color:#fff;">';
                                echo '<img src="' . $row['id_picture_bride'] . '" class="picture" style="width:40; height:auto;">';
                                echo '<h2>' . $row['bride_name'] . '</h2>';
                                echo '<h3>Bride</h3>';
                                echo '<p>' . $row['bride_age'] . '</p>';
                                echo '<p><b>Father: </b>' . $row['bride_father_name'] . '</p>';
                                echo '<p><b>Mother: </b>' . $row['bride_mother_name'] . '</p>';
                                echo '</div>';
                                echo '<div class="column3" style="background-color:#fff;">';
                                echo '<p><b>Place of Marriage: </b>Immaculate Conception Parish Pandi</p>';
                                echo '<p><b>Date of Marriage: </b>' . $row['date_marriage'] . '</p>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</li>';
                            }
                        }
                    }
                } else {
                    echo '<div style="margin: 100px 0;">';
                    echo '<h1';
                    echo 'style="text-align: center; margin: 20% auto; font-size: 50px; color: #a9a2a2; padding-bottom: 20px; padding: 30px;">';
                    echo '<i class="fa fa-male" style="font-size:90px; color: #035d138f; padding-bottom: 20px;"></i>';
                    echo '<i class="fa fa-female" style="font-size:90px; color: #035d138f;"></i><br>No Posts Yet';
                    echo '</h1>';
                    echo '</div>';
                }
                
                // Close connection
                $conn->close();
                ?>
            </ul>
            
        </div>
    </div>
</body>


<script>
    const sliderItemsContainer = document.querySelector('[data-element="slider-carousel"]');
let itemCount = sliderItemsContainer.children.length;

function moveSlider() {
    // Check if the count is less than 3
    if (itemCount < 5) {
        // Disable the slider
        return;
    }

    const firstItem = sliderItemsContainer.children[0];
    const itemWidth = firstItem.offsetWidth + 10; // Include column-gap

    sliderItemsContainer.style.transition = "transform 0.5s ease"; // Adjust the transition duration
    sliderItemsContainer.style.transform = `translateX(-${itemWidth}px)`;

    // After the transition, reset the styles and move the first item to the end
    setTimeout(() => {
        sliderItemsContainer.style.transition = "none";
        sliderItemsContainer.style.transform = "translateX(0)";
        sliderItemsContainer.appendChild(firstItem);
    }, 500); // Should match the transition duration
}

setInterval(moveSlider, 3000); // Example interval for slider movement

</script>

</html>