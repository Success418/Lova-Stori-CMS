<?php
/**
 * System messages translation for CodeIgniter(tm)
 *
 * @author CodeIgniter community
 * @author Mutasim Ridlo, S.Kom
 * @copyright Copyright (c) 2014-2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://codeigniter.com
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['email_must_be_array'] = 'Metode validasi email harus melewati sebuah array.';
$lang['email_invalid_address'] = 'Alamat email salah: %s';
$lang['email_attachment_missing'] = 'Tidak dapat menemukan lampiran email: %s';
$lang['email_attachment_unreadable'] = 'Tidak dapat membuka lampiran ini: %s';
$lang['email_no_from'] = 'Tidak dapat mengirim email tanpa "From" header.';
$lang['email_no_recipients'] = 'Anda harus menyertakan penerima: Ke, Cc, atau Bcc';
$lang['email_send_failure_phpmail'] = 'Tidak dapat mengirim email menggunakan surat PHP(). Server Anda mungkin tidak dikonfigurasikan untuk mengirim email menggunakan metode ini.';
$lang['email_send_failure_sendmail'] = 'Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.';
$lang['email_send_failure_smtp'] = 'Unable to send email using PHP SMTP. Your server might not be configured to send mail using this method.';
$lang['email_sent'] = 'Your message has been successfully sent using the following protocol: %s';
$lang['email_no_socket'] = 'Unable to open a socket to Sendmail. Please check settings.';
$lang['email_no_hostname'] = 'You did not specify a SMTP hostname.';
$lang['email_smtp_error'] = 'The following SMTP error was encountered: %s';
$lang['email_no_smtp_unpw'] = 'Error: You must assign a SMTP username and password.';
$lang['email_failed_smtp_login'] = 'Failed to send AUTH LOGIN command. Error: %s';
$lang['email_smtp_auth_un'] = 'Failed to authenticate username. Error: %s';
$lang['email_smtp_auth_pw'] = 'Failed to authenticate password. Error: %s';
$lang['email_smtp_data_failure'] = 'Unable to send data: %s';
$lang['email_exit_status'] = 'Exit status code: %s';
