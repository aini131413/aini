<?php

namespace App\Http\Controllers\Shop;

use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MenuCategoryController extends BaseController
{
    /**
     * 分类首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $cates = MenuCategory::paginate(2);
        return view("shop.menu_category.index", compact("cates"));
    }

    /**
     * 添加分类
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request, $shop_id)
    {
        if ($request->isMethod("post")) {
//            var_dump($request->all());exit;
            $this->validate($request, [
                "name" => "required",
                "type_accumulation" => "required",
                "shop_id" => "required",
                "description" => "required"
            ]);
            if ($request->is_selected==1) {
                MenuCategory::where("shop_id", $shop_id)->where("is_selected", 1)->update(["is_selected" => 0]);
            }
            if (MenuCategory::create($request->all())) {
    $request->session()->flash("success", "添加分类成功");
                return redirect()->route("user.index");
            }
        }
        $shops = Shop::all();
        return view("shop.menu_category.add", compact("shops", "shop_id"));

    }

    /**
     * 编辑分类
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $cate = MenuCategory::findOrFail($id);
//        var_dump($request->all());exit;
        if ($request->isMethod("post")) {

            $this->validate($request, [
                "name"=>"required|unique:menu_categories,name,".$id,
//                "type_accumulation" => "required",
//                "shop_id" => "required"
            ]);
            if ($request->is_selected) {
                MenuCategory::where("shop_id", $cate->shop_id)->where("is_selected", 1)->where('id','<>',$id)->update(["is_selected" => 0]);
            }

            if ($cate->update($request->post())) {


                $request->session()->flash("success", "编辑分类成功");
                return redirect()->route("user.index",$id);
            }
        }
        $shops = Shop::all();

        return view("shop.menu_category.edit", compact("shops", "cate"));

    }

    /**
     * 删除分类
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function del(Request $request, $id)
    {
        $count = Menu::where("category_id", $id)->count();

        if ($count > 0) {
            return back()->with("danger", "该分类下还有菜品，不能删除");
        } else {
            if (MenuCategory::findOrFail($id)->delete()) {
                $request->session()->flash("success", "删除成功");
                return redirect()->intended(route("user.index"));
            }
        }


    }

}
