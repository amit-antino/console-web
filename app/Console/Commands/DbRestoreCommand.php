<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DbRestoreCommand extends Command
{
  protected $signature = 'db_backup:restore';

  protected $description = 'This Command is for Restore Databse.';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    // define("BACKUP_PATH", public_path('/assets/backups/02_12_2021_simreka_dev.sql'));

    $restore_file  =  public_path('/assets/backups/02_12_2021_simreka_dev.sql');
    $server_name   = env('DB_HOST');
    $username      = env('DB_USERNAME');
    $password      = env('DB_PASSWORD');
    $database_name = env('DB_DATABASE');
    //$cmd = "mysql -h {$server_name} -u {$username} -p{$password} {$database_name} < $restore_file";

    // Name of the file
    $filename = $restore_file;
    // MySQL host
    $mysql_host = $server_name;
    // MySQL username
    $mysql_username = $username;
    // MySQL password
    $mysql_password = $password;
    // Database name
    $mysql_database = $database_name;
    //  $con = mysqli_connect("localhost","my_user","my_password","my_db");
    // Connect to MySQL server
    $con = mysqli_connect($mysql_host, $mysql_username, $mysql_password, $mysql_database) or die('Error connecting to MySQL server: ' . mysqli_error());
    // Select database
    // mysqli_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysqli_error());
    // Temporary variable, used to store current query
    $templine = '';
    // Read in entire file
    $lines = file($filename);
    // Loop through each line
    foreach ($lines as $line) {
      // Skip it if it's a comment
      if (substr($line, 0, 2) == '--' || $line == '')
        continue;
      // Add this line to the current segment
      $templine .= $line;
      // If it has a semicolon at the end, it's the end of the query
      if (substr(trim($line), -1, 1) == ';') {
        // Perform the query
        mysqli_query($con, $templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error() . '<br /><br />');
        // Reset temp variable to empty
        $templine = '';
      }
    }
    echo "Tables imported successfully";
    //  exec($cmd);
    return Command::SUCCESS;
  }
}
