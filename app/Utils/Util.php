<?php

namespace App\Utils;

use App\Business;
use App\ReferenceCount;
use App\Unit;
use App\Transaction;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class Util
{
    /**
     * This function unformats a number and returns them in plain eng format
     *
     * @param int $input_number
     *
     * @return float
     */
    public function num_uf($input_number, $currency_details = null)
    {
          $thousand_separator  = '';
          $decimal_separator  = '';

        if (!empty($currency_details)) {
            $thousand_separator = $currency_details->thousand_separator;
            $decimal_separator = $currency_details->decimal_separator;
        } else {
            $thousand_separator = session()->has('currency') ? session('currency')['thousand_separator'] : '';
            $decimal_separator = session()->has('currency') ? session('currency')['decimal_separator'] : '';
        }

        $num = str_replace($thousand_separator, '', $input_number);
        $num = str_replace($decimal_separator, '.', $num);

        return (float)$num;
    }

    /**
     * This function formats a number and returns them in specified format
     *
     * @param int $input_number
     * @param boolean $add_symbol = false
     *
     * @return string
     */
    public function num_f($input_number, $add_symbol = false, $business_details = null)
    {
        $thousand_separator = !empty($business_details) ? $business_details->thousand_separator : session('currency')['thousand_separator'];
        $decimal_separator = !empty($business_details) ? $business_details->decimal_separator : session('currency')['decimal_separator'];

        $formatted = number_format($input_number, 2, $decimal_separator, $thousand_separator);

        if ($add_symbol) {
            $currency_symbol_placement = !empty($business_details) ? $business_details->currency_symbol_placement : session('business.currency_symbol_placement');
            $symbol = !empty($business_details) ? $business_details->currency_symbol : session('currency')['symbol'];

            if ($currency_symbol_placement == 'after') {
                $formatted = $formatted . ' ' . $symbol;
            } else {
                $formatted = $symbol . ' ' . $formatted;
            }
        }

          return $formatted;
    }

     /**
     * Calculates percentage for a given number
     *
     * @param int $number
     * @param int $percent
     * @param int $addition default = 0
     *
     * @return float
     */
    public function calc_percentage($number, $percent, $addition = 0)
    {
        return ($addition + ($number * ($percent / 100)));
    }

    /**
     * Calculates base value on which percentage is calculated
     *
     * @param int $number
     * @param int $percent
     *
     * @return float
     */
    public function calc_percentage_base($number, $percent)
    {

        return ($number * 100) / (100 + $percent);
    }

    /**
     * Calculates percentage
     *
     * @param int $base
     * @param int $number
     *
     * @return float
     */
    public function get_percent($base, $number)
    {
        $diff = $number - $base;
        return ($diff / $base) * 100;
    }

    //Returns all avilable purchase statuses
    public function orderStatuses()
    {
        return [ 'received' => __('lang_v1.received'), 'pending' => __('lang_v1.pending'), 'ordered' => __('lang_v1.ordered')];
    }

    /**
     * Converts date in business format to mysql format
     *
     * @param string $date
     * @param bool $time (default = false)
     * @return strin
     */
    public function uf_date($date, $time = false)
    {
        $date_format = session('business.date_format');
        $mysql_format = 'Y-m-d';
        if ($time) {
            if (session('business.time_format') == 12) {
                $date_format = $date_format . ' h:i A';
            } else {
                $date_format = $date_format . ' H:i';
            }
            $mysql_format = 'Y-m-d H:i:s';
        }

        return \Carbon::createFromFormat($date_format, $date)->format($mysql_format);
    }

    /**
     * Converts time in business format to mysql format
     *
     * @param string $time
     * @return strin
     */
    public function uf_time($time)
    {
        $time_format = 'H:i';
        if (session('business.time_format') == 12) {
            $time_format = 'h:i A';
        }
        return \Carbon::createFromFormat($time_format, $time)->format('H:i');
    }

    /**
     * Converts time in business format to mysql format
     *
     * @param string $time
     * @return strin
     */
    public function format_time($time)
    {
        $time_format = 'H:i';
        if (session('business.time_format') == 12) {
            $time_format = 'h:i A';
        }
        return \Carbon::createFromFormat('H:i:s', $time)->format($time_format);
    }

    /**
     * Converts date in business format to mysql format
     *
     * @param string $date
     * @param bool $time (default = false)
     * @return strin
     */
    public function format_date($date, $show_time = false, $business_details = null)
    {
        $format = !empty($business_details) ? $business_details->date_format : session('business.date_format');
        if (!empty($show_time)) {
             $time_format = !empty($business_details) ? $business_details->time_format : session('business.time_format');
            if ($time_format == 12) {
                $format .= ' h:i A';
            } else {
                $format .= ' H:i';
            }
        }
        
        return \Carbon::createFromTimestamp(strtotime($date))->format($format);
    }

     /**
     * Checks if the given user is admin
     *
     * @param obj $user
     * @param int $business_id
     *
     * @return bool
     */
    public function is_admin($user, $business_id)
    {
        return $user->hasRole('Admin#' . $business_id) ? true : false;
    }

    /**
     * Sends SMS notification.
     *
     * @param  array $data
     * @return void
     */
    public function sendSms($data)
    {
        $sms_settings = $data['sms_settings'];
        $request_data = [
            $sms_settings['send_to_param_name'] => $data['mobile_number'],
            $sms_settings['msg_param_name'] => $data['sms_body'],
        ];

        if (!empty($sms_settings['param_1']) && !empty($sms_settings['param_val_1'])) {
            $request_data[$sms_settings['param_1']] = $sms_settings['param_val_1'];
        }
        if (!empty($sms_settings['param_2']) && !empty($sms_settings['param_val_2'])) {
            $request_data[$sms_settings['param_2']] = $sms_settings['param_val_2'];
        }
        if (!empty($sms_settings['param_3']) && !empty($sms_settings['param_val_3'])) {
            $request_data[$sms_settings['param_3']] = $sms_settings['param_val_3'];
        }
        if (!empty($sms_settings['param_4']) && !empty($sms_settings['param_val_4'])) {
            $request_data[$sms_settings['param_4']] = $sms_settings['param_val_4'];
        }
        if (!empty($sms_settings['param_5']) && !empty($sms_settings['param_val_5'])) {
            $request_data[$sms_settings['param_5']] = $sms_settings['param_val_5'];
        }
        if (!empty($sms_settings['param_6']) && !empty($sms_settings['param_val_6'])) {
            $request_data[$sms_settings['param_6']] = $sms_settings['param_val_6'];
        }
        if (!empty($sms_settings['param_7']) && !empty($sms_settings['param_val_7'])) {
            $request_data[$sms_settings['param_7']] = $sms_settings['param_val_7'];
        }
        if (!empty($sms_settings['param_8']) && !empty($sms_settings['param_val_8'])) {
            $request_data[$sms_settings['param_8']] = $sms_settings['param_val_8'];
        }
        if (!empty($sms_settings['param_9']) && !empty($sms_settings['param_val_9'])) {
            $request_data[$sms_settings['param_9']] = $sms_settings['param_val_9'];
        }
        if (!empty($sms_settings['param_10']) && !empty($sms_settings['param_val_10'])) {
            $request_data[$sms_settings['param_10']] = $sms_settings['param_val_10'];
        }

        $client = new Client();

        if ($sms_settings['request_method'] == 'get') {
            $response = $client->get($sms_settings['url'] . '?'. http_build_query($request_data));
        } else {
            $response = $client->post($sms_settings['url'], [
                'form_params' => $request_data
            ]);
        }
    }

    /**
     * Generates unique token
     *
     * @param void
     *
     * @return string
     */
    public function generateToken()
    {
        return md5(rand(1, 10) . microtime());
    }

    /**
     * Uploads document to the server if present in the request
     * @param obj $request, string $file_name, string dir_name
     *
     * @return string
     */
    public function uploadFile($request, $file_name, $dir_name)
    {
        //If app environment is demo return null
        if (config('app.env') == 'demo') {
            return null;
        }
        
        $uploaded_file_name = null;
        if ($request->hasFile($file_name) && $request->file($file_name)->isValid()) {
            if ($request->$file_name->getSize() <= 20000 ) {
                $new_file_name = time() . '_' . $request->$file_name->getClientOriginalName();
                if($request->$file_name->storeAs($dir_name, $new_file_name)) {
                    $uploaded_file_name = $new_file_name;
                }
            }
        }
        return $uploaded_file_name;
    }
}
