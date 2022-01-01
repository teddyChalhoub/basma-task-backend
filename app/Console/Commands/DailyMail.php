<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DailyMail extends Command
{
    /**
     * @var UserRepositoryInterface
     */
    private  $userRepository;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Respectively send an average registered cutomers daily via email.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $date = Carbon::today();
        $date2 = Carbon::today();
        $date2->addHours(24);

        $users_nb = $this->userRepository->allUserCount();
        $users = $this->userRepository->all();

        $average_registered = 0;
        $users_nb_per_date=0;

        if($users_nb !== 0){
         $users_nb_per_date = $this->userRepository->fetchUserPerDate($date,$date2);
         $average_registered = round(($users_nb_per_date / $users_nb) * 100,2);
        }

        foreach($users as $user){

             $data = array(
                 "total_customers"=>$users_nb,
                 "regitered_per_day"=>$users_nb_per_date,
                 "average_registered"=>$average_registered,
                 "name"=>$user->name
             );

             Mail::send('email.email',$data,function ($mail) use($user) {
                 $mail->from(env("MAIL_USERNAME"));
                 $mail->to($user->email)
                     ->subject('Daily average customers registered');
             });

        }


        $this->info('Successfully sent daily average customers registered.');
    }
}
