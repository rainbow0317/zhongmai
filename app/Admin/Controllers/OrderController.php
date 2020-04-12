<?php

namespace App\Admin\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HandleRefundRequest;
use App\Models\Benefit;
use App\Models\Order;
use App\Models\User;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Encore\Admin\Grid\Column;
use Illuminate\Support\Arr;

class OrderController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('订单列表')
            ->description('description')
            ->body($this->grid());
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Benefit());

        $users = User::get(['id','phone'])->toArray();
        $users = Arr::pluck($users,'phone','id');

        $grid->model()->orderBy('id', 'desc');

        $grid->column('order.image_url', '商品图片')->image();
        $grid->id('id');
        $grid->created_at('创建时间')->sortable();
        $grid->column('order.order_sn', '拼多多订单编号');
        $grid->column('user_id', '推广人手机')->display(function ($user_id) use ($users) {
            return
                '<p>用户id : '.$user_id.'</p><p>手机号 : '.Arr::get($users,$user_id,'').'</p>';

    })->sortable();
        $grid->column('order.goods_name', '商品名称');

        $grid->column('order.order_amount', '订单金额')->display(function ($amount) {
            return round($amount/100,2).'元';
        })->sortable();
        $grid->column('order.goods_quantity', '订单数量');
        $grid->column('order.actual_promotion_amount', '拼多多实际佣金')->display(function ($amount) {
            return round($amount/100,2).'元';
        })->sortable();
        $grid->benefit('推广人佣金')->display(function ($amount) {
            return round($amount/100,2).'元';
        })->sortable();
        $grid->type('佣金类型')->using([1 => '直接抽佣',2=>'上级抽佣']);

        $grid->column('order.status', '订单状态')
            ->using([-1=>'未支付',0 => '已支付',1=> '已成团',2=>'确认收货',3=>'审核成功',4=>'审核失败',5=>'已经结算',8=>'非多多进宝商品（无佣金订单']);
        $grid->column('order.fail_reason', '失败原因');

        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->equal('user_id', '用户id');

        });
        $grid->disableBatchActions();
        $grid->disableCreateButton();
        $grid->disableActions();
        $grid->disableExport();

        return $grid;
    }

}
