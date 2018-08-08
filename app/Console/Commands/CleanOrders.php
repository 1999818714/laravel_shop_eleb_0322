<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清理超时未支付订单';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    //命令逻辑
    public function handle()
    {
        set_time_limit(0);//最大执行时间,一直跑
        //死循环一直执行
        while (true){
            //当前时间->创建时间 = 15分钟
            $time = time();
            $date_time = date('Y-m-d H:i:s',$time-15*60);//获得超时时间
            //and status=0 时才能执行sql  2018-08-06 16:36:58
//            DB::update("update `orders` set status=-1 WHERE created_at<'{$date_time}' and status=0");
            //转换编码格式 ，两种函数 iconv() mb_convert_encoding();
            echo iconv('utf-8','gbk','订单清理完成').date('Y-m-d H:i:s',time())."\n";
            sleep(2);
        }
    }
}
