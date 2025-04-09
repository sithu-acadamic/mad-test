<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    private function filterLoop($q,$arr,$att,$val){
        $keys = array_keys(array_column($arr,$att), $val);
        if(count($keys)>0){
            for($i=0;$i<count($keys);$i++){
                $flt=$arr[$keys[$i]]['filter'];
                $rel=$arr[$keys[$i]]['rel'];
                if($flt!=NULL){
                    $q->whereHas($rel, function($q) use ($flt,$rel,$arr) {
                        $q->where($flt);
                        $this->filterLoop($q,$arr,'parent',$rel);
                    });
                }
            }
        }
        return $q;
    }

    protected function setFeildArrays($filter,$ret_arr){
        if($filter['operator']=='LIKE'){
            switch ($filter['search']){
                case 'left':
                    $val=trim($filter['feild_name']).'%';
                    break;
                case 'right':
                    $val='%'.trim($filter['feild_name']);
                    break;
                default :
                    $val='%'.trim($filter['feild_name']).'%';
                    break;
            }
        }
        else{
            $val=trim($filter['feild_name']);
        }
        if($filter['type']=='int'){
            if($filter['feild_name']!=''){
                $ret_arr[]=[$filter['column_name'],$filter['operator'],$val];
            }
        }
        else if($filter['type']=='date_range'){
            $ret_arr[]=array($filter['start'], $filter['end']);
        }
        else{
            if($filter['feild_name']!='' || $filter['feild_name']!=NULL){
                $ret_arr[]=[$filter['column_name'],$filter['operator'],$val];
            }
        }

        return $ret_arr;
    }

    public function getData($param){
        if($param['model']!=""){
            $query=$param['model'];

            if(count($param['relations'])>0){
                for ($r=0;$r<count($param['relations']);$r++){
                    $query=$query->with($param['relations'][$r]);
                }
            }

            if(count($param['conditions'])>0){
                $query=$query->where($param['conditions']);
            }

            if(count($param['filter_arr'])>0){
                $filter_fld=$param['filter_fld'];
                $filter_arr=$param['filter_arr'];
                $query=$query->when($filter_fld, function ($q) use ($filter_fld,$filter_arr) {
                    if(!empty($filter_arr)){
                        $keys = array_keys(array_column($filter_arr,'level'), 1);
                        if(count($keys)>0){
                            for($i=0;$i<count($keys);$i++){
                                $flt=$filter_arr[$keys[$i]]['filter'];
                                $rel=$filter_arr[$keys[$i]]['rel'];
                                if (array_key_exists('cond_type', $filter_arr[$keys[$i]])) {
                                    if(!empty($flt)){
                                        $type=$filter_arr[$keys[$i]]['cond_type'];
                                        $col_name=$filter_arr[$keys[$i]]['column_name'];
                                        switch ($type){
                                            case 'between':
                                                $q=$q->whereBetween($col_name,$flt);
                                                break;
                                        }
                                    }
                                }
                                else{
                                    $q=$q->where($flt);
                                }

                            }
                        }
                        $q=$this->filterLoop($q,$filter_arr,'parent','master');
                    }
                    return $q;
                });
            }

            if(isset($param['group_by']) && count($param['group_by'])>0){
                foreach ($param['group_by'] as $grp){
                    $query=$query->groupBy($grp['column']);
                }
            }

            if(count($param['order_by'])>0){
                foreach ($param['order_by'] as $ord){
                    $query=$query->orderBy($ord['column'], $ord['direction']);
                }
            }

            if(isset($param['limit']) && $param['limit']>0){
                $query=$query->take($param['limit']);
            }

            if(isset($param['start']) && $param['start']>0){
                $query=$query ->skip($param['start']);

            }

            return $query->get();
        }
        else{
            return NULL;
        }
    }

    public function getFilterRecorders($param){
        if($param['model']!=""){
            $query=$param['model'];

            if(count($param['relations'])>0){
                for ($r=0;$r<count($param['relations']);$r++){
                    $query=$query->with($param['relations'][$r]);
                }
            }

            if(count($param['conditions'])>0){
                $query=$query->where($param['conditions']);
            }

            if(count($param['filter_arr'])>0){
                $filter_fld=$param['filter_fld'];
                $filter_arr=$param['filter_arr'];
                $query=$query->when($filter_fld, function ($q) use ($filter_fld,$filter_arr) {
                    if(!empty($filter_arr)){
                        $keys = array_keys(array_column($filter_arr,'level'), 1);
                        if(count($keys)>0){
                            for($i=0;$i<count($keys);$i++){
                                $flt=$filter_arr[$keys[$i]]['filter'];
                                $rel=$filter_arr[$keys[$i]]['rel'];
                                if (array_key_exists('cond_type', $filter_arr[$keys[$i]])) {
                                    if(!empty($flt)){
                                        $type=$filter_arr[$keys[$i]]['cond_type'];
                                        $col_name=$filter_arr[$keys[$i]]['column_name'];
                                        switch ($type){
                                            case 'between':
                                                $q=$q->whereBetween($col_name,$flt);
                                                break;
                                        }
                                    }
                                }
                                else{
                                    $q=$q->where($flt);
                                }

                            }
                        }
                        $q=$this->filterLoop($q,$filter_arr,'parent','master');
                    }
                    return $q;
                });
            }


            if(count($param['order_by'])>0){
                foreach ($param['order_by'] as $ord){
                    $query=$query->orderBy($ord['column'], $ord['direction']);
                }
            }

            return $query->count();
        }
        else{
            return 0;
        }
    }
}
