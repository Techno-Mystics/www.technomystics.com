

<header class="mx-auto p-3 w-100">
	<div>
		<h3 class="float-md-start mb-0"><img src="/media/pics/technomystic.png" height="100px"></h3>
		<nav class="nav nav-masthead justify-content-center float-md-end">
			<a class="nav-link" id="m_home" aria-current="page" href="/">Home</a>
			<a class="nav-link" id="m_social" target="_blank" href="https://social.technomystics.com">Social</a>
			<a class="nav-link" id="m_discourse" target="_blank" href="https://discourse.technomystics.com">Discourse</a>
			<a class="nav-link" id="m_matrix" target="_blank" href="https://matrix.to/#/#the-lodge:matrix.technomystics.com">Matrix</a>
			<a class="nav-link" id="m_mail" target="_blank" href="/mail">Mail</a>
			<a class="nav-link" id="m_stats" href="/stats.php">Stats</a>
			<a class="nav-link" id="m_about" href="/about.php">About</a>
			<a class="nav-link" id="m_donate" href="/donate/">Donate</a>

			<?php
				if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
					error_log("header.php: Logged In User: ".$_SESSION['username']);
					$avatar_url = $_SESSION['avatar'];
					$username = $_SESSION['username'];
					$avatar_html = <<<EOF

					<a class="nav-link" id="m_avatar" href="https://social.technomystics.com/@$username">
						<img style="border-radius: 50%;" src="$avatar_url" width="30px">
					</a>
					
EOF;

					echo $avatar_html;
				}
				else{
					$avatar_html = <<<EOF
					<a class="nav-link" id="m_avatar" href="/oauth">
						<i class="fas fa-user-astronaut" style="font-size:30px;color:#e3bb7e;"></i>
					</a>
					
EOF;

					echo $avatar_html;
				}
			?>
		</nav>
	</div>
</header>
