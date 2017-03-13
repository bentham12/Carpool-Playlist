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

    //fixed
    //display proposed songs and metadata from a selected playlist
    //returns songID, song name, album cover url, artist name, and album name
    public function getPlaylistSongs($playlistID) {
      if ($playlistID !== null) {
        $query = sprintf("SELECT playlistsong.song_id_fk,
             songs.Name,
             songs.AlbumCover,
             songs.Artist,
             album.Name,
             FROM playlistsong,
              songs,
              album
             WHERE playlistsong.playlist_id_fk = '%s'
             AND playlistsong.song_id_fk = songs.ID
             AND songs.AlbumCover = album.Name;",
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

    //fixed
    //returns the votes a specific user has made
    public function getUsersVotes($playlistID, $userID) {
      if(($songID !== null) && ($playlistID !== null) && ($userID !== null)) {
        $query = sprintf("SELECT vote_record.decision from vote_record, playlistsong WHERE playlistsong.playlist_id_fk = '%s' AND playlistsong.playlist_song_id = vote_record.playlist_song_id AND vote_record.user_id = '%s' AND decision != 2;",
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

    //fixed
    //returns the net of song votes and the percent of votes (positive)
    public function getNetAndPercentVotes($playlistID, $songID) {
      if (($playlistID !== null) && (songID !== null)) {
        $playlistSongID = $playlistID . $songID;

        $queryYes = sprintf("SELECT decision from vote_record WHERE vote_record.playlist_song_id = '%s' AND decision = 1;"
          $playlistSongID
        );

        //echo $queryYes

        $queryNo = sprintf("SELECT decision from vote_record WHERE vote_record.playlist_song_id = '%s' AND decision = 0;"
          $playlistSongID
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

    //fixed
    //add a vote to the proposed_votes table along with the user's vote (function does not return anything)
    public function ProposeVote($songID, $userID, $playlistID, $songName, $artistName, $albumSRC, $albumName) {
      if(($songID !== null) && ($userID !== null) && ($playlistID !== null) && ($songName !== null) && ($artistName !== null) && ($albumSRC !== null) && ($albumName !== null)) {

        $playlistSongID = $playlistID . $songID;

        $queryUpdate_vote_record = sprintf("INSERT INTO vote_record(user_id, decision, playlist_song_id) VALUES('%s', 1, '%s');"
          $userID,
          $playlistSongID
        );

        $queryUpdate_playlistsong = sprintf("INSERT INTO playlistsong(song_id_fk, playlist_id_fk, playlist_song_id) VALUES('%s', '%s', '%s');"
          $songID,
          $playlistID,
          $playlistSongID
        );

        $queryUpdate_songs = sprintf("INSERT INTO songs(ID, Name, AlbumCover, Artist) VALUES('%s', '%s', '%s', '%s');"
          $songID,
          $songName,
          $albumSRC,
          $artistName
        );

        $queryUpdate_album = sprintf("INSERT INTO album(Source, Name) VALUES('%s', '%s');"
          $albumSRC,
          $albumName
        );


        //echo $queryUpdate_vote_record
        //echo $queryUpdate_playlistsong
        //echo $queryUpdate_songs
        //echo $queryUpdate_album

        $resultUpdate_vote_record = mysql_query($queryUpdate_vote_record);
        $resultUpdate_playlistsong = mysql_query($queryUpdate_playlistsong);
        $resultUpdate_songs = mysql_query($queryUpdate_songs);
        $resultUpdate_album = mysql_query($queryUpdate_album);


        if(!$resultUpdate_vote_record) {
          $message = 'Invalid query in vote_record table: ' . mysql_error() . "/n";
          $message .= 'Whole query: ' . $queryUpdate_vote_record;
          die($message);
        }

        if(!$resultUpdate_playlistsong) {
          $message = 'Invalid query in the proposed_votes table: ' . mysql_error() . "/n";
          $message .= 'Whole query: ' . $queryUpdate_playlistsong;
          die($message);
        }

        if(!$resultUpdate_songs) {
          $message = 'Invalid query in the proposed_votes table: ' . mysql_error() . "/n";
          $message .= 'Whole query: ' . $queryUpdate_songs;
          die($message);
        }

        if(!$resultUpdate_album) {
          $message = 'Invalid query in the proposed_votes table: ' . mysql_error() . "/n";
          $message .= 'Whole query: ' . $queryUpdate_album;
          die($message);
        } else {
          return 0;
        }
      }
    }

    //fixed
    //change vote to Yes
    public function ChangeVoteYes($songID, $playlistID, $userID) {
      if(($songID !== null) && ($playlistID !== null) && (userID !== null)) {
        $query = sprintf("UPDATE vote_record SET vote_record.decision = 1 WHERE playlistsong.song_id_fk = '%s' AND playlistsong.playlist_id_fk = '%s' AND playlistsong.playlist_song_id = vote_record.playlist_song_id AND vote_record.user_id = '%s';"
          $songID,
          $playlistID,
          $userID
        );

        //echo $query

        $result = mysql_query($query);

        if(!$result){
          $message = 'Invalid query: ' . mysql_error() . "/n";
          $message .= 'Whole query: ' . $query;
        } else {
          return 0;
        }
      }
    }

    //fixed
    //change vote to No
    public function ChangeVoteNo($songID, $playlistID, $userID) {
      if(($songID !== null) && ($playlistID !== null) && (userID !== null)) {
        $query = sprintf("UPDATE vote_record SET vote_record.decision = 0 WHERE playlistsong.song_id_fk = '%s' AND playlistsong.playlist_id_fk = '%s' AND playlistsong.playlist_song_id = vote_record.playlist_song_id AND vote_record.user_id = '%s';"
          $songID,
          $playlistID,
          $userID
        );

        //echo $query

        $result = mysql_query($query);

        if(!$result){
          $message = 'Invalid query: ' . mysql_error() . "/n";
          $message .= 'Whole query: ' . $query;
        } else {
          return 0;
        }
      }
    }

    //fixed
    //change vote to Undecided
    public function ChangeVoteUndecided($songID, $playlistID, $userID) {
      if(($songID !== null) && ($playlistID !== null) && (userID !== null)) {
        $query = sprintf("UPDATE vote_record SET vote_record.decision = 2 WHERE playlistsong.song_id_fk = '%s' AND playlistsong.playlist_id_fk = '%s' AND playlistsong.playlist_song_id = vote_record.playlist_song_id AND vote_record.user_id = '%s';"
          $songID,
          $playlistID,
          $userID
        );

        //echo $query

        $result = mysql_query($query);

        if(!$result){
          $message = 'Invalid query: ' . mysql_error() . "/n";
          $message .= 'Whole query: ' . $query;
        } else {
          return 0;
        }
      }
    }
  }
}
