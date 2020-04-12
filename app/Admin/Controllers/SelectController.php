<?php

namespace App\Admin\Controllers;

use App\Models\Selects;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SelectController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\Selects';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Selects());

        $grid->column('goods_image_url', '商品图片')->image()->width(200);
//        $grid->column('id', __('Id'));
        $grid->column('created_at', '创建时间');
        $grid->column('goods_id','拼多多商品id');
        $grid->column('goods_name', '商品名称');

        $grid->column('text','商品分享文案');
        $grid->disableBatchActions();
        $grid->disableCreateButton();
        $grid->disableActions();
        $grid->disableExport();

        $grid->disableFilter();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Selects::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('goods_id', __('Goods id'));
        $show->field('has_coupon', __('Has coupon'));
        $show->field('sales_tip', __('Sales tip'));
        $show->field('min_group_price', __('Min group price'));
        $show->field('search_id', __('Search id'));
        $show->field('coupon_remain_quantity', __('Coupon remain quantity'));
        $show->field('goods_name', __('Goods name'));
        $show->field('goods_image_url', __('Goods image url'));
        $show->field('mall_name', __('Mall name'));
        $show->field('text', __('Text'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Selects());

        $form->text('goods_id', __('Goods id'));
        $form->text('has_coupon', __('Has coupon'));
        $form->text('sales_tip', __('Sales tip'));
        $form->text('min_group_price', __('Min group price'));
        $form->text('search_id', __('Search id'));
        $form->text('coupon_remain_quantity', __('Coupon remain quantity'));
        $form->text('goods_name', __('Goods name'));
        $form->text('goods_image_url', __('Goods image url'));
        $form->text('mall_name', __('Mall name'));
        $form->text('text', __('Text'));

        return $form;
    }
}
