<?php

class MovieController
{
    private $db;
    private $jwt;
    private $bearerToken = BEARER_TOKEN; // Token Bearer from v1 e v2
    private $result;

    public function __construct()
    {
        $this->db = Conn::getInstance()->getConnection();
        $this->jwt = new JWT(BEARER_TOKEN);
    }

    public function getResult()
    {
        return $this->result;
    }

    public function handleRequest($version, $params)
    {
        switch ($version) {
            case 'v1':
                $this->getMoviesV1($params);
            break;
            case 'v2':
                $this->getMoviesV2($params);
            break;
            case 'v3':
                $this->getMoviesV3($params);
            break;
            default:
                http_response_code(404);
                $this->result = ['error' => 'Version not found'];
            break;
        }
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
                return $this->result = $this->convertToXML();
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
        $sort = $params['sort'] ?? 'asc';
        $page = (int) ($params['page'] ?? 1);
        $limit = (int) ($params['limit'] ?? 10);

        $offset = ($page - 1) * $limit;

        try {
            $stmt = $this->db->prepare("SELECT * FROM movies WHERE title LIKE :filter ORDER BY title $sort LIMIT :limit OFFSET :offset");

            $stmt->bindValue(':filter', "%$filter%", PDO::PARAM_STR);
            $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $this->result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            http_response_code(404);
            $this->result = ['error' => 'Internal error'];
        }
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
        return $xml->asXML();
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
