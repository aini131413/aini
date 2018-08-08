<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShopCategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ShopCategoryController extends BaseController
{
    /**
     * 显示分类首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cate()
    {

        $cates=ShopCategory::paginate(2);

        return view("admin.admin.cate",compact("cates"));
    }

    /**
     * 添加商铺分类
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     *
     */
    public function cateAdd(Request $request)
    {
        if($request->isMethod("post")){
            $this->validate($request,[
                "name"=>"required",
//                "captcha"=>"captcha"
            ]);
            $data=$request->all();
            $data["img"]="";
            if ($request->file("img")){
                $data["img"]="/uploads/images/".$request->file("img")->store("img","images");
            }
            if (ShopCategory::create($data)) {
                $request->session()->flash("success","添加成功");
                return redirect()->route("admin.cate");
            }
        }
        return view("admin.admin.cate_add");
    }

    /**
     * 编辑分类
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     *
     */
    public function cateEdit(Request $request,$id)
    {
        $dd=ShopCategory::findOrFail($id);
        if($request->isMethod("post")){
            $this->validate($request,[
                "name"=>"required",
//                "captcha"=>"captcha"
            ]);
            $data=$request->all();
            $data["img"]="";
            if ($request->file("img")){
                $data["img"]="/uploads/images/".$request->file("img")->store("img","images");
            }else{
                unset($data["img"]);
            }
            if ($dd->update($data)) {
                $request->session()->flash("success","编辑成功");
                return redirect()->route("admin.cate");
            }else{
                $request->session()->flash("warning","编辑失败");
                return redirect()->back()->withInput();
            }
        }
        return view("admin.admin.cate_edit",compact("dd"));
    }

    /**
     * 分类禁用或启用
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cateStatus(Request $request,$id)
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

    /**
     * 删除分类
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function cateDel(Request $request,$id)
    {
        $count= User::where("shop_id",$id)->count();
//var_dump($count);
        if($count>0){
            $request->session()->flash("danger","分类下仍有商铺不能删除");
            return redirect()->route("admin.cate");
        }else{
            $data=ShopCategory::findOrFail($id);

            $img= public_path($data->img);
            if($data->delete() && File::delete($img)  ){
                $request->session()->flash("success","已删除");
                return redirect()->route("admin.cate");
            }
        }

    }

}
