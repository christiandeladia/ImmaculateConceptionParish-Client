<?php 
    require_once "connect.php";
    $is_customer_logged_in = isset($_SESSION['auth_login']);

    $blog_query = "SELECT * FROM blog WHERE status = 'active' ORDER BY date"; 
    $blog_result = mysqli_query($conn, $blog_query);

    if (!$blog_result) {
        echo "Error fetching blog data: " . mysqli_error($conn);
        exit; // Exit if there's an error
    }

    // Initialize an empty array to store blog data
    $blog = [];

    // Fetch each row and format the data
    while ($item = mysqli_fetch_assoc($blog_result)) {
        $formatted_date = date("F j, Y", strtotime($item['date']));

        // Limit content to 30 words
        $content_words = explode(" ", $item['content']);
        $content_short = implode(" ", array_slice($content_words, 0, 20));
        // Add ellipsis if content exceeds 30 words
        if (count($content_words) > 20) {
            $content_short .= '...';
        }
        $short_content = $content_short;

        // Add formatted date and short content to each item
        $item['formatted_date'] = $formatted_date;
        $item['short_content'] = $short_content;

        // Add the formatted item to the $blog array
        $blog[] = $item;
    }
?>



<!DOCTYPE html>
<html>

<head>
    <title>ABOUT - ICP </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/about.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php include 'nav.php';?>

<!-- image gallery style -->
<style>
@import url("https://fonts.googleapis.com/css2?family=Give+You+Glory&display=swap");

.image_gallery {
    height: 100%;
    width: 100%;
    padding: 0;
    margin: 0;
    font-family: "Give You Glory", cursive;
    background: #222;
    color: whitesmoke;
}

.wrapper {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    padding: 10rem 0;
}

.text {
    order: -1;
    flex-basis: 40rem;
    font-size: 10rem;
    text-align: center;
    line-height: 8rem;
    padding-right: 5rem;
    color: #32CD32;
}

.images {
    position: relative;
    flex-basis: 95rem;
}

.images img {
    position: relative;
    width: 30.75rem;
    height: 24.5rem;
    border: 1px solid #111;
    filter: grayscale(100%);
    opacity: 0.5;
    transition: 0.4s ease;
}

.images img:hover {
    cursor: pointer;
    filter: grayscale(0%);
    opacity: 1;
}

.images img.zoom {
    transform: scale(1.2);
    filter: grayscale(0%);
    border: 1px solid transparent;
    z-index: 99;
}
</style>


<!-- TIMELINE -->
<style>
@import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro);

*,
*::after,
*::before {
    box-sizing: border-box;
}

html {
    font-size: 62.5%;
}


a {
    color: #7b9d6f;
    text-decoration: none;
}

/* -------------------------------- 

Main Components 

-------------------------------- */
.cd-horizontal-timeline {
    opacity: 0;
    margin: 2em auto;
    -webkit-transition: opacity 0.2s;
    -moz-transition: opacity 0.2s;
    transition: opacity 0.2s;
}

.cd-horizontal-timeline::before {
    content: 'mobile';
    display: none;
}

.cd-horizontal-timeline.loaded {
    opacity: 1;
}

.cd-horizontal-timeline .timeline {
    position: relative;
    height: 100px;
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
}

.cd-horizontal-timeline .events-wrapper {
    position: relative;
    height: 100%;
    margin: 0 40px;
    overflow: hidden;
}

.cd-horizontal-timeline .events-wrapper::after,
.cd-horizontal-timeline .events-wrapper::before {
    content: '';
    position: absolute;
    z-index: 2;
    top: 0;
    height: 100%;
    width: 20px;
}

.cd-horizontal-timeline .events {
    /* this is the grey line/timeline */
    position: absolute;
    z-index: 1;
    left: 0;
    top: 49px;
    height: 2px;
    /* width will be set using JavaScript */
    background: #dfdfdf;
    -webkit-transition: -webkit-transform 0.4s;
    -moz-transition: -moz-transform 0.4s;
    transition: transform 0.4s;
}

.cd-horizontal-timeline .filling-line {
    /* this is used to create the green line filling the timeline */
    position: absolute;
    z-index: 1;
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
    background-color: #7b9d6f;
    -webkit-transform: scaleX(0);
    -moz-transform: scaleX(0);
    -ms-transform: scaleX(0);
    -o-transform: scaleX(0);
    transform: scaleX(0);
    -webkit-transform-origin: left center;
    -moz-transform-origin: left center;
    -ms-transform-origin: left center;
    -o-transform-origin: left center;
    transform-origin: left center;
    -webkit-transition: -webkit-transform 0.3s;
    -moz-transition: -moz-transform 0.3s;
    transition: transform 0.3s;
}

.cd-horizontal-timeline .events a {
    position: absolute;
    bottom: 0;
    z-index: 2;
    text-align: center;
    font-size: 1.3rem;
    padding-bottom: 15px;
    color: #383838;
    /* fix bug on Safari - text flickering while timeline translates */
    -webkit-transform: translateZ(0);
    -moz-transform: translateZ(0);
    -ms-transform: translateZ(0);
    -o-transform: translateZ(0);
    transform: translateZ(0);
}

.cd-horizontal-timeline .events a::after {
    /* this is used to create the event spot */
    content: '';
    position: absolute;
    left: 50%;
    right: auto;
    -webkit-transform: translateX(-50%);
    -moz-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    -o-transform: translateX(-50%);
    transform: translateX(-50%);
    bottom: -5px;
    height: 12px;
    width: 12px;
    border-radius: 50%;
    border: 2px solid #dfdfdf;
    background-color: #f8f8f8;
    -webkit-transition: background-color 0.3s, border-color 0.3s;
    -moz-transition: background-color 0.3s, border-color 0.3s;
    transition: background-color 0.3s, border-color 0.3s;
}

.no-touch .cd-horizontal-timeline .events a:hover::after {
    background-color: #7b9d6f;
    border-color: #7b9d6f;
}

.cd-horizontal-timeline .events a.selected {
    pointer-events: none;
}

.cd-horizontal-timeline .events a.selected::after {
    background-color: #7b9d6f;
    border-color: #7b9d6f;
}

.cd-horizontal-timeline .events a.older-event::after {
    border-color: #7b9d6f;
}

@media only screen and (min-width: 1100px) {
    .cd-horizontal-timeline {
        margin: 6em auto auto auto;
    }

    .cd-horizontal-timeline::before {
        /* never visible - this is used in jQuery to check the current MQ */
        content: 'desktop';
    }
}

.cd-timeline-navigation a {
    /* these are the left/right arrows to navigate the timeline */
    position: absolute;
    z-index: 1;
    top: 50%;
    bottom: auto;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    height: 34px;
    width: 34px;
    border-radius: 50%;
    border: 2px solid #dfdfdf;
    /* replace text with an icon */
    overflow: hidden;
    color: transparent;
    text-indent: 100%;
    white-space: nowrap;
    -webkit-transition: border-color 0.3s;
    -moz-transition: border-color 0.3s;
    transition: border-color 0.3s;
}

.cd-timeline-navigation a::after {
    /* arrow icon */
    content: '';
    position: absolute;
    height: 16px;
    width: 16px;
    left: 50%;
    top: 50%;
    bottom: auto;
    right: auto;
    -webkit-transform: translateX(-50%) translateY(-50%);
    -moz-transform: translateX(-50%) translateY(-50%);
    -ms-transform: translateX(-50%) translateY(-50%);
    -o-transform: translateX(-50%) translateY(-50%);
    transform: translateX(-50%) translateY(-50%);
    background: url(../img/cd-arrow.svg) no-repeat 0 0;
}

.cd-timeline-navigation a.prev {
    left: 0;
    -webkit-transform: translateY(-50%) rotate(180deg);
    -moz-transform: translateY(-50%) rotate(180deg);
    -ms-transform: translateY(-50%) rotate(180deg);
    -o-transform: translateY(-50%) rotate(180deg);
    transform: translateY(-50%) rotate(180deg);
}

.cd-timeline-navigation a.next {
    right: 0;
}

.no-touch .cd-timeline-navigation a:hover {
    border-color: #7b9d6f;
}

.cd-timeline-navigation a.inactive {
    cursor: not-allowed;
}

.cd-timeline-navigation a.inactive::after {
    background-position: 0 -16px;
}

.no-touch .cd-timeline-navigation a.inactive:hover {
    border-color: #dfdfdf;
}

.cd-horizontal-timeline .events-content {
    position: relative;
    width: 100%;
    margin: 2em 0;
    overflow: hidden;
    -webkit-transition: height 0.4s;
    -moz-transition: height 0.4s;
    transition: height 0.4s;
}

.cd-horizontal-timeline .events-content li {
    position: absolute;
    z-index: 1;
    width: 100%;
    left: 0;
    top: 0;
    -webkit-transform: translateX(-100%);
    -moz-transform: translateX(-100%);
    -ms-transform: translateX(-100%);
    -o-transform: translateX(-100%);
    transform: translateX(-100%);
    padding: 0 5%;
    opacity: 0;
    -webkit-animation-duration: 0.4s;
    -moz-animation-duration: 0.4s;
    animation-duration: 0.4s;
    -webkit-animation-timing-function: ease-in-out;
    -moz-animation-timing-function: ease-in-out;
    animation-timing-function: ease-in-out;
}

.cd-horizontal-timeline .events-content li.selected {
    /* visible event content */
    position: relative;
    z-index: 2;
    opacity: 1;
    -webkit-transform: translateX(0);
    -moz-transform: translateX(0);
    -ms-transform: translateX(0);
    -o-transform: translateX(0);
    transform: translateX(0);
}

.cd-horizontal-timeline .events-content li.enter-right,
.cd-horizontal-timeline .events-content li.leave-right {
    -webkit-animation-name: cd-enter-right;
    -moz-animation-name: cd-enter-right;
    animation-name: cd-enter-right;
}

.cd-horizontal-timeline .events-content li.enter-left,
.cd-horizontal-timeline .events-content li.leave-left {
    -webkit-animation-name: cd-enter-left;
    -moz-animation-name: cd-enter-left;
    animation-name: cd-enter-left;
}

.cd-horizontal-timeline .events-content li.leave-right,
.cd-horizontal-timeline .events-content li.leave-left {
    -webkit-animation-direction: reverse;
    -moz-animation-direction: reverse;
    animation-direction: reverse;
}

.cd-horizontal-timeline .events-content li>* {
    max-width: 800px;
    margin: 0 auto;
}

.cd-horizontal-timeline .events-content h2 {
    font-weight: bold;
    font-size: 2.6rem;
    font-family: "Playfair Display", serif;
    font-weight: 700;
    line-height: 1.2;
    color: #7b9d6f;
}

.cd-horizontal-timeline .events-content em {
    display: block;
    font-style: italic;
    margin: 10px auto;
    font-weight: bold;
}

.cd-horizontal-timeline .events-content em::before {
    content: '- ';
}

.cd-horizontal-timeline .events-content p {
    font-size: 1.4rem;
    min-height: 300px;
    /* color: #959595; */
}

.cd-horizontal-timeline .events-content em,
.cd-horizontal-timeline .events-content p {
    line-height: 1.6;
}


@-webkit-keyframes cd-enter-right {
    0% {
        opacity: 0;
        -webkit-transform: translateX(100%);
    }

    100% {
        opacity: 1;
        -webkit-transform: translateX(0%);
    }
}

@-moz-keyframes cd-enter-right {
    0% {
        opacity: 0;
        -moz-transform: translateX(100%);
    }

    100% {
        opacity: 1;
        -moz-transform: translateX(0%);
    }
}

@keyframes cd-enter-right {
    0% {
        opacity: 0;
        -webkit-transform: translateX(100%);
        -moz-transform: translateX(100%);
        -ms-transform: translateX(100%);
        -o-transform: translateX(100%);
        transform: translateX(100%);
    }

    100% {
        opacity: 1;
        -webkit-transform: translateX(0%);
        -moz-transform: translateX(0%);
        -ms-transform: translateX(0%);
        -o-transform: translateX(0%);
        transform: translateX(0%);
    }
}

@-webkit-keyframes cd-enter-left {
    0% {
        opacity: 0;
        -webkit-transform: translateX(-100%);
    }

    100% {
        opacity: 1;
        -webkit-transform: translateX(0%);
    }
}

@-moz-keyframes cd-enter-left {
    0% {
        opacity: 0;
        -moz-transform: translateX(-100%);
    }

    100% {
        opacity: 1;
        -moz-transform: translateX(0%);
    }
}

@keyframes cd-enter-left {
    0% {
        opacity: 0;
        -webkit-transform: translateX(-100%);
        -moz-transform: translateX(-100%);
        -ms-transform: translateX(-100%);
        -o-transform: translateX(-100%);
        transform: translateX(-100%);
    }

    100% {
        opacity: 1;
        -webkit-transform: translateX(0%);
        -moz-transform: translateX(0%);
        -ms-transform: translateX(0%);
        -o-transform: translateX(0%);
        transform: translateX(0%);
    }
}

/* ORGANIZATION */
.caption h5 {
    color: rgb(0, 0, 0);
}

@media only screen and (max-width: 1024px){
    .portfolio .content .projects .project {
        width: auto;
    }
    .wrapper {
        display: grid;
        padding: 0;
        padding-top: 100px;
    }
    .images {
        padding-left: 50px;
    }
    .images img {
        width: 180px;
        height: 180px;
    }
    .image_gallery {
        height: 90%;
    }
    .about-myself {
        display: flex;
        justify-content: center;
        flex-direction: column;
        /* padding: 150px 0px; */
        height: 80%;
        padding-bottom: 0px;
        padding-top: 5px;
    }
    .about-myself .content p {
        font-size: 18px;
    }
    .portfolio {
        padding: 0;
    }
    .form {
        margin: 0;  
        margin-top: 20px;
    }
    .form-details {
        margin-right: 20px !important;
    }
    .form-txt {
        margin-left: 20px !important;
    }
    
    .text {
        padding-right: 0;
    }
}
@media only screen and (min-width: 768px) {
    .cd-horizontal-timeline .events-content h2 {
        font-size: 7rem;
    }

    .cd-horizontal-timeline .events-content em {
        font-size: 2rem;
    }

    .cd-horizontal-timeline .events-content p {
        font-size: 1.8rem;
    }
}
@media only screen and (max-width: 768px) {
    .cd-horizontal-timeline .events-content h2 {
        font-size: 7rem;
    }

    .cd-horizontal-timeline .events-content em {
        font-size: 2rem;
    }

    .cd-horizontal-timeline .events-content p {
        font-size: 1.8rem;
    }
    .cd-horizontal-timeline.loaded {
        height: 70% !important;
    }
    .form .form-txt {
        text-align: center;
    }
    .form .form-details {
        margin-left: 20px;
    }
    .images img {
        width: 210px;
    }
    .images {
        padding-left: 65px;
    }
    .section-showcase .container {
        display: contents !important;
        height: 700px;
        width: 100%;
    }
    .wrapper {
        display: grid;
        padding: 0;
        padding-top: 50px;
    }
    .about-myself {
        padding-top: 50px;
    }
    .portfolio {
        padding-top: 50px;
    }
    .about-myself .content p {
        width: 95%;
    }
    .section-showcase h1 {  
        text-align: center;
    }
    .section-showcase p {
        margin: 1rem !important;
    }
    .section-showcase .container .container_img {
        display: none;
    }
    .card {
        min-height: 450px !important;
    }
}
@media only screen and (max-width: 320px) {
    .form .form-txt h1 {
        font-size: 20px;
    }
    .form .form-txt strong {
        font-size: 15px;
    }
    .form .form-txt p {
        font-size: 7px;
    }
    .form .form-txt h3 {
        font-size: 20px;
    }
    .form .form-txt li {
        font-size: 12px;
    }
    .cd-horizontal-timeline.loaded h1{
        text-align: center;
    }
    .cd-horizontal-timeline .events-content {
        margin: 0;
    }
    .cd-horizontal-timeline .events-content h2 {
        font-size: 3rem;
    }
    .cd-horizontal-timeline .events-content p {
        font-size: 1rem;
        text-align: justify;
    }
    .cd-horizontal-timeline .events-content em {
        font-size: 1rem;
    }
    .cd-horizontal-timeline .timeline {
        width: 100%;
    }
    .about-myself {
        display: grid;
    }
    .wrapper {
        margin-top: 10rem;
    }
    .text {
        font-size: 3rem;
        line-height: 0;
    }
    .images {
        padding-left: 5px;
        margin-top: 10px;
    }
    .images img {
        width: 98px;
        height: 98px;
    }
    .image_gallery {
        height: 80%;
        margin-top: 15rem;
    }
    .image_gallery .wrapper .text {
        margin: 0;
    }
    .about-myself .content h2 {
        font-size: 2.5rem;
    }
    .portfolio .content h1 {
        font-size: 2.5rem;
        padding-top: 20px;
        margin: 0 0 20px 0;
    }
    .about-myself .content p {
        font-size: 1rem;
        width: 90% !important;
    }
    .about-myself {
        padding: 0px 0px;
        height: auto;
    } 
    .portfolio .content p {
        font-size: 1rem;
    }
    .portfolio .content .projects .project .project-title {
        padding: 0px 0;
    }
    .portfolio .content .projects .project .project-title h2 {
        font-size: 2rem;
    }
    .about-myself .content .aboutTitleVisible {
        margin-top: 20px;
    }
    .map-wrapper {
        padding: 20px;
    }
    .map-wrapper h1 {
        font-size: 2rem;
    }
    .card {
        width: 44%;
        min-height: 300px !important;
    }
    .thumbnail {
        margin-bottom: 0px;
    }
    .thumbnail .caption {
        padding: 0px;
    }
    .h3, h3 {
        font-size: 14px;
    }
    .immaculate {
        font-size: 20px !important;
    }   
    .horizontal-scroll {
        height: 100px !important;
    }
    .jumbotron {
        padding-top: 0px;
        padding-bottom: 10px;
        margin-bottom: 0px;
        color: inherit;
    }
}
</style>

<body>
    <section class="hero">
        <div class="content">
            <div class="header">
                <h1 style="font-size: 50px; font-weight: 700;">About</h1>
            </div>
        </div>
    </section>

    <!-- TIMELINE -->
    <section class="cd-horizontal-timeline section_timeline" style="height: 70%;">
        <h1 style="position: relative; margin: auto; width: 80%"><strong>ICP Pandi Timeline</strong></h1>
        <div class="timeline">
            <div class="events-wrapper">
                <div class="events">
                    <ol>
                        <li><a href="#0" data-date="16/01/2014" class="selected">1792</a></li>
                        <li><a href="#0" data-date="28/02/2014">1880</a></li>
                        <li><a href="#0" data-date="20/04/2014">1896</a></li>
                        <li><a href="#0" data-date="20/05/2014">1930</a></li>
                        <li><a href="#0" data-date="09/07/2014">1946</a></li>
                        <li><a href="#0" data-date="30/08/2014">1987</a></li>
                        <li><a href="#0" data-date="15/09/2014">2023</a></li>
                        <li><a href="#0" data-date="01/11/2014">2024</a></li>
                        <!-- <li><a href="#0" data-date="10/12/2014">1987 to 2024</a></li>
                        <li><a href="#0" data-date="19/01/2015">1987 to 2024</a></li>
                        <li><a href="#0" data-date="03/03/2015">1987 to 2024</a></li> -->
                    </ol>

                    <span class="filling-line" aria-hidden="true"></span>
                </div> <!-- .events -->
            </div> <!-- .events-wrapper -->

            <ul class="cd-timeline-navigation">
                <ul><a href="#0" class="prev inactive"><i class="fas fa-chevron-left"></i></a></ul>
                <ul><a href="#0" class="next">Next</a></ul>
            </ul> <!-- .cd-timeline-navigation -->
        </div> <!-- .timeline -->

        <div class="events-content">
            <ol>
                <li class="selected" data-date="16/01/2014">
                    <h2>PANDI</h2>
                    <em>January 16th, 1792</em>
                    <p>
                    Pandi was founded in 1792. The EARTHQUAKE of 1880 damage the church and the convent constructed early in 
                    the nineteenth century. They where finally ddestroyed by fire, with the town itself, incident to an encounter 
                    between american and filipino forces in April, 1899.
                    </p>
                </li>

                <li data-date="28/02/2014">
                    <h2>THE EARTHQUAKE</h2>
                    <em>July 14th, 1880</em>
                    <p>
                    The 1880 Southern Luzon earthquakes, were one of the most destructive tremors on record in the history of the country. 
                    The shocks continued, with greater or less interruption, from July 14-25, 1880; highlighted by three violent quakes
                     measuring Mw 7.0, Mw 7.6, and Mw 7.2 respectively. The sequence destroyed churches and other buildings, producing 
                     loss of life.Coinciding with the tectonic activity was an increase in volcanic activity in the Taal Volcano of 
                     southwestern Luzon. Manila, together with the provinces of Cavite, Bulacan, Laguna, Pampanga, and Nueva Ecija 
                     were the chief victims from the convulsions, with Manila and Laguna receiving the full brunt of the quakes. In many places, 
                     buildings were converted into shapeless heaps of ruins, and the materials of their prosperity buried beneath the rubbish.
                    </p>
                </li>

                <li data-date="20/04/2014">
                    <h2>AMERICAN AND FILIPINO</h2>
                    <em>March 20th, 1896</em>
                    <p>
                    During the Philippine Revolution, Pandi played a vital and historical role in the fight for Philippine independence, 
                    Pandi is historically known for the Real de Kakarong de Sili Shrine - Inang Filipina Shrine, the site where the bloodiest 
                    revolution in Bulacan took place, where more than 3,000 Katipunero revolutionaries died. Likewise, it is on this site where 
                    the 'Republic of Real de Kakarong de Sili' of 1896, one of the first Philippine revolutionary republics was established. 
                    It was in Kakarong de Sili, which about 6,000 Katipuneros from various towns of Bulacan headed by Brigadier General 
                    Eusebio Roque, a mysticist (albolaryo) better known as "Maestrong Sebio or Dimabungo"
                    </p>
                </li>

                <li data-date="20/05/2014">
                    <h2>Stolen Image</h2>
                    <em>May 20th, 1930</em>
                    <p>
                        The church is home to an image of the Virgin Mary that is believed to be miraculous. There are
                        two local legends as to how the image arrived in Santa Maria: first is that it was brought to
                        the town by the Franciscan Friars, second is that it was sculpted out of wood from a galleon.
                        The image has been stolen in the 1930s and was retrieved in Nueva Ecija by a man named Teofilo
                        Ramirez who claimed that the Virgin Mary appeared in his dream and gave instructions as to where
                        the image can be found. The image was returned to the town on a February and the townsfolk
                        accordingly adjusted their feast day to the first Thursday of February except when its falls on
                        February 2 (the feast of the Our Lady of the Candles).
                    </p>
                </li>

                <li data-date="09/07/2014">
                    <h2>The Republic of Kakarong de Sili</h2>
                    <em>March 3, 1946</em>
                    <p>
                    The Kakarong Lodge No. 168 of the 'Legionarios del Trabajo' in memory of the 1,200 Katipuneros who perished 
                    in the battle erected a monument of the Inang Filipina Shrine - Mother Philippines Shrine in 1924 in the barrio 
                    of Kakarong. The actual site of the 'Battle of Kakarong de Sili' belongs to the administrative and geographical 
                    jurisdiction of Town of Bigaa and it was given to Pandi in 1946. The site is now a part of the barangay of 'Real de Kakarong'.
                     No less than one of the greatest generals in the Philippines' history, General Emilio Aguinaldo who became first 
                     Philippine president visited this sacred ground in the late fifties.
                    </p>
                </li>

                <li data-date="30/08/2014">
                    <h2>Geography</h2>
                    <em>1987</em>
                    <p>
                    Pandi is located at the center of four adjoining towns of Bulacan Province: Santa Maria; Bustos; Angat; 
                    and Balagtas. The land area are mostly rice fields devoted for planting crops and agriculture. Some barrios
                     of the town are covered by irrigation system coming from Angat Dam on the Angat River. There are many 
                     little rivers that branch out from this river that become estuaries. Some little rivers provide livelihood 
                     by fanning gold. The biggest river is Bunsuran River that empties itself to the Philippine Sea. Along the side 
                     of the rivers are banana plantations thriving naturally and many taro plants.
                    </p>
                </li>

                <li data-date="15/09/2014">
                    <h2>Likas na Yaman</h2>
                    <em>September 15th, 2023</em>
                    <p>
                    Pandi is rich in many natural brooks coming from the mainland itself. In some remote areas the lands are 
                    still covered by bamboo trees that naturally thrive and multiplies. Some lands privately owned have mango 
                    plantations. In some areas that are privately owned are rock deposits being used for housing materials. 
                    The eastern area of Poblacion is gifted by the natural panoramic beauty of the scenery of Sierra Madre Mountains in Luzon.
                    </p>
                </li>

                <li data-date="01/11/2014">
                    <h2>Climate</h2>
                    <em>2024</em>
                    <p>
                    Owing to this the morning climate is always cloudy and cool in some areas of the town proper of Pandi, Bulacan.
                     Some of the natural variations in topography of Pandi land areas have been evened out due to the urbanization 
                     of the town. The town's central area has been altered substantially by commercial establishments. Pandi was part 
                     of 2nd congressional district from 1987 to 2022. It was moved to 5th district along with Balagtas, Bocaue, and Guiguinto.
                    </p>
                </li>

                <!-- <li data-date="10/12/2014">
                    <h2>Event title here</h2>
                    <em>December 10th, 2014</em>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit
                        recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus
                        sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi!
                        Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro
                        doloribus.
                    </p>
                </li>

                <li data-date="19/01/2015">
                    <h2>Event title here</h2>
                    <em>January 19th, 2015</em>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit
                        recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus
                        sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi!
                        Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro
                        doloribus.
                    </p>
                </li>

                <li data-date="03/03/2015">
                    <h2>Event title here</h2>
                    <em>March 3rd, 2015</em>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit
                        recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus
                        sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi!
                        Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro
                        doloribus.
                    </p> -->
                </li>
            </ol>
        </div> <!-- .events-content -->
    </section>

    <!-- IMAGE GALLERY -->
    <section class="image_gallery">
        <div class="wrapper">
            <div class="images">
                <img src="image/img1.jpg">
                <img src="image/img2.jpg">
                <img src="image/img3.jpg">
                <img src="image/img4.jpg">
                <img src="image/img9.jpg">
                <img src="image/img6.jpg">
                <img src="image/img7.jpg">
                <img src="image/img5.jpg">
                <img src="image/img8.jpg">
            </div>
            <div class="text">
                <p>Our Church.</p>
            </div>
        </div>
    </section>


    <!-- HISTORY -->
    <section class="about-myself">
        <div class="content">
            <h2>HISTORY</h2>
            <p>The Pandi Church in Bulacan is a historical and culturally significant Dominican church that holds a deep
                devotion to the 'Immaculate Conception.' Its rich history dates to the 1890s, when it was initially
                constructed. Over the years, the church has undergone extensive improvements and meticulous restoration
                efforts, particularly around 1999, in a bid to preserve its architectural and spiritual heritage.
                What makes the Pandi Church truly remarkable is the harmonious blend of old and new. While the main body
                of the church has been lovingly restored and upgraded to accommodate modern needs, the preservationists
                and caretakers of this sacred site have been careful to retain portions of the original structure. These
                cherished remnants can be found in the altar area and the camarin, a room situated behind the altar.
                <br>
                <br>
                Visitors to the Pandi Church are treated to a unique and immersive experience, where they can witness
                the passage of time and the evolution of architectural styles. The juxtaposition of the restored
                sections with the original elements offers a profound sense of connection to the past, inviting
                contemplation and reverence.
                It's essential to note that the Pandi Church should not be confused with the Sta. Maria Church, which
                shares the same dedication to the 'Immaculate Conception.' Each of these churches has its distinct
                history, architectural features, and cultural significance, contributing to the rich tapestry of
                religious heritage in Bulacan. As such, the Pandi Church stands as a testament to the dedication and
                commitment of the Dominican community to preserving their religious and architectural legacy for
                generations to come.
            </p>
        </div>
    </section>


    <!-- BLOG -->
    <section class="portfolio">
        <div class="content">
            <h1>Events and Activities</h1>
            <div class="flex-container">
                <?php foreach ($blog as $item) { ?>
                <div class="card">
                    <div class="card-header">
                        <img src="<?php echo $item['image']; ?>" alt="">
                    </div>
                    <div class="card-content">
                        <span><?php echo $item['formatted_date']; ?></span>
                        <a class="title" href="#"><?php echo $item['title']; ?></a>
                        <p><?php echo $item['short_content']; ?></p>
                    </div>
                    <div class="card-footer">
                        <a href="blog.php?blog_id=<?php echo $item['blog_id']; ?>" class="btn btn-primary btn-sm h-25"
                            target="_blank">Read More</a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>


    <!-- ORGANIZATION -->
    <section>
        <div class="jumbotron text-center">
            <div class="row align-items-center">
                <div class="col-xs-12 col-sm-12 d-flex justify-content-center">
                    <img class="" style="width: 120px; height: auto; margin-right: 10px;" src="image/logo_only.png">
                    <div style="display: inline-block; vertical-align: middle;">
                        <span style="display: inline-block; margin-bottom: 0; font-size: 20px; ">Diocese of
                            Malolos</span><br>
                        <span class="immaculate" style="display: inline-block; margin-bottom: 0; font-size: 30px; font-weight: 700;">Immaculate Conception
                            Parish</span><br>
                            <span style="display: inline-block; margin-bottom: 0; font-size: 15px; ">Poblacion, Pandi Bulacan, 3014</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row text-center">
                <div class="col-xs-12 col-md-6 col-lg-12">
                    <div class="thumbnail" style="background-color: transparent; border: none;">
                        <div class="caption">
                            <h2 class="text-center"><strong><a href="#">REV.
                                        FR. JOSELIN L. SAN JOSE</a></strong></h2>
                            <h3 class="text-center"></strong>Parish Priest</h3>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-12">
                    <div class="thumbnail" style="background-color: transparent; border: none;">
                        <div class="caption">
                            <h2 class="text-center"><strong><a href="#">REV.
                                        FR. JONATHAN C. LAZARO</a></strong></h2>
                            <h3 class="text-center"></strong>Parochial Vicar</h3>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-4">
                    <div class="thumbnail" style="background-color: transparent; border: none;">
                        <div class="caption">
                            <h4 class="text-center"><strong><a href="#">LEIGH
                                        SHAREEN STA. MARIA</a></strong></h4>
                            <h5 class="text-center"></strong>Parish Secretary I</h5>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-4">
                    <div class="thumbnail" style="background-color: transparent; border: none;">
                        <div class="caption">
                            <h4 class="text-center"><strong><a href="#">ZHAIRA
                                        JHEM NGOTY</a></strong></h4>
                            <h5 class="text-center"></strong>Parish Secretary II</h5>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-4">
                    <div class="thumbnail" style="background-color: transparent; border: none;">
                        <div class="caption">
                            <h4 class="text-center"><strong><a href="#">RONALDO
                                        CRUZ</a></strong></h4>
                            <h5 class="text-center"></strong>Cook / Driver</h5>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-4">
                    <div class="thumbnail" style="background-color: transparent; border: none;">
                        <div class="caption">
                            <h4 class="text-center"><strong><a
                                        href="#">MANOLITO PARENAS <br> LILIA
                                        PARENAS</a></strong></h4>
                            <h5 class="text-center"></strong>Maintenance</h5>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-4">
                    <div class="thumbnail" style="background-color: transparent; border: none;">
                        <div class="caption">
                            <h4 class="text-center"><strong><a href="#">RHEANCE
                                        PAUL MATEO</a></strong></h4>
                            <h5 class="text-center"></strong>Sacristan Mayor</h5>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-4">
                    <div class="thumbnail" style="background-color: transparent; border: none;">
                        <div class="caption">
                            <h4 class="text-center"><strong><a href="#">MARWIN
                                        STA. MARIA</a></strong></h4>
                            <h5 class="text-center"></strong>Cemetery Coordinator</h5>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-4">
                    <div class="thumbnail" style="background-color: transparent; border: none;">
                        <div class="caption">
                            <h4 class="text-center"><strong><a href="#">RONALD
                                        NOLASCO</a></strong></h4>
                            <h5 class="text-center"></strong>Cemetery Caretaker</h5>
                        </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

</body>


<?php include 'footer.php';?>
<script>
$(document).ready(function() {
    // Main variables
    var $aboutTitle = $('.about-myself .content h2');
    var $developmentWrapper = $('.development-wrapper');
    var developmentIsVisible = false;


    /* ####### HERO SECTION ####### */

    $('.hero .content .header').delay(500).animate({
        'opacity': '1',
        'top': '50%'
    }, 1000);


    $(window).scroll(function() {

        var bottom_of_window = $(window).scrollTop() + $(window).height();

        /* ##### ABOUT MYSELF SECTION #### */
        if (bottom_of_window > ($aboutTitle.offset().top + $aboutTitle.outerHeight())) {
            $('.about-myself .content h2').addClass('aboutTitleVisible');
        }
        /* ##### EXPERIENCE SECTION #### */

        // Check the location of each element hidden */
        $('.experience .content .hidden').each(function(i) {

            var bottom_of_object = $(this).offset().top + $(this).outerHeight();

            /* If the object is completely visible in the window, fadeIn it */
            if (bottom_of_window > bottom_of_object) {

                $(this).animate({
                    'opacity': '1',
                    'margin-left': '0'
                }, 600);
            }
        });

        /*###### SKILLS SECTION ######*/

        var middle_of_developmentWrapper = $developmentWrapper.offset().top + $developmentWrapper
            .outerHeight() / 2;

        if ((bottom_of_window > middle_of_developmentWrapper) && (developmentIsVisible == false)) {

            $('.skills-bar-container li').each(function() {

                var $barContainer = $(this).find('.bar-container');
                var dataPercent = parseInt($barContainer.data('percent'));
                var elem = $(this).find('.progressbar');
                var percent = $(this).find('.percent');
                var width = 0;

                var id = setInterval(frame, 15);

                function frame() {
                    if (width >= dataPercent) {
                        clearInterval(id);
                    } else {
                        width++;
                        elem.css("width", width + "%");
                        percent.html(width + " %");
                    }
                }
            });
            developmentIsVisible = true;
        }
    }); // -- End window scroll --
});
</script>

<!-- image gallery -->
<script>
$(".images img").click(function() {
    $(this).addClass("zoom");
});

$(".images img").mouseleave(function() {
    $(this).removeClass("zoom");
});
</script>


<!-- TIMELINE -->
<script>
jQuery(document).ready(function($) {
    var timelines = $('.cd-horizontal-timeline'),
        eventsMinDistance = 60;

    (timelines.length > 0) && initTimeline(timelines);

    function initTimeline(timelines) {
        timelines.each(function() {
            var timeline = $(this),
                timelineComponents = {};
            //cache timeline components 
            timelineComponents['timelineWrapper'] = timeline.find('.events-wrapper');
            timelineComponents['eventsWrapper'] = timelineComponents['timelineWrapper'].children(
                '.events');
            timelineComponents['fillingLine'] = timelineComponents['eventsWrapper'].children(
                '.filling-line');
            timelineComponents['timelineEvents'] = timelineComponents['eventsWrapper'].find('a');
            timelineComponents['timelineDates'] = parseDate(timelineComponents['timelineEvents']);
            timelineComponents['eventsMinLapse'] = minLapse(timelineComponents['timelineDates']);
            timelineComponents['timelineNavigation'] = timeline.find('.cd-timeline-navigation');
            timelineComponents['eventsContent'] = timeline.children('.events-content');

            //assign a left postion to the single events along the timeline
            setDatePosition(timelineComponents, eventsMinDistance);
            //assign a width to the timeline
            var timelineTotWidth = setTimelineWidth(timelineComponents, eventsMinDistance);
            //the timeline has been initialize - show it
            timeline.addClass('loaded');

            //detect click on the next arrow
            timelineComponents['timelineNavigation'].on('click', '.next', function(event) {
                event.preventDefault();
                updateSlide(timelineComponents, timelineTotWidth, 'next');
            });
            //detect click on the prev arrow
            timelineComponents['timelineNavigation'].on('click', '.prev', function(event) {
                event.preventDefault();
                updateSlide(timelineComponents, timelineTotWidth, 'prev');
            });
            //detect click on the a single event - show new event content
            timelineComponents['eventsWrapper'].on('click', 'a', function(event) {
                event.preventDefault();
                timelineComponents['timelineEvents'].removeClass('selected');
                $(this).addClass('selected');
                updateOlderEvents($(this));
                updateFilling($(this), timelineComponents['fillingLine'], timelineTotWidth);
                updateVisibleContent($(this), timelineComponents['eventsContent']);
            });

            //on swipe, show next/prev event content
            timelineComponents['eventsContent'].on('swipeleft', function() {
                var mq = checkMQ();
                (mq == 'mobile') && showNewContent(timelineComponents, timelineTotWidth,
                    'next');
            });
            timelineComponents['eventsContent'].on('swiperight', function() {
                var mq = checkMQ();
                (mq == 'mobile') && showNewContent(timelineComponents, timelineTotWidth,
                    'prev');
            });

            //keyboard navigation
            $(document).keyup(function(event) {
                if (event.which == '37' && elementInViewport(timeline.get(0))) {
                    showNewContent(timelineComponents, timelineTotWidth, 'prev');
                } else if (event.which == '39' && elementInViewport(timeline.get(0))) {
                    showNewContent(timelineComponents, timelineTotWidth, 'next');
                }
            });
        });
    }

    function updateSlide(timelineComponents, timelineTotWidth, string) {
        //retrieve translateX value of timelineComponents['eventsWrapper']
        var translateValue = getTranslateValue(timelineComponents['eventsWrapper']),
            wrapperWidth = Number(timelineComponents['timelineWrapper'].css('width').replace('px', ''));
        //translate the timeline to the left('next')/right('prev') 
        (string == 'next') ?
        translateTimeline(timelineComponents, translateValue - wrapperWidth + eventsMinDistance, wrapperWidth -
            timelineTotWidth): translateTimeline(timelineComponents, translateValue + wrapperWidth -
            eventsMinDistance);
    }

    function showNewContent(timelineComponents, timelineTotWidth, string) {
        //go from one event to the next/previous one
        var visibleContent = timelineComponents['eventsContent'].find('.selected'),
            newContent = (string == 'next') ? visibleContent.next() : visibleContent.prev();

        if (newContent.length > 0) { //if there's a next/prev event - show it
            var selectedDate = timelineComponents['eventsWrapper'].find('.selected'),
                newEvent = (string == 'next') ? selectedDate.parent('li').next('li').children('a') :
                selectedDate.parent('li').prev('li').children('a');

            updateFilling(newEvent, timelineComponents['fillingLine'], timelineTotWidth);
            updateVisibleContent(newEvent, timelineComponents['eventsContent']);
            newEvent.addClass('selected');
            selectedDate.removeClass('selected');
            updateOlderEvents(newEvent);
            updateTimelinePosition(string, newEvent, timelineComponents, timelineTotWidth);
        }
    }

    function updateTimelinePosition(string, event, timelineComponents, timelineTotWidth) {
        //translate timeline to the left/right according to the position of the selected event
        var eventStyle = window.getComputedStyle(event.get(0), null),
            eventLeft = Number(eventStyle.getPropertyValue("left").replace('px', '')),
            timelineWidth = Number(timelineComponents['timelineWrapper'].css('width').replace('px', '')),
            timelineTotWidth = Number(timelineComponents['eventsWrapper'].css('width').replace('px', ''));
        var timelineTranslate = getTranslateValue(timelineComponents['eventsWrapper']);

        if ((string == 'next' && eventLeft > timelineWidth - timelineTranslate) || (string == 'prev' &&
                eventLeft < -timelineTranslate)) {
            translateTimeline(timelineComponents, -eventLeft + timelineWidth / 2, timelineWidth -
                timelineTotWidth);
        }
    }

    function translateTimeline(timelineComponents, value, totWidth) {
        var eventsWrapper = timelineComponents['eventsWrapper'].get(0);
        value = (value > 0) ? 0 : value; //only negative translate value
        value = (!(typeof totWidth === 'undefined') && value < totWidth) ? totWidth :
            value; //do not translate more than timeline width
        setTransformValue(eventsWrapper, 'translateX', value + 'px');
        //update navigation arrows visibility
        (value == 0) ? timelineComponents['timelineNavigation'].find('.prev').addClass('inactive'):
            timelineComponents['timelineNavigation'].find('.prev').removeClass('inactive');
        (value == totWidth) ? timelineComponents['timelineNavigation'].find('.next').addClass('inactive'):
            timelineComponents['timelineNavigation'].find('.next').removeClass('inactive');
    }

    function updateFilling(selectedEvent, filling, totWidth) {
        //change .filling-line length according to the selected event
        var eventStyle = window.getComputedStyle(selectedEvent.get(0), null),
            eventLeft = eventStyle.getPropertyValue("left"),
            eventWidth = eventStyle.getPropertyValue("width");
        eventLeft = Number(eventLeft.replace('px', '')) + Number(eventWidth.replace('px', '')) / 2;
        var scaleValue = eventLeft / totWidth;
        setTransformValue(filling.get(0), 'scaleX', scaleValue);
    }

    function setDatePosition(timelineComponents, min) {
        for (i = 0; i < timelineComponents['timelineDates'].length; i++) {
            var distance = daydiff(timelineComponents['timelineDates'][0], timelineComponents['timelineDates'][
                    i
                ]),
                distanceNorm = Math.round(distance / timelineComponents['eventsMinLapse']) + 2;
            timelineComponents['timelineEvents'].eq(i).css('left', distanceNorm * min + 'px');
        }
    }

    function setTimelineWidth(timelineComponents, width) {
        var timeSpan = daydiff(timelineComponents['timelineDates'][0], timelineComponents['timelineDates'][
                timelineComponents['timelineDates'].length - 1
            ]),
            timeSpanNorm = timeSpan / timelineComponents['eventsMinLapse'],
            timeSpanNorm = Math.round(timeSpanNorm) + 4,
            totalWidth = timeSpanNorm * width;
        timelineComponents['eventsWrapper'].css('width', totalWidth + 'px');
        updateFilling(timelineComponents['timelineEvents'].eq(0), timelineComponents['fillingLine'],
            totalWidth);

        return totalWidth;
    }

    function updateVisibleContent(event, eventsContent) {
        var eventDate = event.data('date'),
            visibleContent = eventsContent.find('.selected'),
            selectedContent = eventsContent.find('[data-date="' + eventDate + '"]'),
            selectedContentHeight = selectedContent.height();

        if (selectedContent.index() > visibleContent.index()) {
            var classEnetering = 'selected enter-right',
                classLeaving = 'leave-left';
        } else {
            var classEnetering = 'selected enter-left',
                classLeaving = 'leave-right';
        }

        selectedContent.attr('class', classEnetering);
        visibleContent.attr('class', classLeaving).one(
            'webkitAnimationEnd oanimationend msAnimationEnd animationend',
            function() {
                visibleContent.removeClass('leave-right leave-left');
                selectedContent.removeClass('enter-left enter-right');
            });
        eventsContent.css('height', selectedContentHeight + 'px');
    }

    function updateOlderEvents(event) {
        event.parent('li').prevAll('li').children('a').addClass('older-event').end().end().nextAll('li')
            .children('a').removeClass('older-event');
    }

    function getTranslateValue(timeline) {
        var timelineStyle = window.getComputedStyle(timeline.get(0), null),
            timelineTranslate = timelineStyle.getPropertyValue("-webkit-transform") ||
            timelineStyle.getPropertyValue("-moz-transform") ||
            timelineStyle.getPropertyValue("-ms-transform") ||
            timelineStyle.getPropertyValue("-o-transform") ||
            timelineStyle.getPropertyValue("transform");

        if (timelineTranslate.indexOf('(') >= 0) {
            var timelineTranslate = timelineTranslate.split('(')[1];
            timelineTranslate = timelineTranslate.split(')')[0];
            timelineTranslate = timelineTranslate.split(',');
            var translateValue = timelineTranslate[4];
        } else {
            var translateValue = 0;
        }

        return Number(translateValue);
    }

    function setTransformValue(element, property, value) {
        element.style["-webkit-transform"] = property + "(" + value + ")";
        element.style["-moz-transform"] = property + "(" + value + ")";
        element.style["-ms-transform"] = property + "(" + value + ")";
        element.style["-o-transform"] = property + "(" + value + ")";
        element.style["transform"] = property + "(" + value + ")";
    }

    //based on http://stackoverflow.com/questions/542938/how-do-i-get-the-number-of-days-between-two-dates-in-javascript
    function parseDate(events) {
        var dateArrays = [];
        events.each(function() {
            var dateComp = $(this).data('date').split('/'),
                newDate = new Date(dateComp[2], dateComp[1] - 1, dateComp[0]);
            dateArrays.push(newDate);
        });
        return dateArrays;
    }

    function parseDate2(events) {
        var dateArrays = [];
        events.each(function() {
            var singleDate = $(this),
                dateComp = singleDate.data('date').split('T');
            if (dateComp.length > 1) { //both DD/MM/YEAR and time are provided
                var dayComp = dateComp[0].split('/'),
                    timeComp = dateComp[1].split(':');
            } else if (dateComp[0].indexOf(':') >= 0) { //only time is provide
                var dayComp = ["2000", "0", "0"],
                    timeComp = dateComp[0].split(':');
            } else { //only DD/MM/YEAR
                var dayComp = dateComp[0].split('/'),
                    timeComp = ["0", "0"];
            }
            var newDate = new Date(dayComp[2], dayComp[1] - 1, dayComp[0], timeComp[0], timeComp[1]);
            dateArrays.push(newDate);
        });
        return dateArrays;
    }

    function daydiff(first, second) {
        return Math.round((second - first));
    }

    function minLapse(dates) {
        //determine the minimum distance among events
        var dateDistances = [];
        for (i = 1; i < dates.length; i++) {
            var distance = daydiff(dates[i - 1], dates[i]);
            dateDistances.push(distance);
        }
        return Math.min.apply(null, dateDistances);
    }

    /*
    	How to tell if a DOM element is visible in the current viewport?
    	http://stackoverflow.com/questions/123999/how-to-tell-if-a-dom-element-is-visible-in-the-current-viewport
    */
    function elementInViewport(el) {
        var top = el.offsetTop;
        var left = el.offsetLeft;
        var width = el.offsetWidth;
        var height = el.offsetHeight;

        while (el.offsetParent) {
            el = el.offsetParent;
            top += el.offsetTop;
            left += el.offsetLeft;
        }

        return (
            top < (window.pageYOffset + window.innerHeight) &&
            left < (window.pageXOffset + window.innerWidth) &&
            (top + height) > window.pageYOffset &&
            (left + width) > window.pageXOffset
        );
    }

    function checkMQ() {
        //check if mobile or desktop device
        return window.getComputedStyle(document.querySelector('.cd-horizontal-timeline'), '::before')
            .getPropertyValue('content').replace(/'/g, "").replace(/"/g, "");
    }
});
</script>

</html>