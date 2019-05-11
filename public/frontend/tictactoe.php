<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>Tic Tac Toe</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">   
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.css"/> 
        <link rel="stylesheet" href="../styles/tictactoe.css" type="text/css" media="screen" charset="utf-8">
    </head>

    <body>
        <header class="showcase">
            <div class="content animated bounceInLeft">
                <div class="logo">
                    <a href="../frontend/tictactoe.php">
                        <img src="../assets/vitalimages/ttt.png" alt="TicTacToe" width="40" height="40">
                        <h1>Tic Tac Toe</h1>
                    </a>
                </div>

                <table id="board" class="board">
                    <tr>
                        <td id="one" class="even"></td>
                        <td id="two"></td>
                        <td id="three" class="even"></td>
                    </tr>
                    <tr>
                        <td id="four"></td>
                        <td id="five" class="even"></td>
                        <td id="six"></td>
                    </tr>
                    <tr>
                        <td id="seven" class="even"></td>
                        <td id="eight"></td>
                        <td id="nine" class="even"></td>
                    </tr>
                </table>

                <table id="anotherBoard" class="board">
                    <tr>
                        <td id="one" class="even"></td>
                        <td id="two"></td>
                        <td id="three" class="even"></td>
                    </tr>
                    <tr>
                        <td id="four"></td>
                        <td id="five" class="even"></td>
                        <td id="six"></td>
                    </tr>
                    <tr>
                        <td id="seven" class="even"></td>
                        <td id="eight"></td>
                        <td id="nine" class="even"></td>
                    </tr>
                </table>

                <table id="thirdBoard" class="board">
                    <tr>
                        <td id="one" class="even"></td>
                        <td id="two"></td>
                        <td id="three" class="even"></td>
                    </tr>
                    <tr>
                        <td id="four"></td>
                        <td id="five" class="even"></td>
                        <td id="six"></td>
                    </tr>
                    <tr>
                        <td id="seven" class="even"></td>
                        <td id="eight"></td>
                        <td id="nine" class="even"></td>
                    </tr>
                </table>

                <div class="title">
                    <a href="../frontend/overlay.php"><img src="../assets/vitalimages/logo.gif" alt="TicTacToe" width="30" height="40"></a>
                </div>
                <div class="text">
                    <a href="../frontend/home.php">More Games</a>
                </div>
            </div>
        </header>
        
        <script src="http://code.jquery.com/jquery-1.5.1.js" type="text/javascript" charset="utf-8"></script>
        <script src="../javascript/jquery.tictactoe.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                $("#board, #anotherBoard").tictac().css("border", "1px solid #CC0000");
                $("#anotherBoard").tictac().css("border", "1px solid #00CC00");
                var thirdBoard = $("#thirdBoard").tictac();
                thirdBoard.css("border", "1px solid #0000CC");
            });
        </script>
  </body>
</html>