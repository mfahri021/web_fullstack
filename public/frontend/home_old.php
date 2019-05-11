<?php
    defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
    require_once '..' .DS. 'layouts' .DS. 'head.php';
?>
    
    <!-- showcase -->
    <section id="showcase" class="top-container">
        <div class="showcase showcase-left">
            <div id="arrow-left" class="arrow"></div>
            <div id="slider">
                <div class="slide slide1">
                    <div class="slide-content">
                        <h1>Pick Nick Face</h1>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit culpa soluta corrupti consequatur dolorem praesentium impedit dolorum vitae placeat quis!</p>
                        <a id="modalBtn" class="btn" href="#">Pick</a>

                        <div id="myModal" class="modal">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <span class="closeBtn">&times;</span>
                                    <h4>Pick a Face and a Nick</h4>
                                </div>
                                <div class="modal-body">
                                    <img src="../assets/vitalimages/male_1.png" height="150" width="100" alt="loading...">
                                    <img src="../assets/vitalimages/female_1.png" height="150" width="100" alt="loading...">
                                    <img src="../assets/vitalimages/male_2.png" height="150" width="100" alt="loading...">
                                    <img src="../assets/vitalimages/female_2.png" height="150" width="100" alt="loading...">
                                </div>
                                <div class="modal-footer">
                                    <a href="#" class="btnM">Aurangzeb</a>
                                    <a href="#" class="btnM">Shweta</a>
                                    <a href="#" class="btnM">Phanindra</a>
                                    <a href="#" class="btnM">YanJiao</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="slide slide2">
                    <div class="slide-content">
                        <h1>I am Lake</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero quam assumenda voluptate facilis incidunt recusandae rerum animi aliquam nisi tenetur?</p>
                        <a id="modalBtn" class="btn" href="#">View Lake</a>
                    </div>
                </div>

                <div class="slide slide3">
                    <div class="slide-content">
                        <h1>I am Bee</h1>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatem, repellendus voluptatum? Iure debitis tempora veritatis earum blanditiis neque vero nam.</p>
                        <a id="modalBtn" class="btn" href="#">View Bee</a>
                    </div>
                </div>
            </div>
            <div id="arrow-right" class="arrow"></div>
        </div>

        <!-- top box -->
        <div class="showcase-right top-box top-box-a">
            <h4>One Player</h4>
            <p class="pick">Tic-Tac-Toe</p>
            <a href="tictactoe.php" class="btn">Play</a>
        </div>
        <div class="showcase-right top-box top-box-b">
            <h4>Two Players</h4>
            <p class="pick">Tic-Tac-Toe</p>
            <a href="tictactoe.php" class="btn">Invite</a>
        </div>
    </section>

    <!-- cards -->
    <section id="cards" class="cards">
        <div class="card info-right">
            <i class="fas fa-chart-pie fa-4x"></i>
            <h3>Pick</h3>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odit, eum!</p>
        </div>
        <div class="card info-right">
            <i class="fas fa-globe fa-4x"></i>
            <h3>Face</h3>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odit, eum!</p>
        </div>
        <div class="card info-left">
            <i class="fas fa-cog fa-4x"></i>
            <h3>Nick</h3>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odit, eum!</p>
        </div>
        <div class="card info-left">
            <i class="fas fa-users fa-4x"></i>
            <h3>Game</h3>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odit, eum!</p>
        </div>
    </section>

    <!-- info -->
    <section id="info" class="info">
        <img class="info-left" src="../assets/vitalimages/wheat.jpg" alt="loading...">
        <div class="info-right">
            <h2>Pick Face Nick Game</h2>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Explicabo soluta, temporibus sed iusto at beatae unde recusandae natus labore cupiditate voluptates doloribus assumenda sapiente, excepturi rem distinctio cumque sit quos?</p>
            <a class="btn" href="#portfolio">Learn More</a>
        </div>
    </section>

    <!-- portfolio -->
    <section id="portfolio" class="portfolio">
        <div id="filter" class="filter-container">

        <?php
            $db = mysqli_connect("localhost", "root", "", "pickdb");
            $sql = "SELECT * FROM images";
            $result = mysqli_query($db, $sql);
            
            while ($row = mysqli_fetch_array($result)) {
        ?>
            <div class="filter-item">
            <!-- <img src="data:image/jpeg;base64,'.base64_encode( <?php echo $row['image'] ?> ).'"/> -->
        <?php  
            echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>'; 
            // echo "<p>".$row['text']."</p>";
            echo  "<a class='game-category' href='#'>".$row['text']."</a>"
        ?>
            </div>
        <?php
            }
        ?>
            
            <!-- <div class="filter-item">
                <img src="https://source.unsplash.com/random/200x201" alt="loading...">
                <a class="game-category" href="#">Race</a>
            </div>
            <div class="filter-item">
                <img src="https://source.unsplash.com/random/200x202" alt="loading...">
                <a class="game-category" href="#">Puzzle</a>
            </div>
            <div class="filter-item">
                <img src="https://source.unsplash.com/random/200x203" alt="loading...">
                <a class="game-category" href="#">Race</a>
            </div>
            <div class="filter-item">
                <img src="https://source.unsplash.com/random/200x204" alt="loading...">
                <a class="game-category" href="#">Action</a>
            </div>
            <div class="filter-item">
                <img src="https://source.unsplash.com/random/200x205" alt="loading...">
                <a class="game-category" href="#">Puzzle</a>
            </div>
            <div class="filter-item">
                <img src="https://source.unsplash.com/random/200x206" alt="loading...">
                <a class="game-category" href="#">Puzzle</a>
            </div>
            <div class="filter-item">
                <img src="https://source.unsplash.com/random/200x207" alt="loading...">
                <a class="game-category" href="#">Race</a>
            </div>
            <div class="filter-item">
                <img src="https://source.unsplash.com/random/200x208" alt="loading...">
                <a class="game-category" href="#">Action</a>
            </div>
            <div class="filter-item">
                <img src="https://source.unsplash.com/random/200x209" alt="loading...">
                <a class="game-category" href="#">Action</a>
            </div>
            <div class="filter-item">
                <img src="https://source.unsplash.com/random/200x210" alt="loading...">
                <a class="game-category" href="#">Puzzle</a>
            </div>
            <div class="filter-item">
                <img src="https://source.unsplash.com/random/200x211" alt="loading...">
                <a class="game-category" href="#">Race</a>
            </div> -->
        </div>
    </section>

    <!-- footer -->
    <?php require_once '..' .DS. 'layouts' .DS. 'foot.php'; ?>
