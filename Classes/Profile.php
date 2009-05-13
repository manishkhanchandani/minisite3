<?php
class Profile {

	private $cacheSecs = CACHETIME;
	private static $instance;
	
	public function __construct($dbFrameWork, $Common) {
		if(self::$instance) {
			return self::$instance;
		} else {
			self::$instance = $this;
			$this->dbFrameWork = $dbFrameWork;
			$this->Common = $Common;
		}
	}
	public function viewHomePage($ID, $data, $settings) {
		return true;
	}
	
	public function getGeneralDetails($userId, $doCache) {
		$sql1 = "select * from users where user_id = '".$userId."'";
		$sql2 = "select * from profile1 WHERE user_id = '".$userId."'";
		$sql3 = "select * from profile2 WHERE user_id = '".$userId."'";
		if($doCache==1) {
			$record['users'] = $this->Common->selectCacheRecord($sql1);
			$record['profile1'] = $this->Common->selectCacheRecord($sql2);
			$record['profile2'] = $this->Common->selectCacheRecord($sql3);
		} else {
			$record['users'] = $this->Common->selectRecord($sql1);
			$record['profile1'] = $this->Common->selectRecord($sql2);
			$record['profile2'] = $this->Common->selectRecord($sql3);
		}
		
		$sql4 = "select * from city where city_id = '".$record['profile1'][0]['city_id']."'";
		$sql5 = "select * from zipcode where zipcode_id = '".$record['profile1'][0]['zipcode_id']."'";
		$sql6 = "select * from country where country_id = '".$record['profile1'][0]['country_id']."'";
		$sql7 = "select * from province where province_id = '".$record['profile1'][0]['province_id']."'";
		
		if($doCache==1) {
			$record['city'] = $this->Common->selectCacheRecord($sql4);
			$record['zipcode'] = $this->Common->selectCacheRecord($sql5);
			$record['country'] = $this->Common->selectCacheRecord($sql6);
			$record['province'] = $this->Common->selectCacheRecord($sql7);
		} else {		
			$record['city'] = $this->Common->selectRecord($sql4);
			$record['zipcode'] = $this->Common->selectRecord($sql5);
			$record['country'] = $this->Common->selectRecord($sql6);
			$record['province'] = $this->Common->selectRecord($sql7);
		}
		// get country list
		$record['countrys'] = $this->Common->getCountryList();
		
		return $record;
	}
	
	public function updateGeneralProfile($post, $userId) {
		if($post['city']) $post['city_id'] = $this->Common->getCityId($post['city']);
		if($post['province']) $post['province_id'] = $this->Common->getProvinceId($post['province']);
		if($post['zipcode']) $post['zipcode_id'] = $this->Common->getZipcodeId($post['zipcode']);
		if($post['name']) { 
			$postUser['name'] = $post['name'];
			$this->Common->phpedit('users', 'user_id', $postUser, $userId);
		}
		$this->Common->phpedit('profile1', 'user_id', $post, $userId);
		$this->Common->phpedit('profile2', 'user_id', $post, $userId);
	}
	
	public function createProfile1($userId) {
		$sql = "insert into profile1 set user_id = '".$userId."'";
		$rs = $this->dbFrameWork->Execute($sql); 
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->db->ErrorMsg());
		}
		return true;
	}
	
	public function createProfile2($userId) {
		$sql = "insert into profile2 set user_id = '".$userId."'";
		$rs = $this->dbFrameWork->Execute($sql); 
		if($this->dbFrameWork->ErrorMsg()) {
			throw new Exception($this->db->ErrorMsg());
		}
		return true;
	}
	
	public function deletePreviousImage($image) {
		if(file_exists($image)) {
			unlink($image);
		}
		return true;
	}
	
	public function browse($criteria, $max=10, $start=0) {
		switch($criteria) {
			case 'all':
			default:
				$fields = "users.user_id, users.name, profile2.image, profile1.gender, city.city, province.province, country.country";
				$cntFields = "count(users.user_id) as cnt";
				$condition = "FROM users LEFT JOIN profile1 on users.user_id = profile1.user_id LEFT JOIN profile2 on users.user_id = profile2.user_id LEFT JOIN city ON profile1.city_id = city.city_id LEFT JOIN province ON profile1.province_id = province.province_id LEFT JOIN country ON profile1.country_id = country.country_id WHERE users.deleted = 0 AND users.status = 1";
				$sql = "SELECT $fields $condition";
				$sqlCnt = "SELECT $cntFields $condition";
				$record = $this->Common->selectLimitRecordFull($sql, $sqlCnt, $max, $start);
				$record['browseTitle'] = "All Users";
				break;
		}		
		return $record;
	}
}
?>