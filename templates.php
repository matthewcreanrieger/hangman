<?php

$registrationError = <<<EOD
            <div class="alert alert-danger" role="alert">There was an error registering your account.  Please try again.</div>
EOD;
$passwordMatchError = <<<EOD
            <div class="alert alert-danger" role="alert">The provided passwords do not match.</div>
EOD;
$usernameTakenError = <<<EOD
            <div class="alert alert-danger" role="alert">The username is already taken.</div>
EOD;
$userCreated = <<<EOD
            <div class="alert alert-success" role="alert">You've successfully created your account.  Proceed with login.</div>
EOD;
$loginError = <<<EOD
            <div class="alert alert-danger" role="alert">The provided credentials are incorrect.</div>
EOD;

$gameactive = <<<EOT
	<nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Semester Project</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active" onclick="resetGame(listID)"><a href="?hangman">New Game</a></li>
                        <li><a href="?leaderboard">Leaderboard</a></li>  
                    </ul>
EOT;

$leaderboardactive = <<<EOT
	<nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Semester Project</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li onclick="resetGame(listID)"><a href="?hangman">New Game</a></li>
                        <li class="active"><a href="?leaderboard">Leaderboard</a></li>  
                    </ul>
EOT;

$navbarHeader = <<<EOT
    <form action="hangman.php" method="post" class="navbar-form navbar-right">
									<div class="form-group">
								  		<input name="username" type="text" placeholder="Username" class="form-control">
									</div>
									<div class="form-group">
								  		<input name="password" type="password" placeholder="Password" class="form-control">
									</div>
									<button type="submit" class="btn btn-success">Sign in</button>
							 		<a href="?register" class="btn btn-primary">Register</a>
							</form>
                </div>
            </div>
        </nav>
EOT;


$loggedInNav = <<<EOT
    <p class="navbar-text navbar-right" >Logged in as ${_SESSION['username']}</p>
    						<br>
    						<a href="?endsession" class="navbar-form navbar-right btn btn-warning">Sign Out</a>
                </div>
            </div>
        </nav>
EOT;



$wins = getWins($_SESSION['username']);
$losses = getLosses($_SESSION['username']);
$mainContent = <<<EOT
	<div class="jumbotron text-center">
            <div class="container">
            	<br><br><br>
            	<img id="img" src="assets/0.png" alt="Hangman" width="250" height="250">
            	<h1 id="answer"></h1>
            	<h4 id="wins">Wins: $wins</h4>
            	<h4 id="losses">Losses: $losses</h4>
            </div>
        </div>
        <div class="container text-center">
            <div id="difficulty">
                <h3 class="lead">Select Difficulty</h3>
                <button id="easy" onclick='resetGame ("Easy")' class="btn-success">Easy</button>
					 <button id="medium" onclick='resetGame("Medium")'>Medium</button>
					 <button id="hard" onclick='resetGame("Hard")'>Hard</button>
				</div>
				<h3 class="lead">Select a letter to guess.</h3>
            <div id="letters">
                <button id="a" onclick="choice(this)">A</button>
					 <button id="b" onclick="choice(this)">B</button>
					 <button id="c" onclick="choice(this)">C</button>
					 <button id="d" onclick="choice(this)">D</button>
					 <button id="e" onclick="choice(this)">E</button>
					 <button id="f" onclick="choice(this)">F</button>
					 <button id="g" onclick="choice(this)">G</button>
					 <button id="h" onclick="choice(this)">H</button>
					 <button id="i" onclick="choice(this)">I</button>
					 <button id="j" onclick="choice(this)">J</button>
					 <button id="k" onclick="choice(this)">K</button>
					 <button id="l" onclick="choice(this)">L</button>
					 <button id="m" onclick="choice(this)">M</button>
					 <button id="n" onclick="choice(this)">N</button>
					 <button id="o" onclick="choice(this)">O</button>
					 <button id="p" onclick="choice(this)">P</button>
					 <button id="q" onclick="choice(this)">Q</button>
					 <button id="r" onclick="choice(this)">R</button>
					 <button id="s" onclick="choice(this)">S</button>
					 <button id="t" onclick="choice(this)">T</button>
					 <button id="u" onclick="choice(this)">U</button>
					 <button id="v" onclick="choice(this)">V</button>
					 <button id="w" onclick="choice(this)">W</button>
					 <button id="x" onclick="choice(this)">X</button>
					 <button id="y" onclick="choice(this)">Y</button>
					 <button id="z" onclick="choice(this)">Z</button>
            </div>
            <br><br><br>
        </div>
EOT;

$registerForm = <<<EOD
    <div class="container">
        <h1>Customer Registration Form</h1>
            <form action="hangman.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control" type="text" name="username" id="username">
                </div>
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input class="form-control" type="text" name="firstName" id="firstName">
                </div>
                <div class="form-group">
                    <label for="username">Last Name</label>
                    <input class="form-control" type="text" name="lastName" id="lastName">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password" id="password" placeholder="Enter password">
                    <input class="form-control" type="password" name="password2" id="password2" placeholder="Re-enter password">
                </div>
                <input class="btn btn-default" type="submit" name="signup" value="Register">
            </form>
    </div>
EOD;
