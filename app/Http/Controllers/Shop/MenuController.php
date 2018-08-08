<?php

namespace App\Http\Controllers\Shop;

use App\Models\Menu;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class MenuController extends BaseController
{
    /**
     * 添加商品
     * @param Request $request
     * @param $shop_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request,$shop_id)
    {
        if ($request->isMethod("post")) {
            $this->validate($request,[
                "goods_name"=>"required",
                "goods_price"=>"required",
            ]);
            $data=$request->all();
            $file=$request->file('goods_img');

            if ($file!==null){
                //上传文件
                $fileName= $file->store("ele","oss");

                $data["goods_img"]=env("ALIYUN_OSS_URL").$fileName;

            }else{
                unset($data["goods_img"]);
            }

//            if ($request->file("goods_img")) {
//             $data["goods_img"]="/uploads/images/".$request->file("goods_img")->store("goods_img","images");}

            if (Menu::create($data)) {
                $request->session()->flash("success","添加成功");
                return redirect()->route("user.index");
            }




        }
        $cates=MenuCategory::where("shop_id",$shop_id)->get();
        return view("shop.menu.add",compact("shop_id","cates"));
    }

    /**
     * 编辑菜品
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request ,$id)
    {

        $menu=Menu::findOrFail($id);
        $photo=$menu->goods_img;
        $shop_id=$menu->shop_id;
        $cates=MenuCategory::where("shop_id",$shop_id)->get();
        $data=$request->all();


        if($request->isMethod("post")){
            $this->validate($request,[
                "goods_name"=>"required",
                "goods_price"=>"required",
            ]);

            if($request->file("goods_img")){
                $data["goods_img"]=env("ALIYUN_OSS_URL").$request->file("goods_img")->store("goods_img","oss");
            }else{
                unset($data["goods_img"]);
            }
            if ($menu->update($data)) {
                File::delete(public_path($photo));
                $request->session()->flash("success","编辑成功");
                return redirect()->route("user.index",$id);
            }else{
//                $request->session()->flash("warning","编辑失败");
                return redirect()->back()->with("warning","编辑失败");
            }
        }








        return view("shop.menu.edit",compact("menu","cates"));

        }


    public function del($id)
    {

        $menu=Menu::findOrFail($id);
        $photo=$menu->goods_img;
        if($photo !== null){
            if(File::delete(public_path($photo)) && $menu->delete()){
            return redirect()->back()->with("success","删除成功");


        }
        }
        if($menu->delete()){
            return redirect()->back()->with("success","删除成功");



    }


}
}


