<?php

namespace AfzalSabbir\SystemInstaller\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use AfzalSabbir\SystemInstaller\Http\Mail\MailChecker;
use Illuminate\Support\Facades\Mail;
use Session, Config;

class SystemInstallerController extends Controller
{
	/**
     * Create a new message instance.
     *
     * @return void
	 */
	public function __construct()
	{
		$this->aEmpty = 'empty><line';
	}

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		Session::remove('requirments');
	    return view('SystemInstaller::init');
	}

	/**
	 * [requirments description]
	 * @return [type] [description]
	 */
	public function requirments()
	{
		$requirments = config('SystemInstaller.requirments');
	    return view('SystemInstaller::requirments', ['requirments' => $requirments]);
	}

	/**
	 * [directories description]
	 * @return [type] [description]
	 */
	public function directories()
	{
		$directories = config('SystemInstaller.directories');
	    return view('SystemInstaller::directories', ['directories' => $directories]);
	}

	/**
	 * [setups description]
	 * @return [type] [description]
	 */
	public function setups()
	{
		if(!Session::get('requirments')) return redirect()->route('system.installer.init');
		$setups = config('SystemInstaller.setups');
	    return view('SystemInstaller::setups', ['setups' => $setups]);
	}

	/**
	 * [finish description]
	 * @return [type] [description]
	 */
	public function finish()
	{
		if(!Session::get('requirments')) return redirect()->route('system.installer.init');

		$requestData = request()->except('_token');
		$newEnv = $this->getEnv($requestData);
		$envArr = $this->formatEnv($requestData, $newEnv);
		$this->rewriteEnv($envArr);

		return redirect()->route('system.installer.migration');
	}

	/**
	 * [giveDoubleQuote description]
	 * @param  [type] $str [description]
	 * @return [type]      [description]
	 */
	private function giveDoubleQuote($str)
	{
		return substr_count($str, " ") ? '"'.$str.'"' : $str;
	}

	/**
	 * [rewriteEnv description]
	 * @param  [type] $envArr  [description]
	 * @return [type]          [description]
	 */
	private function rewriteEnv($envArr)
	{
		$dotEnv = fopen(base_path(".env"), "w") or die("Unable to open file!");
		foreach($envArr as $value) fwrite($dotEnv, $value.PHP_EOL);
		fclose($dotEnv);
	}

	/**
	 * [getEnv description]
	 * @param  [type] $requestData [description]
	 * @return [type]              [description]
	 */
	private function getEnv($requestData)
	{
		$env = file(base_path('.env'), FILE_IGNORE_NEW_LINES);
		$newEnv = [];
		foreach ($env as $key => $e) {
			$arr = explode('=', $e);
			if(count($arr) > 2) $arr[1] = implode('=', array_slice($arr, 1));
			$newEnv[count($arr) >= 2 ? $arr[0]:$key] = count($arr) >= 2 ? $arr[1]:$this->aEmpty;
		}
		return $newEnv;
	}

	/**
	 * [formatEnv description]
	 * @param  [type] $requestData [description]
	 * @param  [type] $newEnv      [description]
	 * @return [type]              [description]
	 */
	private function formatEnv($requestData, $newEnv)
	{
		$envArr = [];
		foreach ($requestData as $key => $data) $newEnv[$key] = $data;
		foreach ($newEnv as $key => $e) $envArr[] = $e == $this->aEmpty ? '' : implode('=', [$key, $this->giveDoubleQuote($e)]);

		return $envArr;
	}

	/**
	 * [migration description]
	 * @return [type] [description]
	 */
	public function migration()
	{
		\Artisan::call('migrate:fresh', ['--force' => true]);

		return redirect()->route('welcome');
	}

	/**
	 * [checkDatabase description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function checkDatabase(Request $request)
	{
		try {
			$this->setDBConfig($request->all());
		    \DB::connection()->getPdo();
			return response()->json(['message' => 'Connection is ok!', 'status' => 1]);
		} catch (\Throwable $e) {
			return response()->json(['message' => $e->getMessage(), 'status' => 0]);
		}

	}

	/**
	 * [setDBConfig description]
	 * @param [type] $db [description]
	 */
	private function setDBConfig($db)
	{
		$pre = 'database.connections.'.$db['DB_CONNECTION'].'.';
		Config::set($pre.'host', $db['DB_HOST']);
		Config::set($pre.'port', $db['DB_PORT']);
		Config::set($pre.'database', $db['DB_DATABASE']);
		Config::set($pre.'username', $db['DB_USERNAME']);
		Config::set($pre.'password', $db['DB_PASSWORD']);
		return false;
	}

	/**
	 * [checkMail description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function checkMail(Request $request)
	{
		try {
			$this->setMailConfig($request->all());
			$description = 'Testing Mail!';
			Mail::to(config('mail.from.address'))->send(new MailChecker($description));
			return response()->json(['message' => 'Connection is ok!', 'status' => 1]);
		} catch (\Throwable $e) {
			return response()->json(['message' => $e->getMessage(), 'status' => 0]);
		}

	}

	/**
	 * [setMailConfig description]
	 * @param [type] $mail [description]
	 */
	private function setMailConfig($mail)
	{
		$pre = 'mail.mailers.'.$mail['MAIL_MAILER'];
		// Config::set('mail.default', $mail['MAIL_MAILER']);
		Config::set($pre.'.transport', $mail['MAIL_MAILER']);
		Config::set($pre.'.host', $mail['MAIL_HOST']);
		Config::set($pre.'.port', $mail['MAIL_PORT']);
		Config::set($pre.'.username', $mail['MAIL_USERNAME']);
		Config::set($pre.'.password', $mail['MAIL_PASSWORD']);
		Config::set($pre.'.encryption', $mail['MAIL_ENCRYPTION']);
		Config::set('mail.from.address', $mail['MAIL_FROM_ADDRESS']);
		return false;
	}
}
