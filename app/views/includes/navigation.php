<?php

$initials = null;
$title = null;

if (isset($_SESSION["username"]))
	$initials = $_SESSION["username"][0];
if(isset($_SESSION["title"]))
	$title = $_SESSION["title"];

?>

<nav class="side-nav" id="sideNav">
	<ul>
		<li>
			<a>
				<span class="nav-icon"><ion-icon name="leaf-outline"></ion-icon></span>
				<span class="nav-title"><span>Bio</span>Cluster</span>
			</a>
		</li>
		<li>
			<a title="Dashboard" href="<?php echo URLROOT; ?>/dashboard">
				<span class="nav-icon"><ion-icon name="home-outline"></ion-icon></span>
				<span class="nav-title">Dashboard</span>
			</a>
		</li>
		<li>
			<a title="Courses" href="<?php echo URLROOT; ?>/courses">
				<span class="nav-icon"><ion-icon name="school-outline"></ion-icon></span>
				<span class="nav-title">Courses</span>
			</a>
		</li>
		<li>
			<a title="Glossary" href="<?php echo URLROOT; ?>/glossary">
				<span class="nav-icon"><ion-icon name="book-outline"></ion-icon></span>
				<span class="nav-title">Glossary</span>
			</a>
		</li>
		<li>
			<a title="Notes" href="<?php echo URLROOT; ?>/notes">
				<span class="nav-icon"><ion-icon name="document-text-outline"></ion-icon></span>
				<span class="nav-title">Notes</span>
			</a>
		</li>
		<li>
			<a title="Chats" href="<?php echo URLROOT; ?>/chats">
				<span class="nav-icon"><ion-icon name="chatbubbles-outline"></ion-icon></span>
				<span class="nav-title">Chats</span>
			</a>
		</li>
		<li>
			<a title="Forums" href="<?php echo URLROOT; ?>/forums">
				<span class="nav-icon"><ion-icon name="terminal-outline"></ion-icon></span>
				<span class="nav-title">Forums</span>
			</a>
		</li>
		<li>
			<a title="Settings" href="<?php echo URLROOT; ?>/settings/">
				<span class="nav-icon"><ion-icon name="settings-outline"></ion-icon></span>
				<span class="nav-title">Settings</span>
			</a>
		</li>
	</ul>
</nav>
<main>
	<nav class="top-nav">
		<ul class="left-panel">
			<div id="burgerToggle" class="burger-toggle">
				<div class="burger-line"></div>
				<div class="burger-line"></div>
				<div class="burger-line"></div>
			</div>
			<h1 class="page-title"><?php echo $_SESSION["title"]; ?></h1>
		</ul>
		<ul class="right-panel">
			<li>
				<a title="Notifications" href="#">
					<span class="nav-icon"><ion-icon name="notifications-outline"></ion-icon></span>
				</a>
			</li>
			<li>
				<a href="<?php echo URLROOT; ?>/pages/index">
					<span class="nav-icon" title="Profile">
						<div class="nav-profile" ><?php echo(strtoupper($initials)); ?></div>
					</span>
				</a>
			</li>
			<li>
				<a title="Log out" href="<?php echo URLROOT; ?>/users/logout">
					<span class="nav-icon"><ion-icon name="log-out-outline"></ion-icon></span>
				</a>
			</li>
		</ul>
	</nav>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<script>
	const burger = document.getElementById("burgerToggle");
	const sideNav = document.getElementsByClassName("side-nav")[0];
	const topNav = document.getElementsByClassName("top-nav")[0];
	const main = document.querySelectorAll("main")[0];

	burger.addEventListener("click", (e) => {
		sideNav.classList.toggle('active-nav');
		main.classList.toggle('active-nav');
		topNav.classList.toggle('active-nav');
	});

	var current = location.pathname;
	var list = document.querySelectorAll("#sideNav ul li a");
	list.forEach((item)=> {
		// if the current path is like this link, make it active
		if (item.href.indexOf(current) !== -1){
			item.parentElement.classList.toggle('active-page');
		}
	})
</script>
