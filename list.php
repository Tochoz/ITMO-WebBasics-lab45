<?php
require "connect_db.php";
$query = "SELECT * FROM items";
$stmt = $db->prepare($query);
try {
    $stmt->execute();
    $items = $stmt->fetchAll();
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Denis Novik</title>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="script" href="script.js">
        <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
        <link rel="manifest" href="img/favicon/site.webmanifest">

    </head>
    <body>
    <ul class="header container">
        <li class="header-item">Home</li>
        <li class="header-item">About me</li>
        <li class="header-item">Skills</li>
        <li class="header-item">Portfolio</li>
        <li class="header-item">Contacts</li>
        <a class="header-item header-item_accent" href="create.php">Append work</a>
    </ul>
    <main>
        <div class="main-screen container">
            <div class="main-info">
                <div class="main-title">Denis Novik</div>
                <div class="main-subtitle">UX | UI designer<br>24 years old, Minsk</div>
            </div>
            <img class="main-img" src="img/1.png">
        </div>
        <div class="about-screen">
            <div class="about-title">About me</div>
            <div class="about-content"><p class="about">
                    Hi, I'm Denis – UX/UI designer from Minsk.<br>
                    I'm interested in design and everything connected with it.<br>
                </p>
                <p class="about">I'm studying at courses "Web and mobile design
                    interfaces" in IT-Academy.<br>
                </p>
                <p class="about">Ready to implement excellent projects
                    with wonderful people.
                </p>
            </div>
        </div>
        <div class="skills-screen container">
            <div class="skills-title">Skills</div>
            <div class="skills-subtitle">I work in such programs as</div>
            <div class="skills-programs">
                <div class="skill-card">
                    <img class="card-icon" src="img/PS.svg">
                    <div class="card-title">Adobe<br>Photoshop</div>
                    <div class="card-rate">
                        <img class="star" src="img/Star.svg">
                        <img class="star" src="img/Star.svg">
                        <img class="star" src="img/Star.svg">
                        <img class="star" src="img/Star.svg">
                        <img class="star" src="img/StarGray.svg">
                    </div>
                </div>
                <div class="skill-card">
                    <img class="card-icon" src="img/AI.svg">
                    <div class="card-title">Adobe<br>Illustrator</div>
                    <div class="card-rate">
                        <img class="star" src="img/Star.svg">
                        <img class="star" src="img/Star.svg">
                        <img class="star" src="img/Star.svg">
                        <img class="star" src="img/StarGray.svg">
                        <img class="star" src="img/StarGray.svg">
                    </div>
                </div>
                <div class="skill-card">
                    <img class="card-icon" src="img/AAE.svg">
                    <div class="card-title">Adobe<br>After Effects</div>
                    <div class="card-rate">
                        <img class="star" src="img/Star.svg">
                        <img class="star" src="img/Star.svg">
                        <img class="star" src="img/Star.svg">
                        <img class="star" src="img/Star.svg">
                        <img class="star" src="img/StarGray.svg">
                    </div>
                </div>
                <div class="skill-card">
                    <img class="card-icon" src="img/Figma.svg">
                    <div class="card-title">Figma</div>
                    <div class="card-rate">
                        <img class="star" src="img/Star.svg">
                        <img class="star" src="img/Star.svg">
                        <img class="star" src="img/Star.svg">
                        <img class="star" src="img/Star.svg">
                        <img class="star" src="img/StarGray.svg">
                    </div>
                </div>
            </div>
        </div>
        <div class="portfolio-screen container">
            <div class="portfolio-title">Portfolio</div>
                <div class="portfolio-works">
                <?php

                if (!count($items)){
                    echo '<div class="main-subtitle" style="text-align: center;">Right now I do not have works in my portfolio.<br>They are going to appear soon!</div>';
                } else {



                    foreach ($items as $item) {?>
                        <div class="portfolio-work" id="work-<?= $item['id'] ?>">
                            <img class="work-img" src="data:image/jpeg;base64,<?=base64_encode($item['img'])?>">
                            <a class="work-title" href="index.php?id=<?=$item['id']?>"><?= $item['title'] ?></a>
                        </div>
                        <?php
                        }
                    }
                ?>
            </div>
        </div>
        <div class="contacts-screen container">
            <div class="contacts-title">Contacts</div>
            <div class="contacts-subtitle">Want to know more or just chat?<br>You are welcome!</div>
            <div class="contacts-button">Send message</div>
            <div class="links-icons">
                <img class="links-icon" src="img/link1.svg">
                <img class="links-icon" src="img/link2.svg">
                <img class="links-icon" src="img/link3.svg">
                <img class="links-icon" src="img/link4.svg">
            </div>
            <div class="links-text">Like me on<br>LinkedIn, Instagram, Behance, Dribble</div>
        </div>
    </main>
    </body>
    </html>


<?php
}catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "<br>";
}
?>

