<?php
require "../connect.php";
if (!isset($_SESSION['auth_login'])) {
    header("location: login.php");
    exit;
}

if (!isset($_GET['order_id'])) {
    header("location: orders.php");
    exit;
}

$auth = $_SESSION['auth_login'];
$auth_id = $auth['id'];
$order_id = $_GET['order_id'];

// Retrieve orders for the specified order_id
$sql = "SELECT * FROM `orders` WHERE `customer_id` = ? AND `group_order` = ? ORDER BY date_added DESC;";
$stmt = $pdo->prepare($sql);
$stmt->execute([$auth_id, $order_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count the total number of orders
$totalOrders = count($orders);

// Fetch additional details if needed, such as order total, customer details, etc.

?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" />
    <title>View Orders - ICP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <style>
    /* PROCESS STEPS */
    @import url('https://fonts.googleapis.com/css?family=Muli&display=swap');

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

    .btn {
        padding: 1em 3em;
        background-color: var(--line-border-fill);
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin: .6em;
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
    </style>
</head>

<body>
<a class="btn btn-info btn-sm m-3" href="orders.php">Back to Orders</a>
    <section class="my-5">
        <div class="container">
            <div class="main-body">

                <button class="btn" id="prev" disabled>Prev</button>
                <button class="btn" id="next">Next</button>

                <!-- ORDER PROGRESS -->
                <div class="row">
                    <div class="col-lg">
                        <div class="card bg-transparent mb-5">
                            <div class="card-body">
                                <div class="top-status">
                                    <div style="display: flex; justify-content: space-between;">
                                        <h5 style="margin: 0;">ORDER ID: <?php echo $order_id; ?></h5>
                                        <h5 id="tracking_number" style="margin: 0; text-align: right; display: none;">J&T Tracking No. : #000000000000</h5>
                                    </div>
                                    <div class="process_steps">
                                        <div class="container_progress">
                                            <div class="progress-container">
                                                <div class="progress_line"></div>
                                                <div class="circle active"><i class="fas fa-box"></i>
                                                    <span class="step-date"> <td><?php echo date('M d, Y g:ia', strtotime( $orders[0]['date_added'])); ?></td></span>
                                                    <span class="step-text">Order Place</span>
                                                </div>
                                                <div class="circle"><i class="fas fa-truck"></i>
                                                    <span class="step-date">Apr ##, 2024 #:####</span>
                                                    <span class="step-text">Order Shipped Out</span>
                                                </div>
                                                <div class="circle"><i class="fas fa-box-open"></i>
                                                    <span class="step-date">Apr ##, 2024 #:####</span>
                                                    <span class="step-text">Order Received</span>
                                                </div>
                                                <div class="circle"><i class="fas fa-check-circle"></i>
                                                    <span class="step-date">Apr ##, 2024 #:####</span>
                                                    <span class="step-text">Order Completed</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <!-- CLIENT INFO -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4>Delivery Address</h4>
                                <hr>
                                <div class="d-flex flex-column align-items-left text-left">

                                    <div class="mt-3">
                                        <h5><strong
                                                class="text-secondary mb-1"><?php echo $orders[0]['order_username']; ?></strong>
                                        </h5>
                                        <p class="text-secondary mb-0"><?php echo $orders[0]['order_phonenumber']; ?>
                                        </p>
                                        <p class="text-secondary mb-0"><?php echo $orders[0]['order_address']; ?></p>
                                        <hr>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PRODUCT DESCRIPTION -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body p-0 table-responsive">
                                <h4 class="p-3 mb-0">Product Description</h4>
                                <table class="table mb-0 text-right">
                                    <thead>
                                        <tr>
                                            <th scope="col">Description</th>
                                            <th scope="col"></th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total = 0;
                                        foreach ($orders as $row) { 
                                        $product_quantity = $row['product_quantity'];
                                        $product_price = $row['product_price'];
                                        $subtotal = $product_quantity * $product_price;
                                        $total += $subtotal;
                                        ?>
                                        <tr>
                                            <th>
                                                <img src="../image/<?php echo $row['product_image']; ?>" alt="product"
                                                    class="" width="80">
                                            </th>
                                            <td><?php echo $row['product_name']; ?></td>
                                            <td>₱<?php echo number_format($row['product_price'], 2); ?></td>
                                            <td><?php echo $row['product_quantity']; ?></td>
                                            <td>₱ <?php echo number_format($subtotal, 2); ?></td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <th colspan="2">
                                                <span>Payment Method:</span>
                                                <span
                                                    class="badge badge-success"><?php echo $orders[0]['order_payment']; ?></span>
                                            </th>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <span class="text-muted">Order Total</span>
                                                <strong>₱<?php echo number_format($total, 2); ?></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- TIMELINE -->
                        <div class="card mt-4">
                            <div class="card-body">
                                <h4>Timeline</h4>
                                <ul class="timeline">
                                    <li class="active">
                                        <h6>ORDER PLACED</h6>
                                        <p class="mb-0 text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing
                                            elit. Quisque Lorem ipsum dolor</p>
                                        <o class="text-muted"><?php echo date('M d, Y g:ia', strtotime( $orders[0]['date_added'])); ?></p>
                                    </li>
                                    <li>
                                        <h6>ORDER SHIPPED OUT</h6>
                                        <p class="mb-0 text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing
                                            elit. Quisque</p>
                                        <o class="text-muted">Apr ##, 2024 #:####</p>
                                    </li>
                                    <li>
                                        <h6>ORDER RECEIVED</h6>
                                        <p class="mb-0 text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing
                                            elit. Quisque</p>
                                        <o class="text-muted">Apr ##, 2024 #:####</p>
                                    </li>
                                    <li>
                                        <h6>ORDER COMPLETED</h6>
                                        <p class="mb-0 text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing
                                            elit. Quisque</p>
                                        <o class="text-muted">Apr ##, 2024 #:####</p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script>
    const next = document.querySelector("#next");
    const prev = document.querySelector("#prev");
    const progress = document.querySelector(".progress_line");
    const circles = document.querySelectorAll(".circle");
    const totalSteps = circles.length;
    let currentStep = 1;

    next.addEventListener("click", () => {
        if (currentStep < totalSteps) {
            currentStep++;
            updateProgress();
        }
    });

    prev.addEventListener("click", () => {
        if (currentStep > 1) {
            currentStep--;
            updateProgress();
        }
    });

    function updateProgress() {
        circles.forEach((circle, index) => {
            if (index < currentStep) {
                circle.classList.add("active");
            } else {
                circle.classList.remove("active");
            }
        });

        if (currentStep === 1) {
            prev.disabled = true;
        } else if (currentStep === totalSteps) {
            next.disabled = true;
        } else {
            prev.disabled = false;
            next.disabled = false;
        }

        const progressWidth = ((currentStep - 1) / (totalSteps - 1)) * 100 + '%';
        progress.style.width = progressWidth;

        // Get the tracking number element
        var trackingNumber = document.getElementById('tracking_number');

        // Update tracking number only if the "Order Shipped Out" step is active
        if (currentStep === 1) {
            trackingNumber.style.display = 'none';
        } else {
            trackingNumber.style.display = 'block';
            trackingNumber.textContent = 'J&T Tracking No. : #000000000000';
        }
    }
</script>
</body>

</html>