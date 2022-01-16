<footer class="p-3 w-100">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item"><a href="https://github.com/Techno-Mystics/www.technomystics.com" class="nav-link px-2 text-muted">GitHub</a></li>
		<?php
			if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
				$logout_html = <<<EOF
				<li class="nav-item"><a href="/oauth/logout.php" class="nav-link px2 text-muted">Log Out</a></li>
EOF;
				echo $logout_html;
			}
		?>

    </ul>
    <p class="text-center text-muted">© 2022 TechnoMystics.com</p>
  </footer>
