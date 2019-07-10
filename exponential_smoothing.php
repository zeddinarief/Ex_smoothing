<?php
class exponential_smoothing{
    private $dataLatih=[];
    private $dataUji=[];
    private $db;
    public function __construct($db) {
        $this->db=$db;
    }
    public function doSingleSmoothing($alpha=0.1,$bulan){
        $this->dataLatih= new ArrayObject($this->db->getDataL());
        $this->dataUji=new ArrayObject($this->db->getDataU($bulan));
        $dataLatih= $this->dataLatih->getArrayCopy();
        $dataUji= $this->dataUji->getArrayCopy();
        $datas=array_merge($dataLatih,$dataUji);
        // var_dump($dataUji);
        $hasilPrediksi=[];
        foreach($datas as $key=>$value){
            // var_dump($value['bulan']);
            if($key == 0){
                $hasilPrediksi[$key]=0;
            }else if ($key ==1){
                $hasilPrediksi[$key]=$this->singleSmoothingFormula($alpha,$datas[$key-1]['hasil_penjualan'],$datas[$key-1]['hasil_penjualan']);
            }else{
                $hasilPrediksi[$key]=$this->singleSmoothingFormula($alpha,$datas[$key-1]['hasil_penjualan'],$hasilPrediksi[$key-1]);
            }
        }
        $prediksiLatih = [];
        $prediksiUji = [];
        for ($i=0;$i<count($dataLatih);$i++){
            $templateLatih = [
                'hasilPenjualan'=> $dataLatih[$i]['hasil_penjualan'],
                'hasilPrediksi'=> $hasilPrediksi[$i]
            ];
            array_push($prediksiLatih,$templateLatih);
        }
        for ($i=0;$i<count($dataUji);$i++){
            $templateUji = [
                'hasilPenjualan'=> $dataUji[$i]['hasil_penjualan'],
                'hasilPrediksi'=> $hasilPrediksi[$i+count($dataLatih)]
            ];
            array_push($prediksiUji,$templateUji);
        }
        $resultMape = $this->doMape($prediksiUji);
        $dataResult=[
            'dataLatih'=> $prediksiLatih,
            'dataUji'=> $resultMape['datas'],
            'mape'=> $resultMape['mape'],
            'data'=> $dataUji,
            'bulan' => $bulan
        ];
        // var_dump($dataResult['dataUji']);
        return $dataResult;
    }
    public function doMapeSingleSmoothing($alpha=0.1){
        $this->dataLatih= new ArrayObject($this->db->getDataLatih());
        $this->dataUji=new ArrayObject($this->db->getDataUji());
        $dataLatih= $this->dataLatih->getArrayCopy();
        $dataUji= $this->dataUji->getArrayCopy();
        $datas=array_merge($dataLatih,$dataUji);
        $hasilPrediksi=[];
        foreach($datas as $key=>$value){
            if($key == 0){
                $hasilPrediksi[$key]=0;
            }else if ($key ==1){
                $hasilPrediksi[$key]=$this->singleSmoothingFormula($alpha,$datas[$key-1]['hasil_penjualan'],$datas[$key-1]['hasil_penjualan']);
            }else{
                $hasilPrediksi[$key]=$this->singleSmoothingFormula($alpha,$datas[$key-1]['hasil_penjualan'],$hasilPrediksi[$key-1]);
            }
        }
        $prediksiLatih = [];
        $prediksiUji = [];
        for ($i=0;$i<count($dataLatih);$i++){
            $templateLatih = [
                'hasilPenjualan'=> $dataLatih[$i]['hasil_penjualan'],
                'hasilPrediksi'=> $hasilPrediksi[$i]
            ];
            array_push($prediksiLatih,$templateLatih);
        }
        for ($i=0;$i<count($dataUji);$i++){
            $templateUji = [
                'hasilPenjualan'=> $dataUji[$i]['hasil_penjualan'],
                'hasilPrediksi'=> $hasilPrediksi[$i+count($dataLatih)]
            ];
            array_push($prediksiUji,$templateUji);
        }
        $resultMape = $this->doMape($prediksiUji);
        $dataResult=[
            'dataLatih'=> $prediksiLatih,
            'dataUji'=> $resultMape['datas'],
            'mape'=> $resultMape['mape']
        ];
        return $dataResult;
    }
    private function singleSmoothingFormula($alpha,$actual_sbl,$forecast_sbl){
        return $alpha*$actual_sbl+(1-$alpha)*$forecast_sbl;
    }

    public function doDoubleSmoothing($alpha=0.1,$bulan){
        $this->dataLatih= new ArrayObject($this->db->getDataL());
        $this->dataUji=new ArrayObject($this->db->getDataU($bulan));
        $dataLatih= $this->dataLatih->getArrayCopy();
        $dataUji= $this->dataUji->getArrayCopy();
        $datas=new ArrayObject(array_merge($dataLatih,$dataUji));
        // $tempDatas=$datas->getArrayCopy();
        $hasilPrediksi=[];
        $sAksenT=[];
        $sAksen2T=[];
        $aT=[];
        $bT=[];
        foreach($datas as $key => $value){
            if($key == 0){
                $sAksenT[$key]=$datas[$key]['hasil_penjualan'];
                $sAksen2T[$key]=$datas[$key]['hasil_penjualan'];
                $aT[$key]=$datas[$key]['hasil_penjualan'];
                $data=array_slice($datas->getArrayCopy(), $key,$key+4);
                $bT[$key]=(($data[1]['hasil_penjualan']-$data[0]['hasil_penjualan'])+($data[3]['hasil_penjualan']-$data[2]['hasil_penjualan']))/2;
                $hasilPrediksi[$key]=0;
            }else{
                $sAksenT[$key]=$this->singleSmoothingFormula($alpha,$datas[$key]['hasil_penjualan'],$sAksenT[$key-1]);
                $sAksen2T[$key]=$this->singleSmoothingFormula($alpha,$sAksenT[$key],$sAksen2T[$key-1]);
                $aT[$key]=2*$sAksenT[$key]-$sAksen2T[$key];
                $bT[$key]=$this->doCount_bT($alpha,$sAksenT[$key],$sAksen2T[$key]);
                $hasilPrediksi[$key]=$aT[$key-1]+$bT[$key-1];
            }
            // echo $sAksenT[$key]."\t ".$sAksen2T[$key]."\t ".$aT[$key]."\t ".$bT[$key]."\t ".$hasilPrediksi[$key]."<br>";
        }
        $prediksiLatih = [];
        $prediksiUji = [];
        for ($i=0;$i<count($dataLatih);$i++){
            $templateLatih = [
                'hasilPenjualan'=> $dataLatih[$i]['hasil_penjualan'],
                'hasilPrediksi'=> $hasilPrediksi[$i]
            ];
            array_push($prediksiLatih,$templateLatih);
        }
        for ($i=0;$i<count($dataUji);$i++){
            $templateUji = [
                'hasilPenjualan'=> $dataUji[$i]['hasil_penjualan'],
                'hasilPrediksi'=> $hasilPrediksi[$i+count($dataLatih)]
            ];
            array_push($prediksiUji,$templateUji);
        }
        $resultMape = $this->doMape($prediksiUji);
        $dataResult=[
            'dataLatih'=> $prediksiLatih,
            'dataUji'=> $resultMape['datas'],
            'mape'=> $resultMape['mape'],
            'data'=> $dataUji,
            'bulan' => $bulan
        ];
        return $dataResult;
    }
    public function doMapeDoubleSmoothing($alpha=0.1){  
        $this->dataLatih= new ArrayObject($this->db->getDataLatih());
        $this->dataUji=new ArrayObject($this->db->getDataUji());
        $dataLatih= $this->dataLatih->getArrayCopy();
        $dataUji= $this->dataUji->getArrayCopy();
        $datas=new ArrayObject(array_merge($dataLatih,$dataUji));
        // $tempDatas=$datas->getArrayCopy();
        $hasilPrediksi=[];
        $sAksenT=[];
        $sAksen2T=[];
        $aT=[];
        $bT=[];
        foreach($datas as $key => $value){
            if($key == 0){
                $sAksenT[$key]=$datas[$key]['hasil_penjualan'];
                $sAksen2T[$key]=$datas[$key]['hasil_penjualan'];
                $aT[$key]=$datas[$key]['hasil_penjualan'];
                $data=array_slice($datas->getArrayCopy(), $key,$key+4);
                $bT[$key]=(($data[1]['hasil_penjualan']-$data[0]['hasil_penjualan'])+($data[3]['hasil_penjualan']-$data[2]['hasil_penjualan']))/2;
                $hasilPrediksi[$key]=0;
            }else{
                $sAksenT[$key]=$this->singleSmoothingFormula($alpha,$datas[$key]['hasil_penjualan'],$sAksenT[$key-1]);
                $sAksen2T[$key]=$this->singleSmoothingFormula($alpha,$sAksenT[$key],$sAksen2T[$key-1]);
                $aT[$key]=2*$sAksenT[$key]-$sAksen2T[$key];
                $bT[$key]=$this->doCount_bT($alpha,$sAksenT[$key],$sAksen2T[$key]);
                $hasilPrediksi[$key]=$aT[$key-1]+$bT[$key-1];
            }
            // echo $sAksenT[$key]."\t ".$sAksen2T[$key]."\t ".$aT[$key]."\t ".$bT[$key]."\t ".$hasilPrediksi[$key]."<br>";
        }
        $prediksiLatih = [];
        $prediksiUji = [];
        for ($i=0;$i<count($dataLatih);$i++){
            $templateLatih = [
                'hasilPenjualan'=> $dataLatih[$i]['hasil_penjualan'],
                'hasilPrediksi'=> $hasilPrediksi[$i]
            ];
            array_push($prediksiLatih,$templateLatih);
        }
        for ($i=0;$i<count($dataUji);$i++){
            $templateUji = [
                'hasilPenjualan'=> $dataUji[$i]['hasil_penjualan'],
                'hasilPrediksi'=> $hasilPrediksi[$i+count($dataLatih)]
            ];
            array_push($prediksiUji,$templateUji);
        }
        $resultMape = $this->doMape($prediksiUji);
        $dataResult=[
            'dataLatih'=> $prediksiLatih,
            'dataUji'=> $resultMape['datas'],
            'mape'=> $resultMape['mape']
        ];
        return $dataResult;
    }
    private function doCount_bT($alpha,$sAksenT,$sAksen2T){
        return $alpha/(1-$alpha)*($sAksenT-$sAksen2T);;
    }
    public function doTripleSmoothing($alpha=0.1, $beta=0.1, $gamma=0.1,$bulan){
        $this->dataLatih= new ArrayObject($this->db->getDataL());
        $this->dataUji=new ArrayObject($this->db->getDataU($bulan));
        $dataLatih= $this->dataLatih->getArrayCopy();
        $dataUji= $this->dataUji->getArrayCopy();
        $datas=new ArrayObject(array_merge($dataLatih,$dataUji));
        $n = count($dataUji);
        $St=[];
        $Tt=[];
        $SNt=[];
        $hasilPrediksi=[];
        $St_first=$this->doSt_first(array_slice($datas->getArrayCopy(), 0,$n));
        $Tt_first=$this->doTt_first(array_slice($datas->getArrayCopy(), 0,$n),array_slice($datas->getArrayCopy(), $n,$n));
        foreach($datas as $key => $value){
            if($key<$n-1){
                $St[$key]=0;
                $Tt[$key]=0;
                $SNt[$key]= $datas[$key]['hasil_penjualan']/$St_first;
                $hasilPrediksi[$key]=0;
            }else if($key == $n-1){
                $St[$key]=$St_first;
                $Tt[$key]=$Tt_first;
                $SNt[$key]= $datas[$key]['hasil_penjualan']/$St_first;
                $hasilPrediksi[$key]=0;
            }else if($key>=$n){
                $St[$key]=$this->doSt($datas[$key]['hasil_penjualan'],$St[$key-1],$Tt[$key-1],$SNt[$key-$n],$alpha);
                $Tt[$key]=$this->doTt($St[$key-1],$St[$key],$Tt[$key-1],$beta);
                $SNt[$key]= $this->doSNt($datas[$key]['hasil_penjualan'],$St[$key],$SNt[$key-$n],$gamma);
                $hasilPrediksi[$key]=($St[$key-1]+$Tt[$key-1])*$SNt[$key-$n];
                // die();
            }
            // echo $key."&nbsp".$datas[$key]['hasil_penjualan']."&nbsp".$St[$key]."&nbsp".$Tt[$key]."&nbsp".$SNt[$key]."&nbsp".$hasilPrediksi[$key]."<br>";
        }
        $prediksiLatih = [];
        $prediksiUji = [];
        for ($i=0;$i<count($datas)-$n;$i++){
            $templateLatih = [
                'hasilPenjualan'=> $datas[$i]['hasil_penjualan'],
                'hasilPrediksi'=> $hasilPrediksi[$i]
            ];
            array_push($prediksiLatih,$templateLatih);
        }
        for ($i=0;$i<$n;$i++){
            $templateUji = [
                'hasilPenjualan'=> $datas[$i+count($prediksiLatih)]['hasil_penjualan'],
                'hasilPrediksi'=> $hasilPrediksi[$i+count($prediksiLatih)]
            ];
            array_push($prediksiUji,$templateUji);
        }
        $resultMape = $this->doMape($prediksiUji);
        $dataResult=[
            'dataLatih'=> $prediksiLatih,
            'dataUji'=> $resultMape['datas'],
            'mape'=> $resultMape['mape'],
            'data'=> $dataUji,
            'bulan' => $bulan
        ];
        // echo(json_encode($dataResult));
        return $dataResult;

    }
    public function doMapeTripleSmoothing($alpha=0.1, $beta=0.1, $gamma=0.1){
        
        $this->dataLatih= new ArrayObject($this->db->getDataLatih());
        $this->dataUji=new ArrayObject($this->db->getDataUji());
        $dataLatih= $this->dataLatih->getArrayCopy();
        $dataUji= $this->dataUji->getArrayCopy();
        $datas=new ArrayObject(array_merge($dataLatih,$dataUji));
        $n = count($dataUji);
        $St=[];
        $Tt=[];
        $SNt=[];
        $hasilPrediksi=[];
        $St_first=$this->doSt_first(array_slice($datas->getArrayCopy(), 0,$n));
        $Tt_first=$this->doTt_first(array_slice($datas->getArrayCopy(), 0,$n),array_slice($datas->getArrayCopy(), $n,$n));
        foreach($datas as $key => $value){
            if($key<$n-1){
                $St[$key]=0;
                $Tt[$key]=0;
                $SNt[$key]= $datas[$key]['hasil_penjualan']/$St_first;
                $hasilPrediksi[$key]=0;
            }else if($key == $n-1){
                $St[$key]=$St_first;
                $Tt[$key]=$Tt_first;
                $SNt[$key]= $datas[$key]['hasil_penjualan']/$St_first;
                $hasilPrediksi[$key]=0;
            }else if($key>=$n){
                $St[$key]=$this->doSt($datas[$key]['hasil_penjualan'],$St[$key-1],$Tt[$key-1],$SNt[$key-$n],$alpha);
                $Tt[$key]=$this->doTt($St[$key-1],$St[$key],$Tt[$key-1],$beta);
                $SNt[$key]= $this->doSNt($datas[$key]['hasil_penjualan'],$St[$key],$SNt[$key-$n],$gamma);
                $hasilPrediksi[$key]=($St[$key-1]+$Tt[$key-1])*$SNt[$key-$n];
                // die();
            }
            // echo $key."&nbsp".$datas[$key]['hasil_penjualan']."&nbsp".$St[$key]."&nbsp".$Tt[$key]."&nbsp".$SNt[$key]."&nbsp".$hasilPrediksi[$key]."<br>";
        }
        $prediksiLatih = [];
        $prediksiUji = [];
        for ($i=0;$i<count($datas)-$n;$i++){
            $templateLatih = [
                'hasilPenjualan'=> $datas[$i]['hasil_penjualan'],
                'hasilPrediksi'=> $hasilPrediksi[$i]
            ];
            array_push($prediksiLatih,$templateLatih);
        }
        for ($i=0;$i<$n;$i++){
            $templateUji = [
                'hasilPenjualan'=> $datas[$i+count($prediksiLatih)]['hasil_penjualan'],
                'hasilPrediksi'=> $hasilPrediksi[$i+count($prediksiLatih)]
            ];
            array_push($prediksiUji,$templateUji);
        }
        $resultMape = $this->doMape($prediksiUji);
        $dataResult=[
            'dataLatih'=> $prediksiLatih,
            'dataUji'=> $resultMape['datas'],
            'mape'=> $resultMape['mape']
        ];
        // echo(json_encode($dataResult));
        return $dataResult;

    }
    private function doSt_first($data){
        $tot=0;
        for($i=0;$i<count($data);$i++){
            $tot+=$data[$i]['hasil_penjualan'];
        }
        return $tot/count($data);
    }
    private function doTt_first($data,$data1){
        $tot=0;
        for($i=0;$i<count($data);$i++){
            $temp=$data1[$i]['hasil_penjualan']-$data[$i]['hasil_penjualan'];
            $tot+=$temp;
        }
        return $tot/(count($data)*count($data1));
    }
    private function doSt($hasil_penjualan,$St_Sbl,$Tt_sbl,$SNt,$alpha){
        // echo $hasil_penjualan." ".$St_Sbl." ".$Tt_sbl." ".$SNt." ".$alpha."<br>";
        return ($alpha*$hasil_penjualan/$SNt)+((1-$alpha)*($St_Sbl+$Tt_sbl));
    }
    private function doTt($St_Sbl,$St,$Tt_sbl,$beta){
        return ($beta*($St-$St_Sbl))+((1-$beta)*$Tt_sbl);
    }
    private function doSNt($hasil_penjualan,$St, $SNt_sbl,$gamma){
        return ($gamma*($hasil_penjualan/$St))+((1-$gamma)*$SNt_sbl);
    }
    private function doMape($datas){
        $sum=0;
        $newData=[];
        foreach($datas as $key=>$value){
            $temp = abs(($value['hasilPenjualan']-$value['hasilPrediksi'])/$value['hasilPenjualan']);
            $newData[$key]=[
                'hasilPenjualan'=>$value['hasilPenjualan'],
                'hasilPrediksi'=>$value['hasilPrediksi'],
                'mape'=>$temp
            ];
            $sum+=$temp;
        }
        $mape=$sum*100/count($datas);
        $result=[
            'datas'=>$newData,
            'mape'=>$mape
        ];
        return $result;
    }

}
?>