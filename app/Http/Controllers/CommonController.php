<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CommonController extends Controller
{
    public function timeline(){
        list($limit,$skip)=paginate(rq('page'),rq('limit'));
        $questions_list=question_instance()
                    ->with('user')
                    ->limit($limit)
                    ->skip($skip)
                    ->orderBy('created_at','desc')
                    ->get();

        $answers_list=answer_instance()
            ->with('question')
            ->with('user')
            ->with('users')
            ->limit($limit)
            ->skip($skip)
            ->orderBy('created_at','desc')
            ->get();

//        dd($answers_list->toArray());

        $data=$questions_list->merge($answers_list);
        $data=$data->sortByDesc(function ($item){
            return $item->created_at;
        });

        $data=$data->values()->all();

//        return $data;
        return['status'=>1,'data'=>$data];
    }
}
