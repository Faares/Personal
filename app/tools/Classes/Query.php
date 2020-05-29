<?php

# Write Less do more stuff!

/**
 * How this class work?
 * like every software , this get the input , then store it in the class variable as Arrays or Strings
 * Before excute the Query , the class collect the data from the class variable , then BUILD query SYNTAX as string,
 * in the end , bind Parameters and excute it , mybe in the future support proccersing after the excute.
 * like :
 * 		- get first row ,
 * 		- get last row ,
 * 		- and whatever PDO object future..
 * 
 * three ware :
 * 	1 - get input,
 * 	2 - Collect,
 * 	3 - bind and excute
 * 	4 - proccesring after it.
 * */

namespace Classes;
/**
 * @param $type 'insert' | 'delete' | 'select' | 'query' | 'update'
 * 
 * 
 * */
class Query
{

	# The Connect variable
	protected $Connect;

	# The type of the qouery : select,insert,update..etc
	protected $type;

	# The final query (string) , use this to excute in PDO object
	protected $q;

	# error msg of the checkdata.
	protected $error;

	# The table.
	protected $table;

	# The columns selected
	protected $cols = array();

	# Where conditional
	protected $wheres = array();

	# Values of the insert query , use only with INSERT !
	protected $values = array();

	# table Joins to the main qouery
	protected $joins = array();

	# for set Vars in the qouer ..
	protected $vars = array();

	# unions qouery , every element must be (string) not OBJECT!
	protected $unions = array();

	# the limit .. [$from,$to]
	protected $limit = array();

	# ordery by [$Column,$type='ASC' or 'DESC'];
	protected $order = array();

	# GROUP BY ..
	protected $group;



	function __construct($type)
	{
		$this->Connect = $GLOBALS['DB_CONNECT'];
		switch (strtolower($type)) {
			case 'insert':
			case 'delete':
			case 'select':
			case 'update':
			case 'query':
				$this->type = $type;
				break;

			default:

				if(DEBUG_MODE)
					throw new \Exception("Unknow Query type",10) ;
				else
					die('Error');

				break;
		}
	}

	function __destruct()
	{
		# Free all data..
	}

	/**
	 * This function proccessing the input (always array, like : where , values , joing ..etc) then store it to his class variable.
	 * @param string $var the Class variable
	 * @param variable $param the parameter of the main fucntion @see Classes\Query::where or Classes\Query::vals
	 * @param int $paramNum the number of main function parameter's
	 * @param array $getArgs func_get_args() of the main function .
	 * @param int $arrCount the count of array elements
	 * @param string $funcName for debug , pass the main function name!
	 * */
	protected function storeToClassVariable($var,$param,$paramsNum,$getArgs,$arrCount,$funcName)
	{
		if(is_array($param)){
			if(isset($param[0]) && is_array($param[0]))
			{
				foreach ($param as $paramArr) {
					if(count($paramArr) == $arrCount)
						array_push($this->$var,$paramArr);
					else
						DEBUG_MODE ? die($funcName.' : array must have '.$arrCount.' elements,'.count($param).' givin.') : die('Error ..');
				}
			}
			else
			{
				if(count($param) == $arrCount)
					array_push($this->$var,$param);
				else
					DEBUG_MODE ? die($funcName.' : array must have '.$arrCount.' elements,'.count($param).' givin.') : die('Error ..');
			}
		}else{
			$num = $paramsNum;
			if($num != $arrCount)
				DEBUG_MODE ? die($funcName.' have '.$arrCount.' params at must and least, '.$num.' givin, or use 1 param as array : [$x,$rShip,$y]') : die('Error ..');
			array_push($this->$var,$getArgs);
		}
	}

	/**
	 * لتحديد صلاحية الوصول للدالة بحسب نوع الاستعلام .
	 * @param infinity , 1st is method name , others is queries types [select,insert..etc]
	 * */
	protected function useOnlyFor()
	{
		$num = func_num_args();
		if($num < 2)
			return false;

		$args = func_get_args();

		$funcName = array_shift($args);

		if(in_array($this->type,$args))
			return true;	

		return DEBUG_MODE ? die('Can\'t use '.$funcName.' with '.$this->type.' type .') : false;
	}


	public function table($t)
	{
		$this->table = $t;

		return $this;
	}

	public function cols()
	{
		if(!$this->useOnlyFor(__METHOD__,'select','insert','delete'))
			return false;

		$num = func_num_args();

		if($num <= 0)
			DEBUG_MODE ? die(__FUNCTION__.' have 1 param at least, 0 givin.') : die('Error ..');
		
		$args = func_get_args();

		$this->cols = $args;

		return $this;	
	}

	/**
	 * @param $w => default [$realshipoftheprevies,$x,$ship,$y] , more than one where condition ? [[$x,$ship,$y],[$x,$ship,$y]..etc]
	 * */
	public function where($w)
	{
		if(!$this->useOnlyFor(__METHOD__,'select','delete','update'))
			return false;

		$this->storeToClassVariable('wheres',$w,func_num_args(),func_get_args(),4,__METHOD__);
		return $this;
	}

	/**
	 * 
	 * @param string 	$tb 	table name
	 * @param string 	$tp 	join type @see $joinTypes
	 * @param array 	$on 	on conditions
	 * 
	 * @return object Query Objects
	 * */
	public function join($tb,$tp,array $on)
	{
		if(!$this->useOnlyFor(__METHOD__,'select'))
			return false;

		if(is_array($on)){

			// Check the count of array/arrays
			if(!is_array($on[0]) && count($on) != 3){
				return DEBUG_MODE ? die(__METHOD__.' : $on parameter must be array and have 3 elements .') : false;
			}else{
				# $e = element
				$map = array_map(function($e){
					return is_array($e) && count($e) == 3 ? true : false;
				},$on);

				if(in_array(false,$map))
					return DEBUG_MODE ? die(__METHOD__.' : $on parameter must be array , and every array has 3 element only! .') : false;

			}

			$joinTypes = ['default','inner','left','right','full'];
			$tp = strtolower($tp);
			if(in_array($tp,$joinTypes)){

				$this->joins[] = [$tb,$tp,$on];

			}else{
				return DEBUG_MODE ? die(__METHOD__.' : Unknown join type .') : false;
			}
		}else{
			return DEBUG_MODE ? die(__METHOD__.' $ON parameter must be array,'.getType($on).' givin.') : false;
		}

		return $this;
	}

	public function union($q)
	{
		if($q instanceof Query){
			if($q->type == 'select')
				$q = $q->build()->q;
			else
				return DEBUG_MODE ? die(__METHOD__.' : this function accept <b>select</b> query type only.') : false;
		}

		# set it to the unions variable.
		$this->unions[] = $q;

		return $this;
	}

	public function set($var,$val)
	{
		$this->vars[$var] = $val;
		return $this;
	}

	public function vals($v)
	{
		if(!$this->useOnlyFor(__METHOD__,'insert') || empty($this->cols))
			return false;

		$this->storeToClassVariable('values',$v,func_num_args(),func_get_args(),count($this->cols),__METHOD__);

		return $this;
	}

	public function limit($f,$t)
	{
		$this->limit = [$f,$t];

		return $this;
	}

	public function order($b,$t)
	{
		$this->order = [$b,$t];

		return $this;
	}

	public function group($b)
	{
		$this->group = $b;

		return $this;
	}


	protected function checkData()
	{
		if(empty($this->table))
			return DEBUG_MODE ? die('Where is table? .. get data from nothing?! .. baka!') : false;

		switch ($this->type) {
			case 'insert':
				if(!empty($this->values) && !empty($this->cols))
					return true;
				else
					$this->error = 'empty values, or empty cols.';
				break;
			
			case 'select':

				break;
			default:
				# code...
				break;
		}

		return false;
	}
	/**
	 * building Query before (PDO::prepare) and excute it, it's the main function of the engine.
	 * 
	 * */
	protected function build()
	{
		if(!$this->checkData())
			return DEBUG_MODE ? die('Missing Some Data... '.$this->error) : false;


		switch ($this->type) {

			case 'insert':
				

			# @todo , improve it , this is just a test.
				if(is_array($this->values[0])){
					for ($i=0; $i < count($this->values); $i++) { 
						$vals[] = '('.implode($this->values[$i],',').')';
					}
				}else{
					$vals = $this->values;
				}
				$this->q = "INSERT INTO {$this->table} (".implode($this->cols,',').") VALUES (".implode($vals,',').")";
				break;
			
			case 'delete':

				break;
			default:
				# code...
				break;
		}

		return $this;
	}

	public function exc()
	{
		print_r($this->wheres);
		$q = $this->build()->q;
		echo $q;
	}

}