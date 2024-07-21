<?php
require_once('../_app/Config.ini.php');

$payload = [
    'iat' => time(), // Timestamp de quando o token foi emitido
    'exp' => time() + 3600, // Timestamp de expiração (1 hora no futuro)
    'sub' => 12345, // ID do usuário
    'name' => 'John Doe', // Nome do usuário
    'role' => 'admin' // Papel ou função do usuário
];

$jwt = new JWT();
$jwt->encode($payload);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>API Documentation</h1>
        <input type="text" id="search" placeholder="Search documentation...">
    </header>
    <main>
        <section id="introduction">
            <h2>Introduction</h2>
            <p>Welcome to the API documentation. Here you will find all the information you need to use our API.</p>
        </section>
        <section id="authentication">
            <h2>Authentication</h2>
            <p>The API uses Bearer token authentication. For version 3, we use JWT (JSON Web Tokens).</p>
        </section>
        <section id="endpoints">
            <h2>API Endpoints</h2>
            <div class="endpoint">
                <h3>Version 1</h3>
                <p>Endpoint: <code>/api/v1/movies</code></p>
                <p>Method: <code>GET</code></p>
                <p>Parameters:</p>
                <ul>
                    <li><code>filter</code> - Filter movies by title</li>
                    <li><code>sort</code> - Sort by title (asc or desc)</li>
                    <li><code>page</code> - Page number</li>
                    <li><code>pageMax</code> - Number of movies per page</li>
                </ul>
            </div>
            <div class="endpoint">
                <h3>Version 2</h3>
                <p>Endpoint: <code>/api/v2/movies</code></p>
                <p>Method: <code>GET</code></p>
                <p>Parameters:</p>
                <ul>
                    <li><code>filter</code> - Filter movies by title</li>
                    <li><code>sort</code> - Sort by title (asc or desc)</li>
                    <li><code>page</code> - Page number</li>
                    <li><code>pageMax</code> - Number of movies per page</li>
                    <li><code>output</code> - Output format (json or xml)</li>
                </ul>
            </div>
            <div class="endpoint">
                <h3>Version 3</h3>
                <p>Endpoint: <code>/api/v3/movies</code></p>
                <p>Method: <code>GET</code></p>
                <p>Parameters:</p>
                <ul>
                    <li><code>filter</code> - Filter movies by title</li>
                    <li><code>sort</code> - Sort by title (asc or desc)</li>
                    <li><code>page</code> - Page number</li>
                    <li><code>pageMax</code> - Number of movies per page</li>
                </ul>
                <p>Authentication:</p>
                <ul>
                    <li>Use JWT (JSON Web Tokens) for authentication.</li>
                </ul>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>