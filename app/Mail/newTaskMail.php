<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class newTaskMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $theme;
    protected $date;
    protected $task;
    protected $name;
    protected $group;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $date, $task, $theme, $group)
    {
        $this->name = $name;
        $this->date = $date;
        $this->task = $task;
        $this->theme = $theme;
        $this->group = $group;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('neue Aufgabe')->view('mails.newTaskMail',[
            "name" =>$this->name,
            "date" =>$this->date,
            "task" =>$this->task,
            "theme" =>$this->theme,
            "group" =>$this->group,
        ]);
    }
}
