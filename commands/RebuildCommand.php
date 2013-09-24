<?php
	function runningOnWindows()
	{
		return (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');
	}

	function pth($path)
	{
		return str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
	}

	function getPhpPath()
	{
		if (runningOnWindows()) return "php";
		else return '/usr/bin/php';
	}

	function runCommand($command)
	{
		if (!runningOnWindows())
			$command .= ' 2>&1';
		$result = array ();
		exec ($command, $result);
		foreach($result as $row) echo $row, "\n";
	}

class RebuildCommand extends CConsoleCommand
{

    public function getHelp()
	{
		return <<<EOD
USAGE
   php yiic.php rebuild
DESCRIPTION
   Rebuilds the entire database to a zero starting point.
   Then imports the base sql file located under application/migrations/base.sql
   Then applies all the migrations
EOD;
	}


	/**
	 * Execute the action.
	 * @param array command line parameters specific for this command
	 */
	public function actionIndex()
	{		
		$dbName = DB_NAME;

		$db = new CDbConnection(DB_DRIVER.":host=".DB_HOST . DB_EXTRA, DB_USER, DB_PASS);
		$db->active = true;

		$dbs = $db->createCommand("show databases")->queryAll();
		if(in_array (array ('Database' => $dbName), $dbs))
		{
			echo "\nStop!\n\nThis will completely destroy the existing database ".$dbName."\n\nAre you sure? (Yes/No) ";
			if (strcasecmp(trim(fgets(STDIN)), 'Yes') != 0)
			{
				echo "Cancelled by the user\n";
				Yii::app()->end();
			}

			echo "Destroying existing database ".$dbName."...";
			$db->createCommand("drop database ".$dbName)->execute();
			
			echo " Done\n";
		}

		echo "Creating new database ".$dbName."...";
		$db->createCommand("create database ".$dbName)->execute();
		echo " Done\n";

		$db->active = false;
		$db = new CDbConnection(CONNECTION_STRING, DB_USER, DB_PASS);
		$db->active = true;

		$baseSqlFile = Yii::getPathOfAlias('application.migrations').'/base.sql';
		if(file_exists($baseSqlFile) && file_get_contents($baseSqlFile)) {
			echo "Importing base.sql...";
			$statements = explode(';', file_get_contents($baseSqlFile));
			foreach($statements as $statement) {
				if(!trim($statement)) {
					continue;
				}
				
				echo sprintf("Applying: '%s'\n", trim($statement));
				
				$db->pdoInstance->exec(trim($statement));
			}
			echo " Done\n";
		} else {
			echo sprintf("The base sql file '%s' is missing or empty.\n", $baseSqlFile);
		}

		echo "\n";

		echo "Running migrations...\n";
		runCommand(getPhpPath()." ".Yii::getPathOfAlias('application.yiic').".php migrate --interactive=0 ");
		
		echo "\nDone!\n";
		
    }

}
