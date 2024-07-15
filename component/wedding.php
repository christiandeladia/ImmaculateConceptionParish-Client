
<?php 
    require_once "connect.php";
    $is_customer_logged_in = isset($_SESSION['auth_login']);
?>
<?php
    if ( isset($_SESSION['auth_login']) ) {
		$auth = $_SESSION['auth_login'];
        $auth_full_name = $auth['first_name'] . $auth['last_name'];
}
$result = mysqli_query($conn, "SELECT * FROM wedding ORDER BY id DESC LIMIT 1");

if (!$result) {
    die("Error in query: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .carousels {
            display: grid;
            place-items: center;
            background: #f5f5f5;
        }

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
        }

        .slider-container li {
            min-width: 24.50%;
            min-height: 300px;
            text-align: center;
            padding: 5px 5px;
        }

        .slider-container {
            overflow: hidden;
            width: 90%;
        }

        .responsives {
            padding: 0 6px;
            float: left;
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
    </style>
</head>

<body>
    <div class="carousels">
        <div class="slider-container">
            <ul class="slider-carousel" data-element="slider-carousel">
                <li>
                    <div class="responsives">
                        <div class="gallery">
                            <div class="row">
                                <div class="column1" style="background-color:#fff;">
                                    <img src="image/man.png" style="width:80%; height:auto; ">
                                    <h2><?= $row["groom_name"] ?></h2>
                                    <h3>Groom</h3>
                                    <p><?= $row["groom_age"] ?></p>
                                    <p><b>Father: </b><?= $row["groom_father_name"] ?></p>
                                    <p><b>Mother: </b><?= $row["groom_mother_name"] ?></p>
                                </div>
                                <div class="column1" style="background-color:#fff;">
                                    <img src="image/woman.png" style="width:80%; height:auto; ">
                                    <h2><?= $row["bride_name"] ?></h2>
                                    <h3>Bride</h3>
                                    <p><?= $row["bride_age"] ?></p>
                                    <p><b>Father: </b><?= $row["bride_father_name"] ?></p>
                                    <p><b>Mother: </b><?= $row["bride_mother_name"] ?></p>
                                </div>
                                <div class="column3" style="background-color:#fff;">
                                    <p><b>Place of Marriage: </b>Immaculate Conception Parish</p>
                                    <p><b>Date of Marriage: </b><?= $row["marriage_date"] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Add more li items as needed -->
            </ul>
        </div>
    </div>
</body>

<script>
    const sliderItemsContainer = document.querySelector('[data-element="slider-carousel"]');

    function moveSlider() {
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

    setInterval(moveSlider, 3000); // Adjust the interval duration
</script>

</html>
<?php
mysqli_close($conn);
?>
