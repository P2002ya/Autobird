<?php 

	class autobird	{
		private $gid;
		private $gname;
		private $gaddress;
		private $lat;
		private $lng;
		private $conn;
		private $tableName = "garege";

		function setId($gid) { $this->id = $gid; }
		function getId() { return $this->id; }
		function setName($gname) { $this->name = $gname; }
		function getName() { return $this->name; }
		function setAddress($gaddress) { $this->address = $gaddress; }
		function getAddress() { return $this->address; }	
		function setLat($lat) { $this->lat = $lat; }
		function getLat() { return $this->lat; }
		function setLng($lng) { $this->lng = $lng; }
		function getLng() { return $this->lng; }

		public function __construct() {
			require_once('DbConnect.php');
			$conn = new DbConnect;
			$this->conn = $conn->connect();
		}

		public function getCollegesBlankLatLng() {
			$sql = "SELECT * FROM garege WHERE lat IS NULL AND lng IS NULL";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		public function getAllColleges() {
			$sql = "SELECT * FROM garege";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		public function updateCollegesWithLatLng() {
			$sql = "UPDATE $this->tableName SET lat = :lat, lng = :lng WHERE gid = :gid";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':lat', $this->lat);
			$stmt->bindParam(':lng', $this->lng);
			$stmt->bindParam(':gid', $this->id);

			if($stmt->execute()) {
				return true;
			} else {
				return false;
			}
		}
	}

?>