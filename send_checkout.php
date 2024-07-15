
<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
$hostname="localhost";
$username="root";
$password="";
$dbname="icp_database";

$conn=mysqli_connect($hostname, $username,$password,$dbname);

if ($conn) {
    if (isset($_GET["group_order"])) {
        $group_order = $_GET["group_order"];
        $sql = mysqli_query($conn, "SELECT * FROM `orders` WHERE `group_order` = '$group_order'");
        if ($sql) {
            $product_data = array(); // Initialize an array to store product data
            $grandtotal = 0; // Initialize grandtotal


            while ($row = mysqli_fetch_assoc($sql)) {
                // Calculate total for each product
                $product_quantity = $row['product_quantity'];
                $product_price = $row['product_price'];
                $total = $product_quantity * $product_price;
                // Add total to grandtotal
                // $grandtotal = $total + $row[0]['order_shipping_fee'];?

                $product_data[] = array(
                    'product_name' => $row['product_name'],
                    'customer_id' => $row['customer_id'],
                    'product_price' => $row['product_price'],
                    'status' => $row['status'],
                    'group_order' => $row['group_order'],
                    'date_added' => $row['date_added'],
                    'product_quantity' => $row['product_quantity'],
                    'order_phonenumber' => $row['order_phonenumber'],
                    'order_username' => $row['order_username'],
                    'order_payment' => $row['order_payment'],
                    'order_shipping_fee' => $row['order_shipping_fee'],
                    'grandtotal' => $row['grandtotal'],
                    'order_address' => $row['order_address']
                );
            }

            $email = $_SESSION['auth_login']['email'];

            // Check if the email address is not empty
            if (!empty($email)) {
                $mail = new PHPMailer(true);

                // Configure SMTP settings
                $mail->isSMTP();
                $mail->Host = 'smtp.hostinger.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'immaculate@devdojo.cloud';
                $mail->Password = 'immaculateEmail$123';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                // Set email parameters
                $mail->setFrom('immaculate@devdojo.cloud');
                $mail->addAddress($email);
                $mail->isHTML(true);

                // Set email content
                $mail->Subject = '[ICP E-INVOICE] Thank You for Shopping!';
                $mail->Body = '<table style="max-width: 770px;margin:50px auto 10px;background-color:#fff;padding:50px;border-radius:3px;border-top:solid 10px green;border-left: solid 2px;border-right: solid 2px;border-bottom: solid;">
                <thead>
                    <tr>
                        <th style="text-align:left; padding-bottom: 20px;"><img style="max-width: 250px;" src="https://res.cloudinary.com/dqtbveriz/image/upload/v1711791860/logo2_bfmyws.png" alt="ICP LOGO"></th>
                        <th style="text-align:right;font-weight:900; font-size:20px;"> E-INVOICE</th>
                        
                    </tr>
                </thead>';

                $mail->Body .= 
                '<tr>
                <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
                    <p style="margin:0 0 10px 0;padding:0;font-size:14px; float:right;"><span style="display:block;font-weight:bold;font-size:13px">Purchased Date</span>' . $product_data[0]['date_added']. '</p>
                    <strong>Transaction ID: </strong> ' . $product_data[0]['group_order'] . '<br>
                    <strong>Status: </strong><b style="color:green;font-weight:normal;margin:0">Order Placed</b><br>
                    <strong>Shipping Fee: </strong> ₱' . number_format($product_data[0]['order_shipping_fee'], 2) . '<br>
                    <strong>Subtotal: </strong> ₱' . number_format($total, 2) . '<br>
                    <strong>Grand Total: ₱' . number_format($product_data[0]['grandtotal'], 2) . '</strong><br>
                </td>
                </tr>';
                foreach ($product_data as $product) {
                    $mail->Body .= '
                    <tr>
                                    <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
                                        <!-- Product details -->
                                        <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:150px">Product</span><b style="font-weight:normal;margin:0">' . $product['product_name']. '</b></p>
                                        <p style="font-size:14px;margin:0 0 0 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Order amount</span>₱ ' . $product['product_price']. '</p>
                                        <p style="font-size:14px;margin:0 0 0 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Product Quantity</span>'. $product['product_quantity']. '</p>
                                    </td>
                                </tr>';
                            }

                  $mail->Body .= '
                                <tr>
                                    <td style="height:35px;"></td>
                                </tr>
                                <tr>
                                    <td style="width:50%;padding:20px;vertical-align:top">
                                        <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px">Name</span> ' . $product['order_username'] . '</p>
                                        <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">ID No.</span>' . $product['customer_id'] . '</p>
                                    </td>
                                    <td style="width:50%;padding:20px;vertical-align:top">
                                        <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Address</span>' . $product['order_address'] . '</p>
                                        <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Order Payment</span'. $product['order_payment'] . '</p>
                                        <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Phone Number</span>'. $product['order_phonenumber'] . '</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table> (The application has been submitted successfully, kindly wait for the approvals through email!)';
                // Send email
                if ($mail->send()) {
                    echo "
                    <script>
            
                    document.location.href = 'orders.php';
                    </script>
                    ";
                } else {
                    echo "Error: " . $mail->ErrorInfo;
                }
            } else {
                echo "Error: Email address is empty.";
            }
        } else {
            echo "Error: Unable to fetch email address.";
        }
    } else {
        echo "Error: ID parameter not set.";
    }
} else {
    echo "Error: Database connection failed.";
}

mysqli_close($conn);
?>