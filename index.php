<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection" content="telephone=no">
    <link href="https://fonts.googleapis.com/css?family=Tajawal" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./stylesheets/game.css">
    <?php require('db_handler/sqlToClient.php');
    retrieveData(); ?>    
    <script src="./db_handler/dataHandler.js"></script>
	<script src="./gamejs/slot.js"></script>
    <script src="./gamejs/gameMain.js"></script>
    <title>Game Idea Bandit</title>
    <link rel="apple-touch-icon" sizes="180x180" href="favicon_package/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon_package/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon_package/favicon-16x16.png">
    <link rel="manifest" href="favicon_package/site.webmanifest">
    <link rel="mask-icon" href="favicon_package/safari-pinned-tab.svg" color="#6bcaba">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

</head>
    <body>

        <div class="loaderBody" id="loaderBody">
            <div class="loader" id="loader">
            </div>
        </div>

        <section class="sectionHeader">
            <img src="img/dlg.svg" alt="Tallinn University logo" class="logoImg">
            <img src="img/tlu.svg" alt="Tallinn University logo" class="logoTLU">
            <h1>Digital Learning Games<br><span class="strokeHeading">Idea Generating Machine</span></h1>
        </section>

        <section class="sectionGame">
            <div class="gameBody" id="gameBody">

                <ul class="categoryList">
                    <li class="categoryItem ciTarget">Genre:</li>
                    <li class="categoryItem ciNeed">Target:</li>
                    <li class="categoryItem ciGenre">Design:</li>
                    <li class="categoryItem ciDesign">Learning:</li>
                    <li class="categoryItem ciLearning">Need:</li>
                </ul>

                <div class="gameBodySlots gameGrid">
                    <div class="gameSlotItem gsTarget">
                        <canvas id="slot1"></canvas><p id="mslot1">?</p>
                    </div>

                    <div class="gameSlotItem gsNeed">
                        <canvas id="slot2"></canvas><p id="mslot2">?</p>
                    </div>

                    <div class="gameSlotItem gsGenre">
                        <canvas id="slot3"></canvas><p id="mslot3">?</p>
                    </div>

                    <div class="gameSlotItem gsDesign">
                        <canvas id="slot4"></canvas><p id="mslot4">?</p>
                    </div>

                    <div class="gameSlotItem gsLearning">
                        <canvas id="slot5"></canvas><ps id="mslot5">?</p>
                    </div>

                    <div class="gameStartBtn">
                        <button type="button" id="rollButton" class="gameStart blinking" onclick="initGame()"><span class="startBtn blinking">New<br>idea</span></button>
                    </div>
                </div>

                <div class="gameHoldBtn">
                    <button type="button" id="holdButton1" class="gameHoldItem ghTarget" onclick="holdButtonToggler(1)" disabled>
                        <img src="img/lock_open.svg" id="lock1" class="lock-icon">
                    </button>
                    <button type="button" id="holdButton2" class="gameHoldItem ghNeed" onclick="holdButtonToggler(2)" disabled>
                        <img src="img/lock_open.svg" id="lock2" class="lock-icon">
                    </button>
                    <button type="button" id="holdButton3" class="gameHoldItem ghGenre" onclick="holdButtonToggler(3)" disabled>
                        <img src="img/lock_open.svg" id="lock3" class="lock-icon">
                    </button>
                    <button type="button" id="holdButton4" class="gameHoldItem ghDesign" onclick="holdButtonToggler(4)" disabled>
                        <img src="img/lock_open.svg" id="lock4" class="lock-icon">
                    </button>
                    <button type="button" id="holdButton5" class="gameHoldItem ghLearning" onclick="holdButtonToggler(5)" disabled>
                        <img src="img/lock_open.svg" id="lock5" class="lock-icon">
                    </button>
                </div>

                <div id="infoModal" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="close">&times;</span>
                            <h2 id="modal-header-name">Information</h2>
                        </div>
                        <div class="modal-body" id="modal-body-id"></div>
                        <div class="modal-footer">
                            <h3></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="gameHoldInfo">Click on the rollers to see detailed information.</h4>    
            </div>
        </section>

        <section class="sectionIdea">
            <div class="idea">
                <div class="ideaGrid">
                    <h2 class="ideaHeading">Idea:</h2>
                    <p id="ideaText" class="ideaText"></p>
                </div>
                <h3>Do you want to make such a game?</h3>
            </div>
        </section>

        <section class="sectionMenu">
            <div class="menu">
                <ul class="menuList">
                    <a href="#description" class="menuItem js-scroll-nav"><li>About</li></a>
                    <span class="menuDivide">╱</span>
                    <a href="#apply" class="menuItem js-scroll-nav"><li>Apply</li></a>
                    <span class="menuDivide">╱</span>
                    <a href="#contact" class="menuItem js-scroll-nav"><li>Contacts</li></a>
                    <span class="menuDivide">╱</span>
                    <a href="#credits" class="menuItem js-scroll-nav"><li>Credits</li></a>
                    <span class="menuDivide">╱</span>
                    <li class="menuItem menuMute" id="sound" onclick="muteAudio()">Mute</li>
                </ul>
            </div>
        </section>

        <section class="descriptionBg">
            <div class="descriptionGrid">
                <div id="description" class="description">
                    <div class="descriptionHeading">About DLG</div>
                    <p class="descriptionInfo"><b>Digital Learning Games</b> (DLG) is a 2 year international postgraduate programme in the Tallinn University. DLG is unique in its interdisciplinary nature - it combines technology, art, pedagogy and psychology in order to create a meaningful and engaging experience. Our objective is to bring together people with different backgrounds: programmers, artists, teachers, psychologists, and everybody who is interested in digital innovation and creating games in a team. To learn from the best and from each other, and have fun. The study language is English and graduates will receive an MSc degree</p>
                    <img id="myImg" src="img/dlg-short.png" class="dlgShort" alt="Digital Learning Games programme">
                    <div id="myModal" class="modal_2">
                        <span class="close_2">&times;</span>
                        <img class="modal-content_2" id="img01">
                        <div id="caption_2"></div>
                    </div>
                    <h4 class="descriptionProgram">Click on the diagram to see the full programme.</h4>
                </div>
            </div>
        </section>

        <section class="applyBg">
            <div class="applyGrid">
                <div id="apply" class="apply">
                    <div class="applyHeading">Apply</div>
                    <p class="applyInfo">Admissions open: <b>January 10.</b><br>
                    Deadline for non-EU: <b>April 1.</b><br>
                    Deadline for Turkey, Russia, Ukraine, Georgia: <b>June 1.</b><br>
                    Deadline for EU/EEA: <b>July 1.</b><br>
                    Deadline for Estonia: <b>July 4.</b><br>
                    The tuition fee is 1250 € per semester.<br><br><a href="https://estonia.dreamapply.com/courses/course/375-msc-digital-learning-games" target="_blank" class="applyBtn">Apply here</a></p>
                </div>
            </div>
        </section>

        <section class="contactBg">
            <div class="contactGrid">
                <div id="contact" class="contact">
                    <div class="contactHeading">Contacts</div>
                    <p class="contactInfo">Tallinn University<br>School of Digital Technologies<br>A421, Narva mnt 25, 10120 Tallinn, Estonia<br>
                        <img src="img/phone.svg" class="socialmediaIcons smIconsSmall">+372 640 9421<br>
                        <a href="mailto:dlg@tlu.ee"><img src="img/email.svg" class="socialmediaIcons smIconsSmall">dlg@tlu.ee</a><br>
                        <a href="http://www.tlu.ee/en/dlg" target="_blank"><img src="img/web.svg" class="socialmediaIcons">www.tlu.ee/en/dlg</a><br>
                        <a href="https://www.facebook.com/digitallearninggames/" target="_blank"><img src="img/facebook.svg" class="socialmediaIcons">www.facebook.com/digitallearninggames</a>
                    </p>
                </div>
            </div>
        </section>

        <section class="creditsBg"></div>
            <div class="creditsGrid">
                <div id="credits" class="credits">
                    <div class="creditsHeading">Credits</div>
                    <p class="creditsInfo">This webpage was created by the Tallinn University Computer science first year bachelor students in the framework of Software Development Practice and ordered by the DLG masters programme.<br>
                    Team Members:
                        <ul class="creditsTeam">
                            <li class="creditsTeamMember">K. Kipper - front-end and project management</li>
                            <li class="creditsTeamMember">K. Luks and K. Roots - front-end</li>
                            <li class="creditsTeamMember">K. Liim and N. Salong - back-end</li>
                            <li class="creditsTeamMember">Mikhail Fiadotau (lector of DLG) - conceptual design</li>
                            <li class="creditsTeamMember">Martin Sillaots (associate professor of DLG) - idea author</li>
                        </ul>
                    </p>
                </div>
            </div>
        </section>

        <script src="./gamejs/modal.js"></script>
        <script src="./gamejs/modal2.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="gamejs/scroll.js"></script>
    </body>
</html>


