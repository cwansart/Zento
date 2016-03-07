<?php

namespace Zento\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Zento\Appointment;

class AppointmentReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a reminder for an appointment via Email if a user has set one';

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
    public function handle()
    {
        // Get all appointments of the next 12 hours with a reminder
        $appointments = Appointment::query()->where('start', '>', Carbon::now())
            ->where('start', '<', Carbon::now()->addHour(12))
            ->get();

        foreach($appointments as $appointment)
        {
            foreach($appointment->trainer as $trainer)
            {
                if ($trainer->pivot->reminder == 12)
                {
                    $to = [];
                    $to[] = $trainer->email;
                    $reply = 'webmaster@zento.dev';

                    $errors = [];

                    $data = array(
                        'appointment' => $appointment,
                        'user' => $trainer,
                        'priority' => Appointment::$priority[$trainer->pivot->priority]
                    );

                    try
                    {
                        Mail::send('emails.reminder', $data, function($message) use($to, $reply)
                        {
                            $message->from('reminder@Zento.dev', 'Zento');
                            $message->to($to)->subject('Terminerinnerung');
                            $message->replyTo($reply);
                        });
                    } catch (Exception $e) {
                        $errors[] = $e;
                    }

                    foreach($errors as $error)
                    {
                        $this->info($error);
                    }
                    $appointment->trainer()->updateExistingPivot($trainer->id, ['reminder' => 0]);
                    $this->info('Sent to: '.$trainer->firstname.' '.$trainer->lastname);
                }
            }
        }

        // Get all appointments of the next 24 hours with a reminder
        $appointments = Appointment::query()->where('start', '>', Carbon::now())
            ->where('start', '<', Carbon::now()->addHour(24))
            ->get();

        foreach($appointments as $appointment)
        {
            foreach($appointment->trainer as $trainer)
            {
                if ($trainer->pivot->reminder == 24)
                {
                    $to = [];
                    $to[] = $trainer->email;
                    $reply = 'webmaster@zento.dev';

                    $errors = [];

                    $data = array(
                        'appointment' => $appointment,
                        'user' => $trainer,
                        'priority' => Appointment::$priority[$trainer->pivot->priority]
                    );

                    try
                    {
                        Mail::send('emails.reminder', $data, function($message) use($to, $reply)
                        {
                            $message->from('reminder@Zento.dev', 'Zento');
                            $message->to($to)->subject('Terminerinnerung');
                            $message->replyTo($reply);
                        });
                    } catch (Exception $e) {
                        $errors[] = $e;
                    }

                    foreach($errors as $error)
                    {
                        $this->info($error);
                    }
                    $appointment->trainer()->updateExistingPivot($trainer->id, ['reminder' => 0]);
                    $this->info('Sent to: '.$trainer->firstname.' '.$trainer->lastname);
                }
            }
        }
        // Console output
        $this->info('Success!');
    }
}
