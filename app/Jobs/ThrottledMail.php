<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Mail;


class ThrottledMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user;
    public $mail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Mailable $mail,User $user)
    {
        $this->mail = $mail;
        $this->user = $user;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::thatIsAdmin($this->user->id)->get();
        dd($user);
    }
}
