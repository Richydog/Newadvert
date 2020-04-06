<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Carbon\Carbon;
use App\Services\smsru_php\SMSRU;
use App\Services\smsru_php\stdClass;
class PhoneController extends Controller
{
  //  private $sms;
  //  public function __construct(SmsSender $sms)
    /*
* @property string $phone
*/
    public function request(Request $request){

        $user=Auth::user();
        try{
            $token=$user->requestPhoneVerification(Carbon::now());
         //   $this->sms->send($user->phone,'Phone verification token:'  . $token);
            $smsru = new SMSRU('3A3BA954-CD70-A267-BB25-01CBA2229F65'); // Ваш уникальный программный ключ, который можно получить на главной странице

            $data = new stdClass();
            $data->to = $user->phone;
            $data->text = $token; // Текст сообщения
// $data->from = ''; // Если у вас уже одобрен буквенный отправитель, его можно указать здесь, в противном случае будет использоваться ваш отправитель по умолчанию
// $data->time = time() + 7*60*60; // Отложить отправку на 7 часов
// $data->translit = 1; // Перевести все русские символы в латиницу (позволяет сэкономить на длине СМС)
 $data->test = 1; // Позволяет выполнить запрос в тестовом режиме без реальной отправки сообщения
// $data->partner_id = '1'; // Можно указать ваш ID партнера, если вы интегрируете код в чужую систему
            $sms = $smsru->send_one($data); // Отправка сообщения и возврат данных в переменную

            if ($sms->status == "OK") { // Запрос выполнен успешно
                echo "Сообщение отправлено успешно. ";
                echo "ID сообщения: $sms->sms_id. ";
             //   echo "Ваш новый баланс: $sms->balance";
            } else {
                echo "Сообщение не отправлено. ";
                echo "Код ошибки: $sms->status_code. ";
                echo "Текст ошибки: $sms->status_text.";
            }
        }catch (\DomainException $e){
            $request->session()->flash('error',$e->getMessage());
        }
        return redirect()->route('profilyphone');
    }

    public function form(){
        $user=Auth::user();
        return view('cabinet.profile.phone',compact('user'));
    }
    public function verify(Request $request){
        $this->validate($request,[
            'token'=>'required|string|max:255',
        ]);
        $user=Auth::user();

        try{
            $user->verifyPhone($request['token'],Carbon::now());
        }catch (\DomainException $e){
            return redirect()->route('profilyphone')->with('error',$e->getMessage());
        }
        return redirect()->route('profilyhome');
    }
}
