<?php
/**
 * @param $fileName
 * @param $headArr
 * @param $list
 * @throws PHPExcel_Exception
 * @throws PHPExcel_Reader_Exception
 * excel导出
 */
function To_Exel($fileName, $headArr, $list)
{
    //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能import导入
    Vendor("PHPExcel.PHPExcel");
    Vendor("PHPExcel.PHPExcel.Writer.Excel5");
    Vendor("PHPExcel..PHPExcel.IOFactory.php");

    $date = date("Y_m_d", time());
    $fileName .= "_{$date}.xls";

    //创建PHPExcel对象，注意，不能少了\
    $objPHPExcel = new \PHPExcel();
    $objProps = $objPHPExcel->getProperties();

    //设置表头
    $key = ord("A");
    //print_r($headArr);exit;
    foreach ($headArr as $v) {
        $colum = chr($key);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . '1', $v);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . '1', $v);
        $key += 1;
    }

    $column = 2;
    $objActSheet = $objPHPExcel->getActiveSheet();
    foreach ($list as $key => $rows) { //行写入
        $span = ord("A");
        foreach ($rows as $keyName => $value) {// 列写入
            $j = chr($span);
            $objActSheet->setCellValue($j . $column, $value,PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->getStyle($j . $column)->getNumberFormat()->setFormatCode("@");
            $span++;
        }
        $column++;
    }

    $fileName = iconv("utf-8", "gb2312", $fileName);
    $objPHPExcel->setActiveSheetIndex(0);
    ob_end_clean();//清除缓冲区,避免乱码
    header('Content-Type: application/vnd.ms-Excel');
    header("Content-Disposition: attachment;filename=\"$fileName\"");
    header('Cache-Control: max-age=0');

    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output'); //文件通过浏览器下载
    exit;
}

/**
 * @param $file
 * @return array
 * excel导入
 */
function From_Excel($file)
{
    /* 实例化类 */
    Vendor("PHPExcel.PHPExcel");
    Vendor("PHPExcel.PHPExcel.IOFactory");
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    if( $ext =='xlsx' ) {
        $objReader = new \PHPExcel_Reader_Excel2007();
    } else {
        $objReader = new \PHPExcel_Reader_Excel5();
    }
    $objPHPExcel = $objReader->load($file);
    $objWorksheet = $objPHPExcel->getActiveSheet();
    $sheetData =$objWorksheet->toArray(null,true,true,true);

    return $sheetData;
}

/**
 * 发送 容联云通讯 验证码
 * @param  int $phone 手机号
 * @param  int $code  验证码
 * @return boole      是否发送成功
 */
function send_sms_code($phone,$code){
    //请求地址，格式如下，不需要写https://
    $serverIP='app.cloopen.com';
    //请求端口
    $serverPort='8883';
    //REST版本号
    $softVersion='2013-12-26';
    //主帐号
    $accountSid=C('RONGLIAN_ACCOUNT_SID');
    //主帐号Token
    $accountToken=C('RONGLIAN_ACCOUNT_TOKEN');
    //应用Id
    $appId=C('RONGLIAN_APPID');
    //模板Id
    $templateId=C('RONGLIAN_TEMPLATE_ID');
    $past_due_time = C('PAST_DUE_TIME');
    vendor('Xb.Rest');
    $rest = new \Rest($serverIP,$serverPort,$softVersion);
    $rest->setAccount($accountSid,$accountToken);
    $rest->setAppId($appId);
    // 发送模板短信
    $result=$rest->sendTemplateSMS($phone,array($code,$past_due_time),$templateId);
    if($result==NULL) {
        return false;
    }
    if($result->statusCode!=0) {
        return  false;
    }else{
        return true;
    }
}

/**
 * @param $len 随机数的个数
 * @return string
 * 生成随机数
 */
function GetRandStr($len){
    $chars = array(
        "0", "1", "2","3", "4", "5", "6", "7", "8", "9"
    );
    $charsLen = count($chars) - 1;
    shuffle($chars);
    $output = "";
    for ($i=0; $i<$len; $i++){
        $output .= $chars[mt_rand(0, $charsLen)];
    }
    return $output;
}