<?php

class Controller
{
    private $db;
    private $jwt;
    private $bearerToken = BEARER_TOKEN;
    private $result;

    private $users = [
        ['username' => 'user1', 'password' => 'password1'], // Exemplos de usuários
        ['username' => 'user2', 'password' => 'password2'],
    ];

    public function __construct()
    {
        $this->db = Conn::getInstance()->getConnection();
        $this->jwt = new JWT();
    }

    public function getResult()
    {
        return $this->result;
    }

    public function handleRequest($version, $params)
    {
       
        switch ($version):
            case 'v1':
                $this->getMoviesV1($params);
                break;
            case 'v2':
                $this->getMoviesV2($params);
                break;
            case 'v3':
                $this->getMoviesV3($params);
                break;
            case 'register':
                    $this->register($params);
                break;
            default:
                http_response_code(404);
                $this->result = ['error' => 'Version not found'];
                break;
        endswitch;
    }

    private function getMoviesV1($params)
    {
        if (!$this->validateBearerToken($this->getAuthorizationHeader())) {
            http_response_code(401);
            $this->result = ['error' => 'Unauthorized'];
        } else {
            $this->fetchMovies($params);
        }
    }

    private function getMoviesV2($params)
    {
        if (!$this->validateBearerToken($this->getAuthorizationHeader())) {
            http_response_code(401);
            $this->result = ['error' => 'Unauthorized'];
        } else {
            $this->fetchMovies($params);

            if ($params['output'] === 'xml') {
                $this->convertToXML();
            }
        }
    }

    private function getMoviesV3($params)
    {
        if (!$this->validateJWTToken($this->getAuthorizationHeader())) {
            http_response_code(401);
            $this->result = ['error' => 'Unauthorized'];
        } else {
            $this->fetchMovies($params);
        }
    }

    private function fetchMovies($params)
    {
        $filter = $params['filter'] ?? '';
        $sort = $params['sort'] ?? API_SORT_DEFAULT;
        $page = (int) ($params['page'] ?? API_PAGE_DEFAULT);
        $limit = (int) ($params['limit'] ?? API_LIMIT_DEFAULT);

        $offset = ($page - 1) * $limit;

        $query = "SELECT * FROM movies WHERE title LIKE :filter ORDER BY title $sort LIMIT :limit OFFSET :offset";
        $queryParams = [
            ':filter' => "%$filter%",
            ':limit' => $limit,
            ':offset' => $offset
        ];

        try {
            $read = new Read();
            $read->fullQuery($query, $queryParams);
            $this->result = empty($read->getResult()) ? ['error' => "empty movies with: {$filter}"] : $read->getResult();
        } catch (Exception $e) {
            http_response_code(404);
            $this->result = ['error' => 'Internal error'];
        }
    }

    private function register($params)
    {
        $username = $params['username'] ?? '';
        $password = $params['password'] ?? '';

        foreach ($this->users as $user) {
            if ($user['username'] === $username && $user['password'] === $password) {
                $token = $this->jwt->encode(['username' => $username]);
                $this->result = ['token' => $token];
                return;
            }
        }

        http_response_code(401);
        $this->result = ['error' => 'Invalid credentials'];
    }

    private function validateBearerToken($authHeader)
    {
        return $authHeader === 'Bearer ' . $this->bearerToken;
    }

    private function validateJWTToken($token)
    {
        $token = str_replace('Bearer ', '', $token);
        return $this->jwt->decode($token) !== false;
    }

    private function convertToXML()
    {
        $xml = new \SimpleXMLElement('<movies/>');
        foreach ($this->getResult() as $movie) {
            $movieXML = $xml->addChild('movie');
            foreach ($movie as $key => $value) {
                $movieXML->addChild($key, htmlspecialchars($value));
            }
        }

        $this->result = $xml->asXML();
    }

    private function getAuthorizationHeader()
    {
        if (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            if (isset($headers['Authorization'])) {
                return $headers['Authorization'];
            }
        }

        return $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    }
}
