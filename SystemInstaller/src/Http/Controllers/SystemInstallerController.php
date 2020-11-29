<?php

namespace AfzalSabbir\SystemInstaller\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class SystemInstallerController extends Controller
{
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
}
