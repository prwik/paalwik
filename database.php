<?php

class dbManager {
	private $ProjName = array();
	private $ProjDesc = array();
	private $ProjPict = array();
	private $ProjCode = array();
	private $ProjCdLg = array();
	private $ProjComm = array();

	private $db_conn;

	function __construct() {
		$this->db_conn = $this->sql_connect();
		$this->create_arrays();
	}

	private function sql_connect() {
		$HOST = "";
		$UNAME = "";
		$PASS = "";
		$DB_NAME = "";
		$DB_conn = mysqli_connect($HOST, $UNAME, $PASS, $DB_NAME);

		if (mysqli_connect_errno()) {
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
  		}
  		return $DB_conn;
	}

	private function create_arrays() {
		$query = "SELECT * FROM `Projects`";
		$result = mysqli_query($this->db_conn, $query);

		while ($row = mysqli_fetch_array($result)) {
  			array_push($this->ProjName, $row['ProjectName']);
  			array_push($this->ProjDesc, $row['Description']);
  			array_push($this->ProjPict, $row['Pictures']);
  			array_push($this->ProjCode, $row['Code']);
  			array_push($this->ProjCdLg, $row['Code_Language']);
  			array_push($this->ProjComm, $row['Comments']);
		}
	}

	public function print_projects() {
		for($i = 0; $i < count($this->ProjName); $i++) {
  			echo "<h2>" . $this->ProjName[$i] . "</h2>" . "\n";
  			if (strlen($this->ProjPict[$i]) > 0) {
    			echo "<img src=\"" . $this->ProjPict[$i] . "\">\n";
 	 		}
  			echo "<p>" . $this->ProjDesc[$i] . "</p>\n";
  			if (strlen($this->ProjCode[$i]) > 0) {
    			echo "<h3>Code</h3>\n";
    			echo "<div class=\"code\">\n";
    			echo "<pre><code class=\"language-" . $this->ProjCdLg[$i] . "\">\n" . $this->ProjCode[$i] . "\n</code></pre>\n";
    			echo "</div>\n";
  			}
  			echo "<h3>Comments</h3>";
  			$this->print_comments($this->ProjComm[$i]);
  			$this->print_form($this->ProjName[$i]);
  			echo "<br><br>\n";
		}
	}

	private function print_comments($comments) {
		$comm_array = explode("|;", $comments);
		for ($i = 0; $i < count($comm_array) - 1; $i++) {
			$comment = explode("|:", $comm_array[$i]);
			echo "<div class=\"comments\">\n";
			echo "<h3>" . $comment[0] . "</h3>\n";
			echo "<p>" . $comment[1] . "</p>\n";
			echo "</div>\n";
		}
	}

	private function print_form($project) {
		echo "<div class=\"comments\">\n";
		echo "<form name=\"CommentForm\" action=\"projects.php\" method=\"post\">\n";
		echo "Name:<br>\n";
    	echo "<input type=\"text\" name=\"name\" placeholder=\"Your name\"><br>\n";
    	echo "E-mail (This will be hidden, just for contact purposes):<br>\n";
    	echo "<input type=\"email\" name=\"email\" placeholder=\"Your e-mail\"><br>\n";
    	echo "<input type=\"hidden\" name=\"project\" value=\"" . $project . "\">\n";
    	echo "Comment:<br>\n";
    	#Remember to change the text area to CSS style instead of inline html.
    	echo "<textarea maxlength=\"500\" cols=\"70\" rows=\"7\" name=\"comment\" placeholder=\"Your comment\"></textarea>\n";
    	echo "<br><br>\n";
    	echo "<input type=\"submit\" name=\"submit\" value=\"Post\">";
    	echo "</form>\n";
    	echo "</div>\n";
	}

	public function post_comment() {
		$query = "SELECT `Comments` FROM `Projects` WHERE `ProjectName` = " . "'" . $_POST["project"] . "'";
		$result = mysqli_query($this->db_conn, $query);

		// Should only be one line of results, no loop required.
		$row = mysqli_fetch_array($result);
		$new_comment = $row[0] . $_POST["name"] . "|:" . $_POST["comment"] . "|;";

		// Insert query
		$query = "UPDATE `Projects` SET `Comments` = " . "'" . addslashes($new_comment) . "'" . " WHERE `ProjectName` = " . "'" . $_POST["project"] . "'";
		mysqli_query($this->db_conn, $query);
	}
}


?>