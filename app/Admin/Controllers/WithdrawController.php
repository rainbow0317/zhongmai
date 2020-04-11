<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Withdraw\Check;
use App\Models\Withdraw;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class WithdrawController extends Controller
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
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Withdraw);

        $grid->id('Id')->sortable();
        $grid->created_at('时间');
        $grid->user_id('用户id')->sortable();
        $grid->column('user.phone', '手机号');
        $grid->amount( '金额')->display(function ($amount) {
            return round($amount/100,2);
        })->sortable();
        $grid->status('状态')->using([0 => '未处理',1=> '已处理',2=>'审核失败']);

        $grid->disableCreateButton();
//        $grid->disableActions();
        $grid->disableExport();
        $grid->actions(function ($actions) {
            $actions->add(new Check()  );
        });
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('user_id', '用户id');

        });
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
        $show = new Show(Withdraw::findOrFail($id));

        $show->id('Id');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->user_id('User id');
        $show->amount('Amount');
        $show->channel('Channel');
        $show->status('Status')->using([0 => '未处理',1=> '已处理',2=>'审核失败']);

        return $show;
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Withdraw);

        $form->number('user_id', 'User id');
        $form->number('amount', 'Amount');
        $form->switch('channel', 'Channel')->default(1);
        $form->switch('status', 'Status');

        return $form;
    }
}
