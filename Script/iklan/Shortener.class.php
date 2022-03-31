<style>
.kosong{
  width: 280px;
  position: absolute;
  top: 40%;
  left: 50%;
  transform: translate(-50%,-50%);
  color: white;
}
</style>

<style>
.formatsalah{
  width: 280px;
  position: absolute;
  top: 40%;
  left: 50%;
  transform: translate(-50%,-50%);
  color: white;
}
</style>

<style>
.gakadaurl{
  width: 280px;
  position: absolute;
  top: 40%;
  left: 50%;
  transform: translate(-50%,-50%);
  color: white;
}
</style>



<style>
.short1{
  width: 280px;
  position: absolute;
  top: 40%;
  left: 50%;
  transform: translate(-50%,-50%);
  color: white;
}
</style>

<style>
.short2{
  width: 280px;
  position: absolute;
  top: 40%;
  left: 50%;
  transform: translate(-50%,-50%);
  color: white;
}
</style>

<style>
.short3{
  width: 280px;
  position: absolute;
  top: 40%;
  left: 50%;
  transform: translate(-50%,-50%);
  color: white;
}
</style>


<?php
class Shortener
{
    protected static $chars = "abcdfghjkmnpqrstvwxyz|ABCDFGHJKLMNPQRSTVWXYZ|0123456789";
    protected static $table = "tb_short_url";
    protected static $checkUrlExists = false;
    protected static $codeLength = 6;

    protected $pdo;
    protected $timestamp;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
        $this->timestamp = date("Y-m-d H:i:s");
    }

    public function urlToShortCode($url){
        if(empty($url)){
            throw new Exception("<div class='kosong'><center>Tidak ada URL yang diberikan.</center></div>");
        }

        if($this->validateUrlFormat($url) == false){
            throw new Exception("<div class='formatsalah'><center>URL tidak memiliki format yang valid.</center></div>");
        }

        if(self::$checkUrlExists){
            if (!$this->verifyUrlExists($url)){
                throw new Exception("<div class='gakadaurl'><center>URL tidak ditemukan.</center></div>");
            }
        }

        $shortCode = $this->urlExistsInDB($url);
        if($shortCode == false){
            $shortCode = $this->createShortCode($url);
        }

        return $shortCode;
    }

    protected function validateUrlFormat($url){
        return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
    }

    protected function verifyUrlExists($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return (!empty($response) && $response != 404);
    }

    protected function urlExistsInDB($url){
        $query = "SELECT short_code FROM ".self::$table." WHERE url_asli = :url_asli LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $params = array(
            "url_asli" => $url
        );
        $stmt->execute($params);

        $result = $stmt->fetch();
        return (empty($result)) ? false : $result["short_code"];
    }

    protected function createShortCode($url){
        $shortCode = $this->generateRandomString(self::$codeLength);
        $id = $this->insertUrlInDB($url, $shortCode);
        return $shortCode;
    }

    protected function generateRandomString($length = 6){
        $sets = explode('|', self::$chars);
        $all = '';
        $randString = '';
        foreach($sets as $set){
            $randString .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++){
            $randString .= $all[array_rand($all)];
        }
        $randString = str_shuffle($randString);
        return $randString;
    }

    protected function insertUrlInDB($url, $code){
        $query = "INSERT INTO ".self::$table." (url_asli, short_code, ditambahkan) VALUES (:url_asli, :short_code, :timestamp)";
        $stmnt = $this->pdo->prepare($query);
        $params = array(
            "url_asli" => $url,
            "short_code" => $code,
            "timestamp" => $this->timestamp
        );
        $stmnt->execute($params);

        return $this->pdo->lastInsertId();
    }

    public function shortCodeToUrl($code, $increment = true){
        if(empty($code)) {
            throw new Exception("<div class='short1'><center>Tidak ada short code yang diberikan.</center></div>");
        }

        if($this->validateShortCode($code) == false){
            throw new Exception("<div class='short2'><center>Short code tidak memiliki format yang valid.</center></div>");
        }

        $urlRow = $this->getUrlFromDB($code);
        if(empty($urlRow)){
            throw new Exception("<div class='short3'><center>Short code tidak ditemukan.</center></div>");
        }

        if($increment == true){
            $this->incrementCounter($urlRow["id"]);
        }

        return $urlRow["url_asli"];
    }

    protected function validateShortCode($code){
        $rawChars = str_replace('|', '', self::$chars);
        return preg_match("|[".$rawChars."]+|", $code);
    }

    protected function getUrlFromDB($code){
        $query = "SELECT id, url_asli FROM ".self::$table." WHERE short_code = :short_code LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $params=array(
            "short_code" => $code
        );
        $stmt->execute($params);

        $result = $stmt->fetch();
        return (empty($result)) ? false : $result;
    }

    protected function incrementCounter($id){
        $query = "UPDATE ".self::$table." SET hits = hits + 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $params = array(
            "id" => $id
        );
        $stmt->execute($params);
    }
}
