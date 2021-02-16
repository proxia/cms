<?php
class User_extend extends CMS_user {
	public static function getNumberLoginName($login,$id = 0){
if ($id == 0){
		$sql =<<<SQL
		SELECT
			*
		FROM
			`users`
		WHERE
			`login` = '$login'
SQL;
}

if ($id > 0){
		$sql =<<<SQL
		SELECT
			*
		FROM
			`users`
		WHERE
			`login` = '$login' AND `id` != $id
SQL;
}

		$query = new CN_SqlQuery($sql);
		
		$query->execute();
		
		return $query->getSize();
	}

}
?>