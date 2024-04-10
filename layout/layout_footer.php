<aside>
		<h2>Navegação</h2>
		<ul>
		<?php

		include_once(realpath('comum.php'));
		
		if ( is_session_started() === FALSE ) {
			session_start();
		}	
		
        // Menu de navegação : mostra sempre

		echo "<li><a href='index.php'>Home</a></li>";

		if(isset($_SESSION["user_name"])) {
			// Menu de navegação : só mostra se logado
			echo "<li>";
			echo "<a href='usuarios.php'>Usuários</a>";
			echo "</li>";
		} 
	    ?>
		</ul>
	</aside>

	<footer>
		<p>Loja PHP : 2021</p>
	</footer>

</body>

</html>