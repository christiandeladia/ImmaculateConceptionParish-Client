<?php 
    require_once "connect.php";
    $is_customer_logged_in = isset($_SESSION['auth_login']);
?>
<?php
    if ( isset($_SESSION['auth_login']) ) {
		$auth = $_SESSION['auth_login'];
        $auth_full_name = $auth['first_name'] . $auth['last_name'];
}
?>
<html>

<head>
    <title>APPLY FOR SERVICES - ICP </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="image/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>

<body>
    <?php include 'nav.php';?>
    <section id="about" class="section-b"></section>
    <!-- SERVICES CARD -->
    <div class="card">
        <div class="card-wrap">
            <img class="card-header" src="services_forms/image/wedding.jpg">
            <div class="card-content">
                <h1 class="card-title">WEDDING</h1>
                <p class="card-text">Apply for marriage in church: Visit, fill a form, and submit details for a
                    memorable
                    ceremony.</p>

                <?php if ($is_customer_logged_in) { ?>
                <button class="card-btn" data-toggle="modal" data-target="#weddingmodal1">Apply Now</button>
                <?php } else { ?>
                <a href="customer/login.php"><button class="card-btn">Apply Now</button></a>
                <?php } ?>

            </div>
        </div>

        <div class="card-wrap">
            <img class="card-header" src="services_forms/image/baptismal.jpg">
            <div class="card-content">
                <h1 class="card-title">BAPTISMAL</h1>
                <p class="card-text">Apply for baptism in church: Complete a form, submit details, and embrace a
                    spiritual
                    journey through this sacred initiation.</p>
                <?php if ($is_customer_logged_in) { ?>
                <button class="card-btn" data-toggle="modal" data-target="#baptismalmodal1">Apply Now</button>
                <?php } else { ?>
                <a href="customer/login.php"><button class="card-btn">Apply Now</button></a>
                <?php } ?>
            </div>
        </div>

        <div class="card-wrap">
            <img class="card-header" src="services_forms/image/funeral.jpg">
            <div class="card-content">
                <h1 class="card-title">FUNERAL</h1>
                <p class="card-text">Apply for a church funeral ceremony: Fill a form, provide details, and honor the
                    departed with a dignified and spiritual farewell.</p>
                <?php if ($is_customer_logged_in) { ?>
                <button class="card-btn" data-toggle="modal" data-target="#funeralmodal1">Apply Now</button>
                <?php } else { ?>
                <a href="customer/login.php"><button class="card-btn">Apply Now</button></a>
                <?php } ?>
            </div>
        </div>

        <div class="card-wrap">
            <img class="card-header" src="services_forms/image/mass.jpg">
            <div class="card-content">
                <h1 class="card-title">MASS</h1>
                <p class="card-text">Apply for Mass: Embrace a sacred journey of faith from the comfort of your home.
                    Apply
                    online for a spiritual connection.</p>

                <?php if ($is_customer_logged_in) { ?>
                <button class="card-btn" data-toggle="modal" data-target="#massModal">Apply Now</button>
                <?php } else { ?>
                <a href="customer/login.php"><button class="card-btn">Apply Now</button></a>
                <?php } ?>

            </div>
        </div>

        <div class="card-wrap">
            <img class="card-header" src="services_forms/image/blessing.jpg">
            <div class="card-content">
                <h1 class="card-title">BLESSING</h1>
                <p class="card-text">Apply for a church blessing: Complete a form, share details, and seek divine favor
                    for
                    your journey through a sacred ritual.</p>
                <?php if ($is_customer_logged_in) { ?>
                <button class="card-btn" data-toggle="modal" data-target="#exampleModal2">Apply Now</button>
                <?php } else { ?>
                <a href="customer/login.php"><button class="card-btn">Apply Now</button></a>
                <?php } ?>
            </div>
        </div>

        <div class="card-wrap">
            <img class="card-header" src="services_forms/image/sickcall.jpg">
            <div class="card-content">
                <h1 class="card-title">SICKCALL</h1>
                <p class="card-text">Apply for a church sick call: Fill a form, provide details, and request spiritual
                    support for healing and comfort.</p>
                <?php if ($is_customer_logged_in) { ?>
                <button class="card-btn" data-toggle="modal" data-target="#exampleModal3">Apply Now</button>
                <?php } else { ?>
                <a href="customer/login.php"><button class="card-btn">Apply Now</button></a>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="services">
        <!-- Wedding Modal -->
        <!-- First Modal -->
        <div class="modal fade" id="weddingmodal1" tabindex="-1" aria-labelledby="exampleModalLabel"
            style="padding-right: 0 !important;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">MATRIOMONIAL (WEDDINGS)</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-section" id="section1">
                            <div class="bg-light p-3">
                                <p>The sacrament of matrimony is a sacred union that binds a man and a woman together in
                                    the presence of God and their community. Just like many other Catholic churches, the
                                    parish offers the sacrament of matrimony to eligible couples who are eager to embark
                                    on their journey as husband and wife.
                                    <br>
                                    <br>
                                    Barasoain Church holds a special place in the hearts of many, often referred to as
                                    the "San Agustin Church" of Bulacan. Much like the renowned San Agustin Church in
                                    Manila, Barasoain Church is a sought-after location for couples seeking to join in
                                    holy matrimony. The church's popularity extends far and wide, attracting couples not
                                    only from various regions of the Philippines but also from overseas, including
                                    returning expatriates who choose to celebrate their weddings within its hallowed
                                    walls.
                                    <br>
                                    <br>
                                    This enduring appeal of Barasoain Church as a matrimonial venue underscores its
                                    significance as a place where couples come to profess their love and commitment to
                                    one another before God and their loved ones. The church's rich history and spiritual
                                    ambiance provide a truly remarkable backdrop for these joyous and sacred
                                    celebrations of love.
                                </p>
                                <br>
                                <br>
                                <h3>REQUIREMENTS FOR MARRIAGE</h3>
                                <ul>
                                    <li>Dulog</li>
                                    <li>Pre-Cana Seminar</li>
                                    <li>Mass and Confession</li>
                                    <li>Baptism and/or Confirmation</li>
                                    <li>Checking of Contract</li>
                                </ul>
                                <br>
                                <br>
                                <h3>FEES</h3>
                                <p><i>(to be paid and processed over the counter)</i></p>
                                <ul>
                                    <li><strong>Marriage Fee: ₱2,250.00</strong>
                                        <ul>
                                            <li>Mass</li>
                                            <li>Electricity</li>
                                            <li>Marriage Contract Registration Fee</li>
                                            <li><b>OPTIONAL:</b>
                                                <ul>
                                                    <li>Choir ₱500.00</li>
                                                    <li>Carpet ₱500.00</li>
                                                    <li>Candle ₱400.00</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <br>
                                <br>
                                <h3>PROCEDURE IN APPLICATION FOR MARRIAGE</h3>
                                <ul>
                                    <li>Fill-up the application forms and submit them.</li>
                                    <li>Wait for the schedule of your interview (message will be sent through text
                                        message)</li>
                                    <li>Submit the 2x2 ID photos with names on the back.</li>
                                    <li>After the interview, the marriage banns should be submitted to the couples'
                                        respective parishes.</li>
                                    <li>Furnish a copy of baptismal and confirmation certificates with annotation: "For
                                        Marriage Purposes"</li>
                                    <li>For those over the age of 25, apply and get a Certificate of No Marriage from
                                        the Philippine Statistics Authority</li>
                                    <li>After getting the Certificate of No Marriage, proceed to the city hall and apply
                                        for a Marriage License</li>
                                    <li>Attend the scheduled Pre-Cana seminar at the parish</li>
                                    <li>Send the line-up of your wedding entourage using the format sent to your email
                                        address</li>
                                    <li>Submit names of 1 godfather and 1 godmother (ninong and ninang) with complete
                                        address</li>
                                    <li>Settle the payments at the parish office 2 weeks before the wedding.</li>
                                    <li>Go to Confession a day before the wedding.</li>
                                </ul>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <a href="apply_wedding.php"><button type="submit" class="btn btn-success">Get
                                    Started</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Baptismal Modal -->

        <div class="modal fade" id="baptismalmodal1" tabindex="-1" aria-labelledby="exampleModalLabel"
            style="padding-left: 20px;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">BAPTISMAL</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-section" id="section1">
                            <div class="bg-light p-3">
                                <p>Baptism holds a significant role within the Christian faith as it formally welcomes a
                                    new member into the church. It serves as the cornerstone of the entire Christian
                                    journey, acting as the entryway to a life guided by the Holy Spirit and granting
                                    access to other sacred sacraments. Through this sacred ritual, individuals are
                                    cleansed of their sins and spiritually reborn as children of God. They become an
                                    integral part of the body of Christ, joining the church and participating in its
                                    mission.
                                    <br>
                                    <br>
                                    Beyond its religious significance, baptism has evolved into a cultural tradition
                                    characterized by family gatherings and the strengthening of societal bonds. As a
                                    religious institution, the parish is dedicated to ensuring the solemnity of this
                                    celebration for the newly initiated member.
                                </p>
                                <br>
                                <br>
                                <h3>REQUIREMENTS FOR BAPTISMAL</h3>
                                <ul>
                                    <li>Birth Certificate</li>
                                    <li>Marriage Certificate</li>
                                </ul>
                                <br>
                                <br>
                                <h3>SCHEDULE</h3>
                                <ul>
                                    <li>Regular Baptism Sundays - 10: 30 AM (Seminar) 11:30 AM (Binyag)</li>
                                    <li>Mondays and Tuesday - NO baptisms for this day</li>
                                    <li>Special Baptism - 9:00 AM, 10:00 AM, 11:00 AM, 1:00 PM, and 2:00 PM (for
                                        approval)</li>
                                </ul>
                                <br>
                                <br>
                                <h3>FEES</h3>
                                <p><i>(to be paid and processed over the counter)</i></p>
                                <ul>
                                    <li>Binyag Fee - P 400</li>
                                    <ul>
                                        <li>Inclusions: Baptismal Certificate</li>
                                        <li>One (1) Pair of Sponsor</li>
                                        <li>Additional Sponsor - P 100/pair (Optional)</li>
                                    </ul>
                                    <li>Individual baptisms - PHP 1450.00 + PHP 10.00 for every sponsor (ninong or
                                        ninang)</li>
                                </ul>
                                <br>
                                <br>
                                <h3>REMINDERS</h3>
                                <ul>
                                    <li>Ang SEMINAR po ay sa mismong araw ng binyag.</li>
                                    <li>Dumating sa nakatakdang oras: 10:30 A.M.</li>
                                    <li>Maaaring bumili ng DAMIT PAMBINYAG, BIMPO at 1
                                        pirasong KANDILA (para sa magulang) sa mismong araw
                                        ng Binyag na nagkakahalaga ng P 220.</li>
                                    <li>WALA PONG IBANG KANDILANG SISINDIHAN
                                        KUNDI ANG KANDILANG INILAAN SA
                                        BIBINYAGAN. KAYA HINDI PO KAYO BIBILI O
                                        MAGDADALA NG MGA KANDILA PARA SA
                                        MGA NINONG/NINANG DAHIL HINDI PO ITA
                                        IPAPAGAMIT.</li>
                                    <li>Panatilihin ang katahimikan at kaayusan sa loob
                                        ng simbahan.</li>
                                    <li>Ang SEMINAR po ay sa mismong araw ng binyag.</li>
                                    <li>Mga maaaring PUMASOK sa loob ng simbahan:</li>
                                    <ul>
                                        <li>Mga MAGULANG</li>
                                        <li>1 PARES SPONSOR (maliban kung magdadagdag)</li>
                                        <li>KAANAK (hindi HIHIGIT sa LIMANG (5) TAO lamang)</li>
                                    </ul>
                                </ul>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <a href="apply_baptismal.php"><button type="submit" class="btn btn-success">Get
                                    Started</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Funeral Modal -->
        <div class="modal fade" id="funeralmodal1" tabindexpadding-left: 20px;="-1" aria-labelledby="exampleModalLabel"
            style="padding-left: 20px;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">FUNERAL FORM</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-section" id="section1">
                            <div class="bg-light p-3">
                                <p>As a religious institution, the church plays a vital role in offering support and
                                    solace to the departed and their grieving families through a range of religious
                                    services. These services encompass the hosting of wakes, conducting liturgical
                                    ceremonies for the deceased, and managing the Barasoain Catholic Cemetery, a
                                    sacred
                                    resting place for burials.
                                </p>
                                <br>
                                <br>
                                <h3>WAKES</h3>
                                <p>Among the essential Catholic funeral rituals is the practice of holding a vigil
                                    service and wake for the deceased. During this solemn period, the departed
                                    individual is commemorated for their life on Earth. This occasion is marked by
                                    the
                                    reading of Sacred Scripture, accompanied by moments of reflection and prayer. It
                                    provides an opportunity to fondly recall the life of the departed and entrust
                                    their
                                    soul to God's care. The wake serves as a time for the grieving family to find
                                    solace
                                    and support through collective prayer and reflection.
                                    <br>
                                    <br>
                                    Furthermore, the church extends its support by offering a mortuary facility for
                                    hosting wakes. This dedicated space is conveniently situated at the side
                                    entrance of
                                    the church, facing Don Antonio Bautista Street. Those desiring prayer services
                                    and
                                    masses for the deceased during this challenging time are encouraged to get in
                                    touch
                                    with the parish office for assistance and arrangements.
                                </p>
                                <br>
                                <br>
                                <h3>REQUIEM MASS</h3>
                                <p>Before the burial or cremation of the departed, funeral masses can be conducted
                                    within the church to honor the deceased. The requiem mass holds a central place
                                    in
                                    the liturgical traditions of the Catholic community, providing an opportunity
                                    for
                                    the Church to come together with the grieving family and friends. During this
                                    service, gratitude is expressed to God for the victory of Christ over sin and
                                    death,
                                    and the departed individual is entrusted to God's boundless mercy and
                                    compassion.
                                    Simultaneously, the funeral liturgy aids family members in coming to terms with
                                    the
                                    stark reality of their loved one's passing. It serves as both an act of worship
                                    and
                                    a means of seeking strength in the proclamation of the Paschal Mystery. Those
                                    wishing to schedule a requiem mass can coordinate with the parish office for
                                    arrangements.
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="apply_funeral.php"><button class="btn btn-success">Get
                                    Started</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Mass modal -->
        <div class="modal fade" id="massModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            style="padding-left: 20px;" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen" style="margin=0;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">EUCHARISTIC MASSES</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-section" id="section1">
                            <div class="bg-light p-3">
                                <p>The Catholic Church, as an esteemed institution, upholds the tradition of
                                    conducting Eucharistic celebrations on a daily basis, viewing it as the central
                                    and most fundamental service within its faith. This profound ritual assumes a
                                    pivotal role in all church activities and events, serving as the focal point of
                                    Catholic religious practices.
                                    <br><br>
                                    In Catholic theology, the Mass or Eucharist is revered as "the source and summit
                                    of the Christian life," and it serves as the cornerstone to which all other
                                    sacraments are oriented. Masses are convened with multifaceted purposes: they
                                    are a means to proclaim and internalize the teachings of God, a vehicle for
                                    seeking forgiveness for sins, a commemoration of the sacrifice of Jesus Christ,
                                    most notably during the Holy Week observances, and an opportunity to partake in
                                    the communion with Christ.
                                    <br><br>
                                    The scheduling of Masses typically adheres to specific times during the week,
                                    with a primary focus on Sundays and the special Holy Celebrations designated
                                    within the Catholic Church calendar. These Masses are conducted in the Filipino
                                    language, making them accessible and relatable to the local congregation. In
                                    addition to the celebration of the Holy Mass, the church organizes novenas,
                                    recitations of the Rosary, holy hours, and vigils, all dedicated to honoring
                                    particular saints and fortifying the faith of the congregation.
                                    <br><br>
                                    To inform the faithful of the Mass schedule during these significant holy
                                    celebrations, announcements are made in the weeks leading up to the events, both
                                    within the church during regular Masses and through the church's official
                                    website. This ensures that the congregation is well-prepared and can actively
                                    participate in these spiritually enriching occasions.
                                </p>
                                <br>
                                <br>
                                <h3>SCHEDULE OF MASSES</h3>
                                <ul>
                                    <li><strong>WEEKDAYS AND SATURDAYS</strong> - 5:00 AM (Holy Hour; only on first
                                        Fridays), 6:00 AM, 6:00 PM (Evening mass on weekdays; anticipated on
                                        Saturdays)</li>
                                    <li><strong>SUNDAYS</strong> - 6:00 AM, 7:30 AM, 8:45 AM, 10:00 AM, 11:00 AM,
                                        5:00 PM, 6:15 PM (English mass)</li>
                                </ul>
                                <br>
                                <br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="apply_mass.php"><button class="btn btn-success">Get
                                    Started</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blessing Modal -->
        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel"
            style="padding-left: 20px;" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen" style="margin=0;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">BLESSING</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-section" id="section1">
                            <div class="bg-light p-3">
                                <p>Blessings, in the realm of religion, encompass the act of seeking favor, guidance,
                                    and divine intervention for specific causes, individuals, or objects. This sacred
                                    practice serves to underscore the significance of God in our daily existence while
                                    acknowledging the Almighty's authority in safeguarding and guiding our lives, work,
                                    or possessions from harm. Within this context, the church, as a religious
                                    institution, plays a pivotal role in facilitating these meaningful ceremonies.
                                    <br><br>
                                    The rituals associated with blessings typically involve the participation of a
                                    qualified and officially ordained priest. Through their authority and connection to
                                    the divine, these priests consecrate individuals, objects, or petitions, invoking
                                    Divine guidance and intervention to bestow spiritual favor and protection upon them.
                                    This process is a profound expression of faith, reinforcing the belief in God's
                                    benevolence and the pivotal role of the church in fostering this connection between
                                    the spiritual and earthly realms.
                                </p>
                                <br>
                                <br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="apply_blessing.php"><button class="btn btn-success">Get
                                    Started</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sickcall Modal -->
        <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel"
            style="padding-left: 20px;" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen" style="margin=0;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">SICKCALL</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-section" id="section1">
                            <div class="bg-light p-3">
                                <p>Sickcall, in the realm of religion, encompass the act of seeking favor, guidance,
                                    and divine intervention for specific causes, individuals, or objects. This sacred
                                    practice serves to underscore the significance of God in our daily existence while
                                    acknowledging the Almighty's authority in safeguarding and guiding our lives, work,
                                    or possessions from harm. Within this context, the church, as a religious
                                    institution, plays a pivotal role in facilitating these meaningful ceremonies.
                                    <br><br>
                                    The rituals associated with blessings typically involve the participation of a
                                    qualified and officially ordained priest. Through their authority and connection to
                                    the divine, these priests consecrate individuals, objects, or petitions, invoking
                                    Divine guidance and intervention to bestow spiritual favor and protection upon them.
                                    This process is a profound expression of faith, reinforcing the belief in God's
                                    benevolence and the pivotal role of the church in fostering this connection between
                                    the spiritual and earthly realms.
                                </p>
                                <br>
                                <br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="apply_sickcall.php"><button class="btn btn-success">Get
                                    Started</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
</body>

</html>

<style>
.modal-dialog {
    max-width: 70%;
    /* max-height: 200px; */
    margin: 1.75rem auto;
    font-family: "Montserrat";
}

.modal-content {
    /* min-height: 100%; */
    margin: 0 auto;
    font-size: 20px;
}

.modal-body {
    width: 100%;
    margin: 0 auto;
}

.modal-title {
    /* text-align: center; */
    /* margin-left: 20%; */
    font-weight: 1000;
    color: green;
}

.modal-body h3 {
    /* text-align: center; */
    /* margin-left: 20%; */
    font-weight: 1000;
    color: green;
}

.fa-question-circle {
    color: #888888;
}

.services {
    width: 90%;
    display: flex;
    flex-direction: column;
    margin-left: auto;
    margin-right: auto;
}

.form-control {
    height: calc(2em + 1rem + 3px);
}

:root {
    --color-text: #616161;
    --color-text-btn: #ffffff;
    --color1: #11998e;
    --color2: #38ef7d;
}

button.btn.btn-success {
    font-size: 20px;
    background-color: green;
    padding: 10px;
}

.card {
    margin: 0 auto;
    height: 380px;
    width: 95%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    flex-direction: row;
    gap: 20px;
    background: transparent;
    border: 0px solid rgba(0, 0, 0, .125) !important;
}

@media only screen and (max-device-width: 480px) {
    .section-b {
        max-width: 90%;
    }

    .card {
        flex-direction: column;
        /* Change flex direction to column for smaller screens */
        column-gap: 20px;
        height: auto;
        /* Adjust height as needed for smaller screens */
        display: grid;
        grid-template-columns: 40% 1fr;
        padding-left: 100px;
        justify-items: center;


        .card-wrap {
            width: 100%;
            /* Full width for smaller screens */
            margin-bottom: 20px;
        }

        .card-wrap:hover {
            transform: scale(1);
        }
    }

}

.card-wrap {
    width: calc(16.66% - 20px);
    height: 440px;
    background: #fff;
    border-radius: 20px;
    border: 5px solid #fff;
    overflow: hidden;
    color: var(--color-text);
    box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
    /* cursor: pointer; */
    justify-content: center;
    transition: all 0.2s ease-in-out;
}

.card-wrap:hover {
    transform: scale(1.1);
}

.card-header {
    padding: 0 !important;
    height: 200px;
    width: 100%;
    background: white;
    border-radius: 100% 0% 100% 0% / 0% 50% 50% 100% !important;
    /* display: grid; */
    place-items: center;
}

.card-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 80%;
    margin: 0 auto;
}

.card-title {
    text-align: center;
    text-transform: uppercase;
    font-size: 18px;
    font-weight: bold;
    margin-top: 10px;
    margin-bottom: 20px;
}

.card-text {
    height: 80px;
    text-align: left;
    font-size: 14px;
    margin-bottom: 20px;
}

.card-btn {
    position: block;
    border: none;
    width: 200px;
    border-radius: 100px;
    padding: 10px 20px;
    color: #fff;
    margin: 10px 0;
    text-transform: uppercase;
    background: linear-gradient(to left,
            var(--color1),
            var(--color2));
}

label {
    display: inline-block;
    margin-bottom: 0.5rem;
    color: black !important;
    font-size: 19px !important;
}

.modal-header .close {
    padding: 0.2rem 0.5rem;
    margin: -1rem -1rem -1rem auto;
}

.close {
    float: right;
    font-size: 3rem;
    font-weight: 700;
    line-height: 1;
    color: #ff0000;
    text-shadow: 0 1px 0 #fff;
    opacity: .5;
}

.card-header {
    background: linear-gradient(to bottom left,
            var(--color1),
            var(--color2));
}

.section-b {
    width: 95%;

    position: relative;
    margin: 20px 40px 50px 40px;
    background: url('services_forms/image/banner1.jpg') no-repeat bottom center/cover;
    height: 250px;
    border-radius: 10px 10px 10px 10px;
    /* box-shadow: 20px 10px 20px 5px #eee; */
    padding-top: 100px;
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1050;
    display: none;
    width: 100%;
    height: 100%;
    overflow: hidden;
    outline: 0;
}
</style>