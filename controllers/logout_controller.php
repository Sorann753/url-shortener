<?php
unset($_SESSION['user']);
header('Location: index.php?page=home');
exit();
