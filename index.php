<?php

require_once 'header.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'quadras':
        require_once 'quadras.php';
        break;
    case 'sepulturas':
        echo "<h1>Sepulturas</h1><p>Em desenvolvimento.</p>";
        break;
    case 'falecidos':
        echo "<h1>Falecidos</h1><p>Em desenvolvimento.</p>";
        break;
    default:
        echo "<h1>Bem-vindo ao SGS</h1><p>Selecione uma opção no menu para começar.</p>";
        break;
}

require_once 'footer.php';