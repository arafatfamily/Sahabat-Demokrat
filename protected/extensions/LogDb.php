<?php
class LogDb extends CDbLogRoute
{
 
    protected function createLogTable($db,$tableName)
    {
        $db->createCommand()->createTable($tableName, array(
            'id'=>'pk',
            'level'=>'varchar(128)',
            'category'=>'varchar(128)',
            'logtime'=>'timestamp with time zone', 
            'IP_User'=>'varchar(50)', //For IP 
            'user_name'=>'varchar(50)',
            'request_URL'=>'text',
            'message'=>'text',
        ));
    }
    protected function processLogs($logs)
    {
        $command=$this->getDbConnection()->createCommand();
        $logTime=date('Y-m-d H:i:s'); //Get Current Date
 
        foreach($logs as $log)
        {
            $command->insert($this->logTableName,array(
                'level'=>$log[1],
                'category'=>$log[2],
                'logtime'=>$logTime,
                'IP_User'=> Yii::app()->request->userHostAddress, //Get Ip 
                'user_name'=>Yii::app()->user->name , //Get name
                'request_URL'=>Yii::app()->request->url, // Get Url
                'message'=>$log[0]
            ));
        }
    }
 
}
?>