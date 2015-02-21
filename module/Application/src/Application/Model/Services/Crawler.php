<?php

namespace Application\Model\Services;


class Crawler {

    private $adapter;

    public function __construct($adapter){
        $this->adapter = $adapter;
    }

    public function start(){
        $statement = $this->adapter->query("delete from urls");
        $statement->execute();

        $statement = $this->adapter->query("insert into urls (url) values ('http://www.terra.com.br/')");
        $statement->execute();

        $statement = $this->adapter->query("delete from emails");
        $statement->execute();
    }

    public function getUrls(){
        $sql = "select * from urls where visited='no'";
        $statement = $this->adapter->query($sql);
        try{
            $res = $statement->execute();

            return $res;
        }catch (\Exception $e){
            echo $e->getMessage(); exit;
        }
    }

    private function getExisteUrl($url){
        $sql = "select id from urls  where url='".$url."'";

        $statement = $this->adapter->query($sql);
        try{
            $res = $statement->execute();

            $id = false;
            foreach($res as $v){
                $id = $v["id"];
            }
            return $id;

        }catch (\Exception $e){
            echo $e->getMessage(); exit;
        }
    }

    private function getInsertUrl($url){

        $sql = "insert into urls (url)values('".$url."')";
        $statement = $this->adapter->query($sql);
        try{
            $statement->execute();
        }catch (\Exception $e){
            echo $e->getMessage(); exit;
        }
    }

    public function getEmail(){
        $sql = "select * from emails";
        $statement = $this->adapter->query($sql);
        try{
            $res = $statement->execute();

            return $res;
        }catch (\Exception $e){
            echo $e->getMessage(); exit;
        }
    }
    public function getCheckVisitedYes($url){
        $sql = "update urls set visited='yes' where url='".$url."'";
        $statement = $this->adapter->query($sql);
        try{
            $res = $statement->execute();

            return $res;
        }catch (\Exception $e){
            echo $e->getMessage(); exit;
        }
    }

    function crawler($url,$pattern){
        @$conteudo = file_get_contents($url);
        preg_match_all($pattern, $conteudo, $resultados);

        foreach($resultados as $res){
            foreach($res as $url){
                $url = $this->getClearUrl($url);
                if($this->getExisteUrl($url)==false){
                    $this->getInsertUrl($url);
                    $crawlerEmails = $this->getCrawlerEmails($url,'/\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i');
                    $this->saveEmail($crawlerEmails);
                    $this->getCheckVisitedYes($url);
                }
            }
        }
    }


    function saveEmail($crawlerEmails){
        foreach($crawlerEmails as $v){
            //verifica se existe antes de inserir
            $sql = "insert into emails (email) values('".$v."')";
            $statement = $this->adapter->query($sql);
            try{
                $res = $statement->execute();

                return $res;
            }catch (\Exception $e){
                echo $e->getMessage(); exit;
            }
        }
    }
    function getCrawlerEmails($url,$pattern){
        @$conteudo = file_get_contents($url);
        preg_match_all($pattern, $conteudo, $resultados);

        $data = array();

        foreach($resultados as $res){
            foreach($res as $res_i){
                $data[] = ($res_i);
            }
        }
        return $data;
    }
    private function getClearUrl($url){
        $url = str_replace('<a href="',"",$url);
        $url = str_replace('">',"",$url);
        return $url;
    }
}