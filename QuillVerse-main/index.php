<html>
    <head>
        <title>QuillVerse</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
        <style>
            .dropdown {
                position: relative;
                display: inline-block;
            }
            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #333;
                min-width: 160px;
                box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
                z-index: 1;
            }
            .dropdown-content a {
                color: white;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
            }
            .dropdown:hover .dropdown-content {
                display: block;
            }
        </style>
    </head>
    <body bgcolor="black" style="color:white">
        <div id="main-header">
            <div class="container">
                <nav id="navbar">
                    <ul><b>
                        <li id="logo"><a href="Z:\WDL\hoempage.html">Quill Verse</a></li>
                        <?php
                        if (!isset($_COOKIE['user_id'])) {
                            echo '<li><a href="html/Registration.html" target="_blank">Sign Up</a></li>';
                            echo '<li><a href="html/login_page.html" target="_blank">Sign In</a></li>';
                        } else {
                            echo '<li class="dropdown">
                                    <a href="#">Blogs ▼</a>
                                    <div class="dropdown-content">
                                        <a href="php/read_blogs.php">Read Blogs</a>
                                        <a href="html/write_blog.html">Write a Blog</a>
                                    </div>
                                  </li>';
                            echo '<li><a href="php/profile.php">Profile</a></li>';
                            echo '<li><a href="php/sign_out.php">Sign Out</a></li>';
                        }
                        ?>
                    </b></ul>
                </nav>
            </div>
        </div>
        <div class="heading">
            <h1>WELCOME TO</h1>
            <b>
                <div class="inner">
                QuillVerse Blog platform<br />
                realm of limitless possibilities<br />
                intersection of passion and prose<br />
                a world of words and warmth<br />
                </div>
            </b>
        </div>
        <img id="img1" class="sliding-images" src="assets/img1.jpg" alt="Image 1">
        <img id="img2" class="sliding-images" src="assets/img2.jpg" alt="Image 2">
        <img id="img3" class="sliding-images" src="assets/img3.jpg" alt="Image 3">
        <img id="img4" class="sliding-images" src="assets/img4.jpg" alt="Image 4">
        <img id="img5" class="sliding-images" src="assets/img5.jpg" alt="Image 5">
        <img id="img6" class="sliding-images" src="assets/img6.jpg" alt="Image 6">
    </body>
</html>