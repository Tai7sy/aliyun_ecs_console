<?php

include_once './aliyun-openapi/aliyun-php-sdk-core/Config.php';
use Ecs\Request\V20140526 as Ecs;

class OperateEcs{
    private $iClientProfile;
    private $client;
    function __construct($regionId, $accessKeyId, $accessSecret)
    {
        $this->iClientProfile = DefaultProfile::getProfile($regionId, $accessKeyId, $accessSecret);
        $this->client = new DefaultAcsClient($this->iClientProfile);
    }
    public function get(){
        $request = new Ecs\DescribeInstancesRequest();
        $request->setMethod("GET");
        $response = $this->client->getAcsResponse($request);
        return $response;
    }

    public function status($instanceId){
        $request = new Ecs\DescribeInstanceStatusRequest();
        $request->setMethod("GET");
        $response = $this->client->getAcsResponse($request);


        if(!isset($response->InstanceStatuses->InstanceStatus)){
            die('未找到实例ID');
        }
        $status='未找到实例ID';
        foreach ($response->InstanceStatuses->InstanceStatus as $iii){
            if($iii->InstanceId==$instanceId){
                $status=$iii->Status;
            }
        }
        return $status;
    }
    public function start($instanceId){
        $request = new Ecs\StartInstanceRequest();
        $request->setInstanceId($instanceId);
        $request->setMethod("GET");
        $response = $this->client->getAcsResponse($request);
        return $response;
    }
    public function stop($instanceId){
        $request = new Ecs\StopInstanceRequest();
        $request->setInstanceId($instanceId);
        $request->setForceStop('true');
        $request->setMethod("GET");
        $response = $this->client->getAcsResponse($request);
        return $response;
    }
    public function reboot($instanceId){
        $request = new Ecs\RebootInstanceRequest();
        $request->setInstanceId($instanceId);
        $request->setForceStop('true');
        $request->setMethod("GET");
        $response = $this->client->getAcsResponse($request);
        return $response;
    }

    public function getDisk($instanceId){
        $request = new Ecs\DescribeDisksRequest();
        $request->setInstanceId($instanceId);
        $request->setMethod("GET");
        $response = $this->client->getAcsResponse($request);
        return $response;
    }

    /**
     * 重装系统
     * @param $instanceId
     * @return mixed|SimpleXMLElement
     */
    public function rebuild($instanceId){
        $disk = $this->getDisk($instanceId);
        if(isset($disk->Disks->Disk[0])){
            $diskId = $disk->Disks->Disk[0]->DiskId;
        }else{
            die('未找到实例ID');
        }
        $request = new Ecs\ReInitDiskRequest();
        $request->setDiskId($diskId);
        $request->setMethod("GET");
        $response = $this->client->getAcsResponse($request);
        return $response;
    }
}