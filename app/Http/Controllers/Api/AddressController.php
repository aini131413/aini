<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AddressController extends BaseController
{
    /**
     * 添加地址
     * @return array
     */
    public function add()
    {
        $data=\request()->all();
//        var_dump($data);
        $data["vip_id"]=\request()->user_id;

        $validator = Validator::make($data, [
            'name' => 'required',
            'user_id' => 'required',
            'tel' =>[
                'required',
                "regex:/^0?(13|14|15|18|17)[0-9]{9}$/"
                ],
            "provence"=>"required",
            "city"=>"required",
            "area"=>"required",
            "detail_address"=>"required",
        ]);

        if ($validator->fails()) {
            return ["status"=>"false",
                "message"=>$validator->errors()->first()
                ];
        }

        if (Address::create($data)) {
            return ["status"=>"true",
                "message"=>"添加地址成功"
            ];

        }else{
            return ["status"=>"false",
                "message"=>"添加地址失败"
            ];
        }


    }

    /**
     * 地址列表
     */
    public function list()
    {
       $id= \request()->user_id;
       $datas=Address::where("vip_id",$id)->get();

       return $datas;

    }

    /**
     * 显示地址详情
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function detail()
    {
        $id=\request()->id;
        return Address::findOrFail($id);
    }

    /**
     * 编辑地址
     * @return array
     */
    public function edit()
    {
        $data=\request()->all();

        $newAddress= Address::findOrFail($data["id"]);
//        dd($newAddress);

        if ($newAddress->update($data)) {
            return[
                "status"=>"true",
                "message"=>"修改成功"
            ];
        }else{
            return[
                "status"=>"false",
                "message"=>"修改失败"
            ];

        }
    }



}
