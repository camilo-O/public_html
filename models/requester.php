<?php
    class Requester {
        
        function postFunction($post_data, $url){
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($post_data),
            CURLOPT_HTTPHEADER => array(
                'keyPlease: claveDePrueba420',
                'Content-Type: application/x-www-form-urlencoded'
            )
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            return $response;
        }

        function postFormulario($post_data, $url){
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($post_data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            )
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            return $response;
        }

        function getFunction($url){
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'keyPlease: claveDePrueba420'
            )
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            return $response;
        }

        function putFunction($put_data, $url){
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => $put_data,
            CURLOPT_HTTPHEADER => array(
                'keyPlease: claveDePrueba420',
                'Content-Type: application/x-www-form-urlencoded'
            )
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return $response;
        }

        function deleteFunction($url){
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => array(
                'keyPlease: claveDePrueba420'
            )
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return $response;
        }

        function sendEmail($email, $subject, $body){
            require_once '../vendor/phpmailer/phpmailer/src/Exception.php';
            require_once '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
            require_once '../vendor/phpmailer/phpmailer/src/SMTP.php';
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            $mail->ContentType = 'text/html; charset=UTF-8';
            $mail->IsSMTP(); // enable SMTP
            $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
            $mail->Host = "smtp.titan.email";
            $mail->Port = 465; // or 587
            $mail->IsHTML(true);
            $mail->Username = "noreply@serenaccion.com.co";
            $mail->Password = "HYemrh0a9y";
            $mail->SetFrom("noreply@serenaccion.com.co");
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AddAddress($email);
            return $mail;
        }

        function storeArrayAsCookies($array, $time = 604800) {
            foreach ($array as $index => $value) {
                $this->storeCookie($index, $value, $time);
            }
        }
        function storeCookie($index, $value, $time){
            setcookie($index, $value, time() + ($time), "/", '.serenaccion.com.co', true, true); //, '.serenaccion.com.co', true, true
        }
    }
?>