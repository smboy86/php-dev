<?php
	// $connect_db = mysqli_connect('co-star.kr', 'brofeel', 'zzing!brofeel') or die('MySQL Connect Error!!!');
	// $select_db  = sql_select_db('costar_dev', $connect_db) or die('MySQL DB Error!!!');
	// var_dump('aaa');
	// sql_set_charset('utf8', $connect_db);

// ------------------ DB 연동 ------------------------
	$db['host'] = "co-star.kr";
	$db['name'] = "costar_dev";
	$db['user'] = "brofeel";
	$db['pass'] = "zzing!brofeel";
	$db['port'] = "3306";

	try{
    	// MySQL PDO 객체 생성
    	$dbconn = new PDO('mysql:host='.$db['host'].';dbname='.$db['name'].';charset=utf8', $db['user'], $db['pass']);
		
    	// 에러 출력
    	$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
		
		
	}
	catch(Exception $e) {
	    echo 'Failed to obtain database handle : '.$e->getMessage();
	}

// ------------------ DB 조회 ------------------------

	// $sql="select * from costar_dev.OustersSkillSave";
	// $stmt = $dbconn->prepare($sql);
	// $stmt->execute();

// ------------------ 데이터 확인 ------------------------

	// $stmt->setFetchMode(PDO::FETCH_ASSOC); // PDO::FETCH_ASSOC, PDO::FETCH_NUM
	
	// while($row= $stmt->fetch()) {
	//     echo $row['OwnerID'].' | ';
	//     echo $row['SkillType'];
	// }

	$skillArray = array(1,2,3);

	$sql="SELECT * FROM `OustersSkillSave` WHERE `OwnerID` = :Name AND `SkillType` in (".join(',', $skillArray).")";
	// $sql="SELECT * FROM `OustersSkillSave` WHERE `OwnerID` = :Name AND `SkillType` in ( 1, 2, 3)";

	$stmt = $dbconn->prepare($sql);
	$stmt->bindValue(':Name', 'smboy86');

	if($stmt->execute()){
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		var_dump(count($result));
		
		foreach($result as $row){
			var_dump('INSERT INTO `OustersSkillSave` (`OwnerID`,`SkillType`) VALUES ('.$row['OwnerID'].','.$row['SkillType'].'); <br>');
		}
		
		// foreach($result as $row){
		// 	echo $row['OwnerID'].' : ';
		// 	echo $row['SkillType'].'<br>';
		// }
	} else {
		echo "데이터 조회 없음";
	}

?>