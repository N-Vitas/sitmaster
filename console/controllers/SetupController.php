<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;

/**
 *
 */
class SetupController extends \yii\console\Controller {
  public $migrations = [
        "./yii migrate/up --interactive=0 --migrationPath=@yii/rbac/migrations"
        , "./yii migrate/up --interactive=0 --migrationPath=@vendor/dektrium/yii2-user/migrations"
        , "./yii migrate/up  --interactive=0",
      ];

  function config(){
    $config['project']['name'] = Console::prompt($this->ansiFormat("Enter project name (new): ", Console::BG_PURPLE), ['required' => true]);
    $config['project']['url'] = Console::prompt($this->ansiFormat("Enter URL (new.local):    ", Console::BG_PURPLE), ['required' => true]);
    $config['mysql']['host'] = Console::prompt($this->ansiFormat("Mysql host (localhost):  ", Console::BG_PURPLE), ['required' => true, 'default' => 'localhost']);
    $config['mysql']['user'] = Console::prompt($this->ansiFormat("Mysql user (root):       ", Console::BG_PURPLE), ['required' => true, 'default' => 'root']);
    $config['mysql']['pwd'] = Console::prompt($this->ansiFormat("Mysql password:          ", Console::BG_PURPLE), []);
    $config['mysql']['dbname'] = Console::prompt($this->ansiFormat("Mysql DB:                ", Console::BG_PURPLE), []);

    return $config;
  }
  function actionIndex() {

    $config = $this->config();
    $project = $config['project'];
    $mysql = $config['mysql'];

    $connection = new \yii\db\Connection([
      'dsn' => "mysql:host={$mysql['host']};dbname={$mysql['dbname']}",
      'username' => $mysql['user'],
      'password' => $mysql['pwd'],
    ]);
    try {
      $connection->open();
    } catch (\yii\db\Exception $e) {

      if ($e->getCode() == 1049) {
        if ($this->confirm("Create DB '{$mysql['dbname']}'?")) {
          $cmd = "echo \"CREATE DATABASE {$mysql['dbname']} CHARACTER SET utf8 COLLATE utf8_general_ci\" | mysql -u{$mysql['user']} -p{$mysql['pwd']} ";
          echo $cmd."\n";
          exec($cmd);
        }
      } else {
        Console::error($this->ansiFormat($e->getMessage(), Console::FG_RED));
        exit(1);
      }
    }
    Console::output($this->ansiFormat("Project setting:", Console::BG_YELLOW));
    Console::output(json_encode($project, JSON_PRETTY_PRINT));
    Console::output($this->ansiFormat("DB setting:", Console::BG_YELLOW));
    Console::output(json_encode($mysql, JSON_PRETTY_PRINT));
    if ($this->confirm("All right?")) {
      echo $this->ansiFormat("Fine! Let's go further \n\n", Console::FG_GREEN);
      // Create params
      echo $this->ansiFormat("Create params...  ", Console::FG_BLUE);
      $params = "<?php
  return [
    'frontend-url'=>'f.{$project['url']}',
    'backend-url'=>'b.{$project['url']}',
  ];";
      file_put_contents(Yii::getAlias('@common/config/params-local.php'), $params);
      echo $this->ansiFormat(" Done! \n", Console::FG_GREEN);

      // Create symlinks
      echo $this->ansiFormat("Create symlinks...  ", Console::FG_BLUE);
      $path = exec('pwd');

      exec("ln -s $path/frontend/web ../f.{$project['url']}");
      if (!is_dir("$path/../{$project['url']}")) {
        // If default name is free, it will be for frontend
        exec("ln -s $path/frontend/web ../{$project['url']}");
      }
      exec("ln -s $path/backend/web ../b.{$project['url']}");      
      exec("ln -s $path/api/web ../api.{$project['url']}");
      echo $this->ansiFormat(" Done! \n", Console::FG_GREEN);

      // Set DB params
      echo $this->ansiFormat("\nSet DB params...  ", Console::FG_BLUE);
      file_put_contents(Yii::getAlias('@common/config/main-local.php'), $this->dbConfig($mysql));
      echo $this->ansiFormat(" Done! \n", Console::FG_GREEN);



      foreach ($this->migrations as $key => $migration) {
        exec($migration);
        Console::updateProgress($key + 1, count($this->migrations));
      }
      Console::endProgress($this->ansiFormat("Migration Done! \n", Console::FG_GREEN) . PHP_EOL);

      echo $this->ansiFormat("\nInit repository...  \n", Console::FG_BLUE);
      exec("git init -q");
      exec("git add .");
      exec("git commit -mFirst_commit");
      echo $this->ansiFormat("Done! \n", Console::FG_GREEN);

      Console::output($this->ansiFormat(
        "// Push on gitlab manually
        git remote add origin git@github.com:N-Vitas/sitmaster.git
        git push -u origin master
        ",
        Console::BG_YELLOW));

      Console::output($this->ansiFormat("Opening http://b.{$project['url']}... ", Console::BG_YELLOW));
      exec("x-www-browser http://b.{$project['url']}");


    } else {
      echo $this->ansiFormat("Abort operation \n", Console::FG_RED);
    }
  }

  public function actionDb($host='localhost',$dbname='test',$user='',$pwd=''){

        $config['pwd'] = $pwd;
        $config['user'] = $user;
        $config['host'] = $host;
        $config['dbname'] = $dbname;

      echo $this->ansiFormat("\nSet DB params...  ", Console::FG_BLUE);
      file_put_contents(Yii::getAlias('@common/config/main-local.php'), $this->dbConfig($config));
      echo $this->ansiFormat(" Done! \n", Console::FG_GREEN);
  }

  private function dbConfig($mysql) {

    return "<?php
  return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host={$mysql['host']};dbname={$mysql['dbname']}',
            'username' => '{$mysql['user']}',
            'password' => '{$mysql['pwd']}',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
        ],
    ],
];";
//root suZtDUdM

  }


}

?>
