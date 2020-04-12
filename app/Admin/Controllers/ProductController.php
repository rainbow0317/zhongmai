<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Product\Select;
use App\Admin\Actions\Withdraw\Check;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Share;
use App\Models\Withdraw;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class ProductController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param  \Encore\Admin\Layout\Content $content
     * @return \Encore\Admin\Layout\Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('选品管理')
            ->body($this->grid());

    }

    /**
     * Make a grid builder.
     *
     * @return \Encore\Admin\Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product);

        $grid->column('goods_image_url', '商品图片')->image()->width(200);
        $grid->goods_name('商品名称')->display(function ($name){
            $href ='http://'.env('PDD_GOODS_LINK').$this->goods_id;
            return '<a target ="__blank" href ="'.$href.'"</a>'.$name.'</a>';
        })->width(500);
        $grid->min_group_price('价格')->display(function ($amount) {
            return round($amount / 100, 2) . '元';
        });

        $grid->column('min_price', '券后价')->display(function (){

            $amount = $this->min_group_price- $this->coupon_discount;
            return round($amount / 100, 2) . '元';
        });

        $grid->column('promotion', '佣金')->display(function (){
            $amount = $this->min_group_price- $this->coupon_discount;

            $pddPromotion = round($amount * $this->promotion_rate / 1000, 2);

            return round($pddPromotion / 100, 2) . '元';
        });
        $grid->sales_tip('销量');
        $grid->mall_name('店铺名称');

        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->equal('search', '搜索');

        });
        $grid->disableBatchActions();
        $grid->disableCreateButton();
        $grid->disableExport();
        $grid->actions(function ($actions) {
            $actions->disableView();   // 不在每一行後面展示查看按鈕
            $actions->disableDelete(); // 不在每一行後面展示刪除按鈕
            $actions->disableEdit();   // 不在每一行後面展示編輯按鈕
            $actions->add(new Select);
        });




//        foreach ($list as $key => $val) {
//            $res[$key]['goods_id'] = $val['goods_id'];
//            $res[$key]['has_coupon'] = $val['has_coupon'];
//            $res[$key]['coupon_remain_quantity'] = $val['coupon_remain_quantity'];
//            $res[$key]['goods_name'] = $val['goods_name'];
//            $res[$key]['mall_name'] = mb_substr($val['mall_name'], 0, 7);
//            $res[$key]['sales_tip'] = $val['sales_tip'];
//            $res[$key]['search_id'] = $val['search_id'];
//            $res[$key]['goods_image_url'] = $val['goods_image_url'];
//
//            $minPrice = $val['min_group_price'] - $val['coupon_discount'];
//            $pddPromotion = round($minPrice * $val['promotion_rate'] / 1000, 2);
//            $res[$key]['promotion'] = round($pddPromotion / 100, 2);
//
//            $res[$key]['min_group_price'] = round($val['min_group_price'] / 100, 2);
//            $res[$key]['min_normal_price'] = round($val['min_normal_price'] / 100, 2);
//            $res[$key]['coupon_discount'] = intval($val['coupon_discount'] / 100);
//            $res[$key]['min_price'] = round($minPrice / 100, 2);
//        }

        return $grid;
    }

    protected function  edit(Product $product){
        dd($product);

    }

    protected function form()
    {
        $form = new Form(new Product());

        $form->text('infos', 'infos');

        return $form;
    }

}
