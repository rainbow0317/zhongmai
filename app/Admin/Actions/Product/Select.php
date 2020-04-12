<?php

namespace App\Admin\Actions\Product;

use App\Models\Selects;
use Encore\Admin\Actions\RowAction;
use Illuminate\Http\Request;

class Select extends RowAction
{
    public $name = '加入优选';

    public function handle(Request $request)
    {
        $infos = $request->get('data');
        $infos = json_decode($infos,true);

        $infos['text'] = nl2br( $request->get('infos'));

        Selects::updateOrCreate(['goods_id'=>$infos['goods_id']],
            $infos
        );

        return $this->response()->success('添加成功')->refresh();
    }

//
    public function form()
    {
        $infos = $this->getRow();
//

        if ($infos) {

            $res['goods_id'] = $infos->goods_id;
            $res['has_coupon'] = $infos->has_coupon;
            $res['coupon_discount'] = $infos->coupon_discount;
            $res['promotion_rate'] = $infos->promotion_rate;
            $res['min_group_price'] = $infos->promotion_rate;
            $res['coupon_remain_quantity'] = $infos->coupon_remain_quantity;
            $res['goods_name'] = $infos->goods_name;
            $res['mall_name'] = $infos->mall_name;
            $res['sales_tip'] = $infos->sales_tip;
            $res['search_id'] = $infos->search_id;
            $res['goods_image_url'] = $infos->goods_image_url;
            $res['min_group_price'] = $infos->min_group_price;


            $this->hidden('data')->value(json_encode($res));
        }
        $this->textarea('infos', '请在此编辑文案,分享链接会在用户推广时,自动追加到文案末尾')->rules('required');
    }

}