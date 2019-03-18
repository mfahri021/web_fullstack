      <footer>
        <div class="container">
            <div class="footer-cols">
                <ul>
                    <li>PICK</li>
                    <li><a href='#'>Music</a></li>
                    <li><a href='#'>Movies</a></li>
                    <li><a href='#'>Shows</a></li>
                    <li><a href='#'>Apps</a></li>
                </ul>
        
                <ul>
                    <li>FACE</li>
                    <li><a href='#'>Find a Game</a></li>
                    <li><a href='#'>Today at Face</a></li>
                    <li><a href='#'>Summer Camp</a></li>
                </ul>
        
                <ul>
                    <li>CONTACT</li>
                    <li><a href='#'>About PickAFace</a></li>
                    <li><a href='#'>Contact Us</a></li>
                    <li><a href='#'>Jobs</a></li>
                </ul>
        
                <ul>
                    <li>DOWNLOAD</li>
                    <li><a href='#'>Resume</a></li>
                    <li><a href='#'>Flyer</a></li>
                    <li><a href='#'>Postcard</a></li>
                    <li><a href='#'>Terms & Conditions</a></li>
                </ul>
            </div>
        </div>

        <div class="social">
            <a href="facebook.com"><i class="fab fa-facebook"></i></a>
            <a href="google.com"><i class="fab fa-google"></i></a>
            <a href="twitter.com"><i class="fab fa-twitter"></i></a>
            <a href="github.com"><i class="fab fa-github"></i></a>
            <a href="youtube.com"><i class="fab fa-youtube"></i></a>
            <a href="linkedin.com"><i class="fab fa-linkedin"></i></a>
        </div>

        <div class="footer-bottom text-center">Copyright &copy; 2019 | PickFaceNick</div>
      </footer>

      <?php if(isset($alert_message)){ echo "<script>alert('" . $alert_message . "')</script>"; } ?>
      <script type="text/javascript" src=<?php echo "..".DS."javascript".DS."popup.js";?>></script>
      <script src="../javascript/main.js"></script>
    </div><!-- container end -->
      
    <!-- navbar dropdown toggle -->
    <script type="text/javascript">
        $(document).ready(function() {
            $(".toggle").on("click", function(){
            $("nav ul").toggleClass("showing");
            });
        });
    </script>
  </body>
</html>
