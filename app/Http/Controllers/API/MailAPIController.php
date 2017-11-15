<?php
/**
 * Created by PhpStorm.
 * User: Ernes
 * Date: 13/11/2017
 * Time: 15:35
 */

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Repositories\MailRepository;
use Response;
use Mail;

class MailAPIController extends AppBaseController
{
    /** @var  MailRepository */
    private $mailRepository;

    public function __construct(MailRepository $mailRepo)
    {
        $this->mailRepository = $mailRepo;
    }

    public function send(Request $request)
    {
        $name = $request->input('name');
        $mail = $request->input('mail');
        $phone = $request->input('phone');
        $title = $request->input('subject');
        $content = $request->input('body');

        try{
            Mail::send('emails.send', ['name' => $name, 'mail' => $mail, 'phone' => $phone,
                'title' => $title, 'content' => $content],
                function ($message)
                {
                    $message->from('cocinascastillo@escalonasoftware.com', 'App Cocinas Castillo');
                    $message->to('ernestoesc85@gmail.com', 'App Cocinas Castillo');
                    $message->bcc(['appcocinascastillo@gmail.com','cocinascastillo@escalonasoftware.com'], 'App Cocinas Castillo');
                }
            );

            $input = $request->all();
            $this->mailRepository->create($input);

        }catch (\Exception $e){
            dd($e);
        }

        return response()->json(['message' => 'Request completed']);
    }
}