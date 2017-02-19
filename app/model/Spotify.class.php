<?php

class Db {
  private static $_instance = null;
  private $conn;

  private function __construct() {
    $host     = DB_HOST;
    $database = DB_DATABASE;
    $username = DB_USER;
    $password = DB_PASS;

    $conn = mysql_connect($host, $database, $username, $password)
        or die ('Error: Could not connect to MySQL database');

    mysql_select_db($database);
  }

  public static function instance() {
    if (self::$_instance === null) {
      self::$_instance = new Db();
    }

    //display proposed songs from a selected playlist
    public function getPlaylistSongs($playlistID) {
      if ($playlistID !== null) {
        $query = sprintf("SELECT * from proposed_votes WHERE playlist_id = '%s';",
          $playlistID
        );
        //echo $query;
        $result = $this->lookup($query);

        if(!mysql_num_rows($result)) {
          return null;
        } else {
          $row = mysql_fetch_assoc($result);
          $obj = new $class_name($row);
          return $obj;
        }
      }
    }

    //returns the votes a specific user has made
    public function getUsersVotes($songID, $playlistID, $userID) {
      if(($songID !== null) && ($playlistID !== null) && ($userID !== null)) {
        $query = sprintf("SELECT decision from vote_record WHERE song_id = '%s' AND playlist_id = '%s' AND user_id = '%s' AND decision != 2;",
          $songID,
          $playlistID,
          $userID
        );

        //echo $query
        $result = $this->lookup($query);

        if(!mysql_num_rows($result)) {
          return null;
        } else {
          $row = mysql_fetch_assoc($result);
          $obj = new $class_name($row);
          return $obj;
        }
      }
    }

    //returns the net of song votes and the percent of votes (positive)
    public function getNetAndPercentVotes($playlistID, $songID) {
      if (($playlistID !== null) && (songID !== null)) {
        $queryYes = sprintf("SELECT decision from vote_record WHERE song_id = '%s' AND playlist_id = '%s' AND decision = 1;"
          $songID,
          $playlistID
        );

        //echo $queryYes

        $queryNo = sprintf("SELECT decision from vote_record WHERE song_id = '%s' AND playlist_id = '%s' AND decision = 0;"
          $songID,
          $playlist_id
        );

        //echo $queryNo

        $resultYes = $this->lookup($queryYes);
        $resultNo = $this->lookup($queryNo);

        if(!mysql_num_rows($resultYes)) {
          return null;
        } else {
          $NumYesVotes = mysql_num_rows($resultYes)
          $NumNoVotes = mysql_num_rows($resultNo)
          $NetVotes = $NumYesVotes - $NumNoVotes
          $PercentVotes = $NumYesVotes / ($NumYesVotes + $NumNoVotes)
          return $NetVotes, $PercentVotes
        }
      }
    }

}
