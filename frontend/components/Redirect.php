<?php
/**
 * @author walter
 */

namespace frontend\components;

class Redirect {

    protected $currentUrl;

    protected $dbParams = [];
    protected $defaultHostKey = 'mysql:host';
    protected $defaultDatabaseKey = 'dbname';

    public function __construct()
    {
        $this->currentUrl = $this->getCurrentUrl();
    }

    public function make()
    {
        $this->toLowerCaseRedirect();
        $this->removeSlashFromEnd();
        $this->usersRedirects();
    }

    protected function toLowerCaseRedirect()
    {
        $camelCaseInUrl = preg_match('|[A-Z]|', $this->currentUrl);

        if ($camelCaseInUrl)
            $this->doRedirect(strtolower($this->currentUrl));
    }

    protected function removeSlashFromEnd()
    {
        if ($this->getShortUrl() != '/' && substr($this->currentUrl, -1) == '/')
            $this->doRedirect(substr($this->currentUrl, 0, -1));
    }

    protected function usersRedirects()
    {
        $to = $this->urlInUsersRedirects();
        if($to)
            $this->doRedirect($to);
    }

    protected function urlInUsersRedirects()
    {
        $toUrl = $this->getUrlFromCache();
        if(!$toUrl)
        {
            $toUrl = $this->setUrlToCache();
        }
        if($toUrl)
        {
            return $toUrl;
        }
        return false;
    }

    protected function getCurrentUrl()
    {
        return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    protected function getShortUrl()
    {
        return "$_SERVER[REQUEST_URI]";
    }

    protected function doRedirect($toUrl)
    {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location:{$toUrl}");
        exit();
    }

    protected function getUrlFromCache()
    {
        $cache = new \Cache([
            'path' => __DIR__ . '/../runtime/redirectCache/',
            'name' =>'default',
            'extension' => '.cache',
        ]);
        return $cache->retrieve($this->currentUrl);
    }

    protected function setUrlToCache()
    {
        $url = $this->findUrlFromDB();
        $cache = new \Cache([
            'path' => __DIR__ . '/../runtime/redirectCache/',
            'name' =>'default',
            'extension' => '.cache',
        ]);
        $cache->store($this->currentUrl, $url);
        return $url;
    }

    protected function findUrlFromDB()
    {
        $mysqli = $this->setupDbConnection();

        $query = "SELECT `to` FROM {$this->getTableName()} WHERE `from`=?"
            . " AND is_active=1 ORDER BY updated_at DESC LIMIT 1;";

        if ($stmt = $mysqli->prepare($query)) {
            $from = $this->currentUrl;
            $stmt->bind_param("s", $from);
            $stmt->execute();
            $stmt->bind_result($to);
            $stmt->fetch();
            $stmt->close();
        }
        $mysqli->close();
        if(isset($to))
            return $to;
        return false;
    }

    protected function setupDbConnection()
    {
        $this->setDbParams();
        if(count($this->dbParams) > 0)
        {
            $mysqli = new \mysqli($this->dbParams['host'], $this->dbParams['username'], $this->dbParams['password'], $this->dbParams['database']);
            if ($mysqli->connect_errno) {
                return false;
            }
            return $mysqli;
        }
        return false;
    }

    protected function setDbParams()
    {
        $config = $this->getYiiAppConfig();
        if($config)
        {
            $db = $config['components']['db'];
            $this->dbParams = $this->parseDsn($db['dsn']);

            $this->dbParams['username'] = $db['username'];
            $this->dbParams['password'] = $db['password'];
            if(isset($db['tablePrefix']))
                $this->dbParams['tablePrefix'] = $db['tablePrefix'];
        }
    }

    protected function getTableName()
    {
        $tableName = 'redirects';
        if(isset($db['tablePrefix']))
            $tableName = $db['tablePrefix'] . $tableName;
        return $tableName;
    }

    protected function parseDsn($dsn)
    {
        $array = array_map(
            function ($_) {
                return explode('=', $_);
            },
            explode(';', $dsn)
        );
        if (count($array) > 1) {
            $parseArray = [];
            foreach ($array as $index => $element) {
                $parseArray[$element[0]] = $element[1];
            }
            $parseDsn = [
                'host' => $parseArray[$this->defaultHostKey],
                'database' => $parseArray[$this->defaultDatabaseKey]
            ];
            return $parseDsn;
        }
        return false;
    }

    protected function getYiiAppConfig()
    {
        return array_merge(
            require(__DIR__ . '/../../common/config/main.php'),
            require(__DIR__ . '/../../common/config/main-local.php')
        );
    }

}