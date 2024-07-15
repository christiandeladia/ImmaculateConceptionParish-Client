<?php
require "connect.php";
if (!isset($_SESSION['auth_login'])) {
    header("location: customer/login.php");
    exit;
}

if (isset($_GET['blog_id'])) {
    $blog_id = mysqli_real_escape_string($conn, $_GET['blog_id']);
    
    // Execute the query to fetch data using mysqli_query
    $query = "SELECT * FROM blog WHERE blog_id = '$blog_id'";
    $result = mysqli_query($conn, $query);
    
    // Fetch the data as an associative array
    if ($result && mysqli_num_rows($result) > 0) {
        $item = mysqli_fetch_assoc($result);
        $formatted_date = date("F j, Y", strtotime($item['date']));
    } else {
        echo "Blog post not found.";
        exit;
    }
} else {
    echo "Blog ID not provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOG - ICP</title>
</head>
<style>
html,
body {
    margin: 0;
    padding: 0;
    height: 100%;
}

body {
    background: rgba(0, 0, 0, 0.08);
}

article {
    width: 60%;
    padding: 25px;
    margin: 0 auto;
    box-sizing: border-box;
    box-shadow: 0 0 5px 2px rgba(0, 0, 0, 0.2);
    background: #fff;

    figure {
        margin: 25px 0;
    }

    figcaption {
        text-align: center;
        font: italic 16px/20px Georgia, serif;
        color: #000;
    }

    figure img {
        width: 80%;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    h1 {
        font: normal 42px/50px "Bree Serif", serif;
        margin: 10px 0 35px;
    }

    h2 {
        font: normal 30px/40px "Bree Serif", serif;
        margin: 25px 0 0;
    }

    h5 {
        font: normal 15px/20px "Bree Serif", serif;
        margin: 0;
        color: #777;
    }

    h1+h5 {
        margin: -35px 0 35px;
    }

    p {
        margin: 10px 0;
        font: normal 18px/24px Georgia, serif;
        color: #111;
    }

    i {
        color: #555;
    }

    a {
        color: #2a75ed;
    }
}

@media (min-width: 768px) {
    article {
        margin: 50px auto;
    }
}
</style>
<?php include 'nav.php';?>

<body>
    <article>
        <h1><?php echo $item['title']; ?></h1>
        <h5><?php echo $formatted_date; ?></h5>
        <figure>
            <img src="<?php echo $item['image']; ?>" alt="header">
        </figure>
        <h2><?php echo $item['title']; ?></h2>
        <p><?php echo $item['content']; ?></p>
        
    </article>
</body>
<?php include 'footer.php';?>

</html>