<?php

namespace App\Infrastructure\Mail;

use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContractCreatedFreelancerMail extends Mailable
{
    use Queueable,SerializesModels;

    public function __construct(public Contract $contract){}

    public function build()
    {
        return $this->subject('Contract Created')
            ->view('emails.contracts.freelancer_created');
    }

}
