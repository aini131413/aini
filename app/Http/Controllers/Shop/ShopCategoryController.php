<?php

namespace App\Http\Controllers\Shop;

use App\Models\ShopCategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;


class ShopCategoryController extends BaseController
{
    /**
     * 显示首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {


        $cates=ShopCategory::paginate(2);

        return view("shop.shop_cate.index",compact("cates"));
    }

    /**
     * 添加商铺分类
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     *
     */
    public function add(Request $request)
    {
            if($request->isMethod("post")){
                $this->validate($request,[
                    "name"=>"required",
                    "captcha"=>"captcha"
                    ]);
                $data=$request->all();
                $data["img"]="";
                if ($request->file("img")){
                    $data["img"]="/uploads/images/".$request->file("img")->store("img","images");
                }
                if (ShopCategory::create($data)) {
                $request->session()->flash("success","添加成功");
                return redirect()->route("shop_cate.index");



                }



            }



        return view("shop.shop_cate.add");
    }

    /**
     * 编辑分类
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     *
     */
    public function edit(Request $request,$id)
    {
        $dd=ShopCategory::findOrFail($id);
            if($request->isMethod("post")){
                $this->validate($request,[
                    "name"=>"required",
                    "captcha"=>"captcha"
                    ]);
                $data=$request->all();
                $data["img"]="";
                if ($request->file("img")){
                    $data["img"]="/uploads/images/".$request->file("img")->store("img","images");
                }
                if ($dd->update($data)) {
                $request->session()->flash("success","编辑成功");
                return redirect()->route("shop_cate.index");
                }else{
                    $request->session()->flash("warning","编辑失败");
                    return redirect()->route("shop_cate.edit")->withInput();
                }



            }



        return view("shop.shop_cate.edit",compact("dd"));
    }

    /**
     * 删除分类
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function del(Request $request,$id)
    {
       $count= User::where("shop_id",$id)->count();
//var_dump($count);
        if($count>0){
            $request->session()->flash("danger","分类下仍有商铺不能删除");
            return redirect()->route("shop_cate.index");
        }else{
            $data=ShopCategory::findOrFail($id);

           $img= public_path($data->img);
              if($data->delete() && File::delete($img)  ){
                $request->session()->flash("success","已删除");
                return redirect()->route("shop_cate.index");
            }
        }

    }

    /**
     * 分类禁用或启用
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function status(Request $request,$id)
    {
        $status=ShopCategory::findOrFail($id);
        if($status->status==0){
            $status->update(["status"=>1]);
            $request->session()->flash("success","已启用");
            return redirect()->route("admin.cate");
        }else{
            $status->update(["status"=>0]);
            $request->session()->flash("success","已禁用");
            return redirect()->route("admin.cate");
        }
    }


}
