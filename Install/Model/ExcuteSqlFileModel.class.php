<?php
 namespace Install\Model;
 class ExcuteSqlFileModel  {
	protected $path='';
	public $fileContent='';
	public function __construct($path){
		$this->path=$path;
	}
	
	public function readSqlFile(){
		$fileContent=file_get_contents($this->path);
		if($fileContent !== false){
			$this->fileContent=$fileContent;
			return true;
		}
		return false;
	}
	
    public function sql_split($sql, $prefixed) {

    if ($prefixed != "baidu_")
        $sql = str_replace("baidu_", $prefixed, $sql);
    $sql = str_replace("\r", "\n", $sql);
    $ret = array();
    $num = 0;
    $queriesarray = explode(";\n", trim($sql));
    unset($sql);
	$sqlArray=array();
    foreach ($queriesarray as $query) {
        $ret[$num] = '';
        $queries = explode("\n", trim($query));
        $queries = array_filter($queries);
        foreach ($queries as $query) {
            $str1 = substr($query, 0, 1);
            if ($str1 != '#' && $str1 != '-' && $str1!='/')
                $ret[$num] .= $query;
        }
		if(!empty($ret[$num])){
				   $sqlArray[]=$ret[$num];
			   }
        $num++;
    }
    return $sqlArray;
}
	
}

