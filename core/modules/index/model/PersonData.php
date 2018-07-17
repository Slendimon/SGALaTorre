<?php
class PersonData {
	public static $tablename = "person";
	public function PersonData(){
		$this->title = "";
		$this->email = "";
		$this->image = "";
		$this->password = "";
		$this->is_public = "0";
		$this->created_at = "NOW()";	
	}



	public function add(){
		$sql = "insert into ".self::$tablename." (name,lastname,address,phone,email,canal,turno,tipo_person,user_id,created_at,c1_fullname,c1_address,c1_phone,c1_note,dni) ";
		$sql .= "value (\"$this->name\",\"$this->lastname\",\"$this->address\",\"$this->phone\",\"$this->email\",\"$this->canal\",\"$this->turno\",\"$this->tipo_person\",$this->user_id,$this->created_at,\"$this->c1_fullname\",\"$this->c1_address\",\"$this->c1_phone\",\"$this->c1_note\",\"$this->dni\")";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

// partiendo de que ya tenemos creado un objecto PersonData previamente utilizamos el contexto
	public function update_active(){
		$sql = "update ".self::$tablename." set last_active_at=NOW() where id=$this->id";
		Executor::doit($sql);
	}


	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\",lastname=\"$this->lastname\",address=\"$this->address\",phone=\"$this->phone\",email=\"$this->email\",canal=\"$this->canal\",turno=\"$this->turno\",tipo_person=\"$this->tipo_person\",c1_fullname=\"$this->c1_fullname\",c1_address=\"$this->c1_address\",c1_phone=\"$this->c1_phone\",c1_note=\"$this->c1_note\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new PersonData());
	}


	public static function getAll(){
		$sql = "select * from ".self::$tablename." where tipo_person='0'"." order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PersonData());
	}


	public static function getAllUnActive(){
		$sql = "select * from client where last_active_at<=date_sub(NOW(),interval 3 second)";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PersonData());
	}

	public static function getAlumn($buscar){
		$sql = "select * from ".self::$tablename." where tipo_person='0'".$buscar;
		?>
			<script>console.log("<?php echo $sql;?>");</script>
		<?php
		$query = Executor::doit($sql);
		return Model::many($query[0],new AssistanceData());
	}
	


	public function getUnreads(){ return MessageData::getUnreadsByClientId($this->id); }


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where title like '%$q%' or email like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PersonData());
	}

	public static function SearchAlum($nombre){
		$sql = "select * from ".self::$tablename." where tipo_person='0' and concat(name,' ',lastname) like '%".$nombre."%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new AssistanceData());
	}


}

?>