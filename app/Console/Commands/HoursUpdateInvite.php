<?php

namespace App\Console\Commands;

use App\Models\Benefit;
use App\Models\Invite;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HoursUpdateInvite extends Command
{
    protected $signature = 'hoursUpdateInvite';

    protected $description = '每小时更新邀请奖励信息';


    public function __construct()
    {
        parent::__construct();

    }

    public function handle()
    {

        try {
            DB::connection()->enableQueryLog();
            //todo 目前只有二级分类.level_relation为父id,可直接使用,后期若层级增加需额外处理
            $invitedList = Benefit::where('level_relation', '!=', 0)->get(['user_id', 'level_relation', 'benefit','status']);
            $effectiveInvite = config('pdd.effective_invite');//有效邀请金额
            $inviteReward = config('pdd.invite_reward'); //邀请奖励金额

            foreach ($invitedList as $item) {

                if ($item->benefit >= $effectiveInvite) {



                    $invit = Invite::firstOrCreate([
                        'user_id' => $item->level_relation,
                        'invite_uid' => $item->user_id
                    ], [
                        'status' => Invite::STATUS_ING,
                        'benefit' => $inviteReward
                    ]);

                    if ($item->status == Benefit::STATUS_FINISH && $invit->status == Invite::STATUS_ING) {
                        DB::transaction(function () use ($item, $inviteReward) {

                            Invite::where([
                                'user_id' => $item->level_relation,
                                'invite_uid' => $item->user_id
                            ])->update(['status'=>Invite::STATUS_FINISH]);

                            User::where('id', $item->level_relation)->increment('balance', $inviteReward);

                            Log::info('邀请奖励:邀请人:' . $item->level_relation . '被邀请人:' . $item->usere_id);
                        });
                    }

                    Log::info(DB::getQueryLog());
                }
            }

        } catch (\Exception $exception) {
            Log::error('minutesUpdateOrder exception: '
                . $exception->getMessage()
                . $exception->getTraceAsString());
        }
    }
}
