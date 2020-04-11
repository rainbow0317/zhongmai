<?php

namespace App\Admin\Actions\Withdraw;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use function PHPSTORM_META\type;

class Check extends RowAction
{
    public $name = '提现审核操作';

    public function handle(Model $model, Request $request)
    {
        // 获取到表单中的`type`值
        $type = $request->get('type');

        if ($type !=0){
            return $this->response()->error('请勿重复处理');
        }

        //更新
        $model->where('id',$model->id)->update(['status' => $type]);

        admin_toastr(__('更新成功'));
        return $this->response()->success('提现处理完成')->refresh();

    }

    public function form()
    {
        $type = [
            1 => '打款成功',
            2 => '提现审核失败',
        ];

        $this->radio('type', '操作')->options($type)->rules('required');
//        $this->textarea('reason', '审核失败原因');
    }
}