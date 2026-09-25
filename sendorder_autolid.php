<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if (empty($_POST['agreement'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Необходимо согласие на обработку персональных данных']);
    exit;
}

$formData = [
   // Модалка
   'selected_date' => $_POST['selected_date'] ?? null,
   'selected_time' => $_POST['selected_time'] ?? null,

   // Калькуляторы:

   // КАСКО:
   'car-year' => $_POST['car-year'] ?? null,
   'car-brand' => $_POST['car-brand'] ?? null,
   'car-model' => $_POST['car-model'] ?? null,
   'object-price' => $_POST['object-price'] ?? null,
   'avtomobil-v-kredit' => $_POST['avtomobil-v-kredit'] ?? null,
   'bank-name' => array_key_exists('bank-name', $_POST) ? ($_POST['bank-name'] ?: 'Сбербанк') : null,
   'mesto-reg-sobst' => $_POST['mesto-reg-sobst'] ?? null,
   'city' => $_POST['city'] ?? null,
   'forma-sobstvennosti' => $_POST['forma-sobstvennosti'] ?? null,
   'drivers' => $_POST['drivers'] ?? null,
   'driver-age-1' => $_POST['driver-age-1'] ?? null,
   'driver-age-2' => $_POST['driver-age-2'] ?? null,
   'driver-age-3' => $_POST['driver-age-3'] ?? null,
   'driver-age-4' => $_POST['driver-age-4'] ?? null,
   'driver-age-5' => $_POST['driver-age-5'] ?? null,
   'driver-age' => $_POST['driver-age'] ?? null,
   'driver-experience-1' => $_POST['driver-experience-1'] ?? null,
   'driver-experience-2' => $_POST['driver-experience-2'] ?? null,
   'driver-experience-3' => $_POST['driver-experience-3'] ?? null,
   'driver-experience-4' => $_POST['driver-experience-4'] ?? null,
   'driver-experience-5' => $_POST['driver-experience-5'] ?? null,
   'min-driver-age' => $_POST['min-driver-age'] ?? null,
   'min-driver-experience' => $_POST['min-driver-experience'] ?? null,

   'gender' => $_POST['gender'] ?? null,
   'driver-gender-1' => $_POST['driver-gender-1'] ?? null,
   'driver-gender-2' => $_POST['driver-gender-2'] ?? null,
   'driver-gender-3' => $_POST['driver-gender-3'] ?? null,
   'driver-gender-4' => $_POST['driver-gender-4'] ?? null,
   'driver-gender-5' => $_POST['driver-gender-5'] ?? null,

   'married' => $_POST['married'] ?? null,

   'driver-married-1' => $_POST['driver-married-1'] ?? null,
   'driver-married-2' => $_POST['driver-married-2'] ?? null,
   'driver-married-3' => $_POST['driver-married-3'] ?? null,
   'driver-married-4' => $_POST['driver-married-4'] ?? null,
   'driver-married-5' => $_POST['driver-married-5'] ?? null,

   'kids-1' => $_POST['kids-1'] ?? null,
   'kids-2' => $_POST['kids-2'] ?? null,
   'kids-3' => $_POST['kids-3'] ?? null,
   'kids-4' => $_POST['kids-4'] ?? null,
   'kids-5' => $_POST['kids-5'] ?? null,
   'kids' => $_POST['kids'] ?? null,

   // Поле для загрузки фотографии полиса
   'insurance-policy-img' => $_FILES['insurance-policy-img'] ?? null,

   // ОСАГО
   'car-engine-power' => $_POST['car-engine-power'] ?? null,

   // Ипотека
   'ipoteka-check-group' => $_POST['ipoteka-check-group'] ?? null,
   'ipoteka-check-group-child' => $_POST['ipoteka-check-group-child'] ?? null,
   'age' => $_POST['age'] ?? null,
   'summa-kredita' => $_POST['summa-kredita'] ?? null,

   // ДМС для физических лиц
   'additional-dms-services' => $_POST['additional-dms-services'] ?? null,
   'dms-additional-fld' => $_POST['dms-additional-fld'] ?? null,

   // ДМС для физических лиц
   'employee-quantity' => $_POST['employee-quantity'] ?? null,

   //  Несчастный случай
   'ns-sport' => $_POST['ns-sport'] ?? null,
   'sport-level' => $_POST['sport-level'] ?? null,
   'ns-additional-fld' => $_POST['ns-additional-fld'] ?? null,
   'insurance-period' => $_POST['insurance-period'] ?? null,
   'insurance-amount' => $_POST['insurance-amount'] ?? null,

   // Страховани квартиры
   'risks' => $_POST['risks'] ?? null,
   'insurance-objects' => $_POST['insurance-objects'] ?? null,
   'obj-insurance-amount' => $_POST['obj-insurance-amount'] ?? null,

   // Страхование дома
   'obj-features' => $_POST['obj-features'] ?? null,
   'risk-pakets' => $_POST['risk-pakets'] ?? null,

   // Синяя (Зеленая карта) Беларусь
   'get-policy-method' => $_POST['get-policy-method'] ?? null,
   'delivery-address' => $_POST['delivery-address'] ?? null,
   'delivery-date' => $_POST['delivery-date'] ?? null,
   'delivery-time' => $_POST['delivery-time'] ?? null,

   // Выезжающим за рубеж
   'ride-country' => $_POST['ride-country'] ?? null,
   'rest-type' => $_POST['rest-type'] ?? null,
   'p-additional-services' => $_POST['p-additional-services'] ?? null,
   'p-date' => $_POST['p-date'] ?? null,
   'p-days' => $_POST['p-days'] ?? null,
   'coverage' => $_POST['coverage'] ?? null,

   // Страхование груза
   'transport-type' => $_POST['transport-type'] ?? null,
   'total-cargo-price' => $_POST['total-cargo-price'] ?? null,
   'departure-point' => $_POST['departure-point'] ?? null,
   'destination-point' => $_POST['destination-point'] ?? null,
   'inn' => $_POST['inn'] ?? null,

   // Страхование ОПО
   'dangerous-object' => $_POST['dangerous-object'] ?? null,
   'dangerous-object-location' => $_POST['dangerous-object-location'] ?? null,

   // Страхование коммерческой недвижимости
   'room-square' => $_POST['room-square'] ?? null,
   'kn-floor' => $_POST['kn-floor'] ?? null,
   'object-purpose' => $_POST['object-purpose'] ?? null,

   // Страхование ОСГОП
   'ost-forma-sobstvennosti' => $_POST['ost-forma-sobstvennosti'] ?? null,
   'ost-avto-number' => $_POST['ost-avto-number'] ?? null,
   'ost-inn' => $_POST['ost-inn'] ?? null,
   'ost-inn-message' => $_POST['ost-inn-message'] ?? null,

   // Страхование ГО для юрлиц
   'go-object-type' => $_POST['go-object-type'] ?? null,

   // Страхование Имущества для юрлиц
   'property-object-type' => $_POST['property-object-type'] ?? null,

   // Общие элементы
   'name' => $_POST['name'] ?? null,
   'phone' => $_POST['phone'] ?? null,
   'email' => $_POST['email'] ?? null,
   'message' => $_POST['message'] ?? null,
   'Страница заявки' => $_POST['page_url'] ?? 'не указано',

   'agreement' => isset($_POST['agreement']) ? 'Да' : 'Нет',
   'agreement_date' => date('d.m.Y H:i:s'),
   'page_url' => $_POST['page_url'] ?? 'не указано',
];

$formType = $_POST['form_type'] ?? 'unknown-form';

sendMail($formData, $formType);

function yesNo($arr, $key) {
   return isset($arr[$key]) ? "Да" : "Нет";
}

function sendMail($formData, $formType)
{

   $mail = new PHPMailer(true);

   try {

    header('Content-Type: application/json');

   $domains = [
      'rosgosstrah' => ['name' => 'Росгосстрах', 'source_id' => "23"],
      'renessans' => ['name' => 'Ренессанс Страхование', 'source_id' => "22"],
      'amt' => ['name' => 'АМТ Страхование', 'source_id' => "0"],
      'reso-garantija' => ['name' => 'РЕСО-Гарантия', 'source_id' => "21"],
      'vsk' => ['name' => 'ВСК', 'source_id' => "25"],
      'alfastrahovanie' => ['name' => 'АльфаСтрахование', 'source_id' => "26"],
      'tinkoff-strahovanie' => ['name' => 'Тинькофф Страхование', 'source_id' => "27"],
      'gajde' => ['name' => 'Гайде', 'source_id' => "28"],
      'sogaz' => ['name' => 'СОГАЗ', 'source_id' => "29"],
      'soglasie' => ['name' => 'Согласие', 'source_id' => "0"],
      'sovkombank-strahovanie' => ['name' => 'Совкомбанк Страхование', 'source_id' => "30"],
      'kapital-polis' => ['name' => 'Капитал Полис', 'source_id' => "0"],
      'energogarant' => ['name' => 'Энергогарант', 'source_id' => "31"],
      'maks' => ['name' => 'МАКС', 'source_id' => "32"],
      'zetta' => ['name' => 'Зетта Страхование', 'source_id' => "33"],
      'sberstrahovanie' => ['name' => 'СберСтрахование', 'source_id' => "34"],
      'jugoriya' => ['name' => 'Югория', 'source_id' => "0"],
      'ingosstrah' => ['name' => 'Ингосстрах', 'source_id' => "24"],
   ];

    $current_host = $_SERVER['HTTP_HOST'];
    $subdomain = explode('.', $current_host)[0];
    $site_name = isset($domains[$subdomain]) ? (string) $domains[$subdomain]['name'] : '';


      $mail->isSMTP();
      $mail->Host = 'smtp.jino.ru';
      $mail->SMTPAuth = true;
      $mail->Username = '*******';
      $mail->Password = '*******';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      $mail->Port = 465;

      $mail->CharSet = 'UTF-8';
      $mail->setFrom('*******', "Новая заявка с основного сайта");
      $mail->addAddress('ra.serov@mail.ru', 'Руслану');
    

      //   Водители КАСКО
      $drivers = [];
      $driversBitrix = [];
      for ($i = 1; $i <= 5; $i++) {
         $age = $formData["driver-age-$i"] ?? null;
         $experience = $formData["driver-experience-$i"] ?? null;
         $gender = $formData["driver-gender-$i"] ?? null;
         $married = $formData["driver-married-$i"] ?? null;
         $kids = $formData["kids-$i"] ?? null;

         if ($age || $experience || $gender || $married || $kids) {
            $driver = implode(':', [$gender, $age]) . ';' . implode(';', [$experience, $kids, $married]);
            $drivers[] = $driver;

            $driverBitrix = "Пол: {$gender} Возраст: {$age} Стаж: {$experience} Дети: {$kids} Брак: {$married}";
            $driversBitrix[] = $driverBitrix;
         }
      }

      //   Водители ОСАГО
      $osagoDrivers = [];
      for ($i = 1; $i <= 5; $i++) {
         $age = $formData["driver-age-$i"] ?? null;
         $experience = $formData["driver-experience-$i"] ?? null;

         if ($age || $experience) {
            $osagoDriver = implode(':', [$age, $experience]);
            $osagoDrivers[] = $osagoDriver;
         }
      }


    $utmKeys = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'];
    $utmValues = [];

    foreach ($utmKeys as $utmKey) {
    if (!empty($_COOKIE[$utmKey])) {
        $utmValues[$utmKey] = $_COOKIE[$utmKey];
    }
    }

      
    
    $current_host = $_SERVER['HTTP_HOST'];
    $subdomain = explode('.', $current_host)[0];
    $site_name = isset($domains[$subdomain]) ? (string) $domains[$subdomain]['name'] : '';

    // Константы
    $config = [
        'user' => 26,
        'from' => 210,
        'from_landing' => 'Страховой Дом ДБК',
        'landing_href' => $current_host,
        'landing_source' => "48" //70
    ];

      switch ($formType) {
         // Форма обратной связи
         case 'default-callme-form':
            $mail->Subject = 'Заявка из формы обратной связи';
            $module = 'question';

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'email' => $formData['email'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'mess' => $formData['message'] ?? '',
               'oper' => 'add',
            ];

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы обратной связи",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744632756" => 5391, //Не по теме
                  "UF_CRM_1744814721142" => $config['landing_href'],

                  "COMMENTS" => trim(($formData['selected_date'] ?? '') . ' ' . ($formData['selected_time'] ?? '')),
               ]
            ];

            break;

         // Модалки
         case 'default-modal-form':
            $mail->Subject = 'Заявка из основной формы';
            $module = 'call';

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',
               'mess' => trim(($formData['selected_date'] ?? '') . ' ' . ($formData['selected_time'] ?? '')),
               'oper' => 'add',
            ];

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из основной формы",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744632756" => 5391, //Не по теме
                  "UF_CRM_1744814721142" => $config['landing_href'],

                  "COMMENTS" => trim(($formData['selected_date'] ?? '') . ' ' . ($formData['selected_time'] ?? '')),
               ]
            ];

            break;
            
         // Калькуляторы
         case 'go-form':
            $mail->addAddress('a.gorbatyuk@sddbk.ru', '');
            $mail->Subject = 'Заявка из формы Страхование гражданской ответственности (ГО) юридических лиц';
            $module = 'call';

            $param = [
               'oper' => 'add',
               'user' => $config['user'],
               'from' => $config['from'],
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',               
               'mess' => "Все данные с сайта\n" .
                  "Вид гражданской ответственности: " . ( $formData['go-object-type'] ?? '') . "\n" .
                  "Сумма: " . ( $formData['object-price'] ?? '0' ) . "\n" .
                  "Город: " . ( $formData['city'] ?? '' ) . "\n".
                  "ИНН: " . ( $formData['inn'] ?? '') . "\n"
            ];

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы Страхование гражданской ответственности (ГО) юридических лиц",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744632756" => 5399, //ГО Юридические лица
                  "UF_CRM_1751622893" => 415, //ГО для юрлиц
                  "UF_CRM_1744814721142" => $config['landing_href'],
                  "UF_CRM_1748342798407" => $formData['city'] ?? '',
                  "UF_CRM_1771395881625" => $formData['city'] ?? '',
                  "UF_CRM_1748342715974" => $formData['inn'] ?? '',
                  "UF_CRM_1744632437" =>	$formData['object-price'] ?? 0 ,


                  "COMMENTS" => "Все данные с сайта\n" .
                     "Вид гражданской ответственности: " . ( $formData['go-object-type'] ?? '') . "\n" .
                     "Сумма: " . ( $formData['object-price'] ?? '0' ) . "\n" .
                     "Регион страхования: " . ( $formData['city'] ?? '' ) . "\n".
                     "ИНН: " . ( $formData['inn'] ?? '') . "\n"
               ]
            ];

            break;
         case 'property-yurlic-form':
            $mail->addAddress('a.gorbatyuk@sddbk.ru', '');
            $mail->Subject = 'Заявка из формы Страхование имущества юридических лиц';
            $module = 'call';

            $param = [
               'oper' => 'add',
               'user' => $config['user'],
               'from' => $config['from'],
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',               
               'mess' => "Все данные с сайта\n" .
                  "Вид имущества: " . ( $formData['property-object-type'] ?? '') . "\n" .
                  "Сумма: " . ( $formData['object-price'] ?? '0' ) . "\n" .
                  "Город: " . ( $formData['city'] ?? '' ) . "\n".
                  "ИНН: " . ( $formData['inn'] ?? '') . "\n"
            ];

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы Страхование имущества юридических лиц",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1751622893" => 413, //Имущество
                  "UF_CRM_1744632756" => 5400, //Имущество
                  "UF_CRM_1744814721142" => $config['landing_href'],
                  "UF_CRM_1748342798407" => $formData['city'] ?? '',
                  "UF_CRM_1771395881625" => $formData['city'] ?? '',
                  "UF_CRM_1748342715974" => $formData['inn'] ?? '',
                  "UF_CRM_1744632437" =>	$formData['object-price'] ?? 0 ,

                  "COMMENTS" => "Все данные с сайта\n" .
                     "Вид имущества: " . ( $formData['property-object-type'] ?? '') . "\n" .
                     "Сумма: " . ( $formData['object-price'] ?? '0' ) . "\n" .
                     "Регион страхования: " . ( $formData['city'] ?? '' ) . "\n".
                     "ИНН: " . ( $formData['inn'] ?? '') . "\n"
               ]
            ];

            break;
         case 'casco-form':
            $mail->Subject = 'Заявка из формы КАСКО';
            $module = 'kasko';

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',
               'risk' => 'Не выбрано',
               'mark' => $formData['car-brand'] ?? '',
               'model' => $formData['car-model'] ?? '',
               'year' => $formData['car-year'] ?? '',
               'cost' => (int) (preg_replace('/\D/', '', str_replace(' ', '', $formData['object-price'] ?? '0')) ?: 0),
               'power' => $formData['car-engine-power'] ?? '',
               'owner_type' => $formData['forma-sobstvennosti'] ?? '',
               'credit' => $formData['avtomobil-v-kredit'] === 'Да' ? 1 : 0,
               'bank' => $formData['bank-name'] ?? 'Сбербанк',
               'num_drivers' => $formData['drivers'] ?? '',
               'param_drivers' => !empty($drivers) ? implode(';', $drivers) : implode(';', [$formData['driver-age'] ?? '', $formData['driver-experience'] ?? '']),
               'PUS' => '',
               'city' => $formData['mesto-reg-sobst'] ?? '',
               'oper' => 'add',
            ];

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы КАСКО",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744632756" => 921, //Транспортное средство
                  "UF_CRM_1751622893" => 411, //КАСКО
                  "UF_CRM_1744814721142" => $config['landing_href'],
                  "UF_CRM_1744632384"	=> $formData['car-brand'] . " " . $formData['car-model'],
                  "UF_CRM_1747123131" =>	$formData['car-year'] ?? '',
                  "UF_CRM_1744632437" =>	$formData['object-price'] ,
                  "UF_CRM_1744632491" =>	$formData['car-engine-power'] ?? '0',
                  "UF_CRM_1744807025790" => $formData['bank-name'] ?? 'Нет',
                  "UF_CRM_1744646586" => $driversBitrix,
                  "UF_CRM_1748342798407" => $formData['mesto-reg-sobst'],
                  "UF_CRM_1771395881625" => $formData['mesto-reg-sobst'] ?? '',

                  "COMMENTS" => "Все данные с сайта\n Место регистрации собственника: ". $formData['mesto-reg-sobst'] ."",
               ]
            ];

            break;
         case 'casco-yurlic-form':
            $mail->Subject = 'Заявка из формы КАСКО для юридических лиц';
            $module = 'kasko';

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',
               'risk' => 'Не выбрано',
               'mark' => $formData['car-brand'] ?? '',
               'model' => $formData['car-model'] ?? '',
               'year' => $formData['car-year'] ?? '',
               'cost' => (int) (preg_replace('/\D/', '', str_replace(' ', '', $formData['object-price'] ?? '0')) ?: 0),
               'power' => $formData['car-engine-power'] ?? '',
               'owner_type' => $formData['forma-sobstvennosti'] ?? 'Юридическое лицо',
               'credit' => $formData['avtomobil-v-kredit'] === 'Да' ? 1 : 0,
               'bank' => $formData['bank-name'] ?? 'Сбербанк',
               'PUS' => '',
               'city' => $formData['mesto-reg-sobst'] ?? '',
               'mess' => "Дополнительные данные с сайта\n" .
                     "ИНН организации: " . ($formData['inn'] ?? '') . "\n",
               'oper' => 'add',
            ];

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы КАСКО для для юридических лиц",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744632756" => 921, //Транспортное средство
                  "UF_CRM_1751622893" => 411, //КАСКО
                  "UF_CRM_1744814721142" => $config['landing_href'],
                  "UF_CRM_1744632384"	=> $formData['car-brand'] . " " . $formData['car-model'],
                  "UF_CRM_1747123131" =>	$formData['car-year'] ?? '',
                  "UF_CRM_1744632437" =>	$formData['object-price'] ,
                  "UF_CRM_1744632491" =>	$formData['car-engine-power'] ?? '0',
                  "UF_CRM_1744807025790" => $formData['avtomobil-v-kredit'] === 'Да' ? $formData['bank-name'] : 'Нет',
                  "UF_CRM_1748342798407" => $formData['mesto-reg-sobst'],
                  "UF_CRM_1771395881625" => $formData['mesto-reg-sobst'] ?? '',
                  "UF_CRM_1748342715974" => $formData['inn'] ?? '',

                  "COMMENTS" => "Все данные с сайта\n Место регистрации собственника: ". $formData['mesto-reg-sobst'] ."",
               ]
            ];

            break;
         case 'osago-form':
            $mail->Subject = 'Заявка из формы ОСАГО';
            $module = 'osago';

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',
               'city' => $formData['mesto-reg-sobst'] ?? '',
               'old_staj' => implode(';', $osagoDrivers ?? []),
               'prolongaciya' => 1,
               'type_ts' => 0,
               'year' => (int) ($formData['car-year'] ?? 0),
               'mess' => "Марка: " . ($formData['car-brand'] ?? '') . ", модель: " . ($formData['car-model'] ?? ''),
               'owner_type' => $formData['forma-собstvennosti'] ?? '',
               'power_ts' => (int) (preg_replace('/\D/', '', str_replace(' ', '', $formData['car-engine-power'] ?? '0')) ?: 0),
               'oper' => 'add',
            ];

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы ОСАГО",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744632756" => 921, //Транспортное средство
                  "UF_CRM_1751622893" => 402, //ОСАГО
                  "UF_CRM_1744814721142" => $config['landing_href'],
                  "UF_CRM_1744632384"	=> $formData['car-brand'] . " " . $formData['car-model'],
                  "UF_CRM_1747123131" =>	$formData['car-year'] ?? '',
                  "UF_CRM_1744632437" =>	$formData['object-price'] ,
                  "UF_CRM_1744632491" =>	$formData['car-engine-power'] ?? '0',
                  "UF_CRM_1744807025790" => $formData['bank-name'] ?? 'Нет',
                  "UF_CRM_1744646586" => $driversBitrix,
                  "UF_CRM_1748342798407" => $formData['mesto-reg-sobst'],
                  "UF_CRM_1771395881625" => $formData['mesto-reg-sobst'] ?? '',


                  "COMMENTS" => "Все данные с сайта\n Место регистрации собственника: ". $formData['mesto-reg-sobst'] ."",
               ]
            ];

            break;
         case 'ipoteka-form':
            $mail->Subject = 'Заявка из формы Ипотечного страхования';
            $module = 'mortgage';

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',
               'age' => $formData['age'] ?? 0,
               'sex' => $formData['gender'] ?? 0,
               'insurance_object' => isset($formData['ipoteka-check-group']['insurance_object']) ? 1 : 0,
               'insurance_object_f' => isset($formData['ipoteka-check-group-child']['insurance_object_f']) ? 1 : 0,
               'insurance_object_h' => isset($formData['ipoteka-check-group-child']['insurance_object_h']) ? 1 : 0,
               'insurance_object_o' => isset($formData['ipoteka-check-group-child']['insurance_object_o']) ? 1 : 0,
               'life_health' => isset($formData['ipoteka-check-group']['life_health']) ? 1 : 0,
               'title' => isset($formData['ipoteka-check-group']['title']) ? 1 : 0,
               'bank' => $formData['bank-name'] ?? '',
               'price' => (int) preg_replace('/\D/', '', $formData['summa-kredita'] ?? '0'), // Сумма кредита, по умолчанию 0
               'mess' => "Город: " . $formData['city'] . "\n",
               'oper' => 'add',
            ];

            $insuranceObjects = [
               "1520" => "insurance_object_f",
               "1521" => "insurance_object_h",
               "1522" => "insurance_object_o"
            ];

            $insuranceObjectsBitrix = [];
            foreach($formData['ipoteka-check-group-child'] as $key => $val){
               $insuranceObjectsBitrix[] = array_search($key, $insuranceObjects);
            }

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы Ипотечного страхования",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744632756" => 894, //Ипотека
                  "UF_CRM_1751622893" => 417, //Ипотека 
                  "UF_CRM_1744814721142" => $config['landing_href'],
                  "HONORIFIC" => $formData['gender'] == "Мужской" ? "HNR_RU_1" : "HNR_RU_2",
                  "UF_CRM_1743415054" => (int) preg_replace('/\D/', '', $formData['summa-kredita'] ?? '0'),
                  "UF_CRM_1744024353" => $formData['bank-name'] ?? '', 
                  "UF_CRM_1750064383" => $formData['age'] ?? 0,
                  "UF_CRM_1748342798407" => $formData['city'] ?? '',
                  "UF_CRM_1771395881625" => $formData['mesto-reg-sobst'] ?? '',
                  "UF_CRM_1750064522" => isset($formData['ipoteka-check-group']['life_health']) ? 'Y' : 'N',
                  "UF_CRM_1750064550" => isset($formData['ipoteka-check-group']['title']) ? 'Y' : 'N',
                  "UF_CRM_1750064574" => isset($formData['ipoteka-check-group']['insurance_object']) ? 'Y' : 'N',
                  "UF_CRM_1750064732" => isset($formData['ipoteka-check-group']['insurance_object']) ? $insuranceObjectsBitrix : [],
                  "UF_CRM_1771396547761" => isset($formData['ipoteka-check-group-child']['insurance_object_o']) ? "Y" : "N",          
                  
                  "COMMENTS" => "Все данные с сайта\n" .
                     "Город: " . $formData['city'] . "\n".
                     "Полных лет: " . $formData['age'] . "\n" .                     
                     "Страхование жизни и здоровья: " . yesNo($formData['ipoteka-check-group-child'], 'life_health') . "\n" .
                     "Страхование титула: " . yesNo($formData['ipoteka-check-group-child'], 'title') . "\n" .
                     "Страхование имущества: " . yesNo($formData['ipoteka-check-group'], 'insurance_object') . "\n" .
                     "ТИП ИМУЩЕСТВА" . "\n" .
                     "Квартира: " . yesNo($formData['ipoteka-check-group-child'], 'insurance_object_f') . "\n" .
                     "Дом: " . yesNo($formData['ipoteka-check-group-child'], 'insurance_object_h') . "\n" .
                     "Нежилое помещение: " . yesNo($formData['ipoteka-check-group-child'], 'insurance_object_o') . "\n"
               ]
            ];

            break;
         case 'dms-fizlic-form':
            $mail->Subject = 'Заявка из формы ДМС для физических лиц';
            $module = 'life';

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',
               'sex' => $formData['gender'] ?? 0,
               'more_info' => "Город: " . $formData['mesto-reg-sobst'] . "\n".
                  "Дополнительные услуги к ДМС: " . ( isset( $formData['additional-dms-services'] ) ? "\n" . implode( ",\n", $formData['additional-dms-services'] ) : 'Нет' ) . "\n" .
                  "Клиники: " . ( $formData['dms-additional-fld'] ?? 'Нет' ) . "\n",
               'oper' => 'add',
            ];

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы ДМС для физических лиц",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744814721142" => $config['landing_href'],
                  "UF_CRM_1744632756" => 1523, //Медицина
                  "UF_CRM_1751622893" => 414, //ДМС
                  "HONORIFIC" => $formData['gender'] == "Мужской" ? "HNR_RU_1" : "HNR_RU_2",
                  "UF_CRM_1748342798407" => $formData['mesto-reg-sobst'],
                  "UF_CRM_1750065830" => isset( $formData['additional-dms-services'] ) ? "\n" . implode( ",\n", $formData['additional-dms-services'] ) : 'Нет',
                  "UF_CRM_1750065862" => $formData['dms-additional-fld'] ?? 'Нет',

                  "COMMENTS" => "Все данные с сайта\n" .
                     "Город: " . $formData['mesto-reg-sobst'] . "\n".
                     "Дополнительные услуги к ДМС: " . ( isset( $formData['additional-dms-services'] ) ? "\n" . implode( ",\n", $formData['additional-dms-services'] ) : 'Нет' ) . "\n" .
                     "Клиники: " . ( $formData['dms-additional-fld'] ?? 'Нет' ) . "\n"
               ]
            ];

            break;
         case 'dms-yurlic-form':
            $mail->addAddress('a.gorbatyuk@sddbk.ru', '');
            $mail->Subject = 'Заявка из формы ДМС для юридических лиц';
            $module = 'urpolis';

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',
               'employees_count' => $formData['employee-quantity'] ?? '',
               'more_info' => "Город: " . $formData['mesto-reg-sobst'] . "\n".
                  "Дополнительные услуги к ДМС: " . ( isset( $formData['additional-dms-services'] ) ? "\n" . implode( ",\n", $formData['additional-dms-services'] ) : 'Нет' ) . "\n" .
                  "Клиники: " . ( $formData['dms-additional-fld'] ?? 'Нет' ) . "\n" .
                  "ИНН: " . ( $formData['inn'] ?? '') . "\n",
               'oper' => 'add',
            ];

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы ДМС для юридических лиц",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744814721142" => $config['landing_href'],
                  "UF_CRM_1744632756" => 1523, //Медицина
                  "UF_CRM_1751622893" => 414, //ДМС
                  "UF_CRM_1748342798407" => $formData['city'] ?? '',
                  "UF_CRM_1750065472" => $formData['employee-quantity'] ?? 0,
                  "UF_CRM_1750065830" => isset( $formData['additional-dms-services'] ) ? "\n" . implode( ",\n", $formData['additional-dms-services'] ) : 'Нет',
                  "UF_CRM_1750065862" => $formData['dms-additional-fld'] ?? 'Нет',
                  "UF_CRM_1748342715974" => $formData['inn'] ?? '',
                  
                  "COMMENTS" => "Все данные с сайта\n" .
                     "Город: " . $formData['mesto-reg-sobst'] . "\n".
                     "Количество сотрудников: " . ( $formData['employee-quantity'] ?? 0 ) . "\n" .
                     "Дополнительные услуги к ДМС: " . ( isset( $formData['additional-dms-services'] ) ? "\n" . implode( ",\n", $formData['additional-dms-services'] ) : 'Нет' ) . "\n" .
                     "Клиники: " . ( $formData['dms-additional-fld'] ?? 'Нет' ) . "\n" .
                     "ИНН: " . ( $formData['inn'] ?? '') . "\n"
               ]
            ];

            break;
         case 'dms-nsl-form':
            $mail->Subject = 'Заявка из формы Несчастный случай';
            $module = 'accident';

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',
               'age' => $formData['age'] ?? 0,
               'in_sport' => $formData['ns-sport'] ?? '',
               'in_sport_level' => $formData['sport-level'] ?? '',
               'in_sport_kind' => $formData['ns-additional-fld'] ?? '',
               'more_info' => $formData['insurance-period'] . ' ' . $formData['insurance-amount'] ?? '',
               'mess' => "Город: " . $formData['city'] . "\n",
               'oper' => 'add',
            ];

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы Несчастный случай",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744814721142" => $config['landing_href'],
                  "UF_CRM_1744632756" => 1523, //Медицина
                  "UF_CRM_1751622893" => 406, //Несчастный случай
                  "UF_CRM_1748342798407" => $formData['city'] ?? '',
                  "UF_CRM_1750408226422" => $formData['ns-sport'] ?? 'Нет',
                  "UF_CRM_1771397355609" => $formData['ns-additional-fld'] ?? '-',
                  "UF_CRM_1771397220193" => $formData['age'] ?? 0,
                  "UF_CRM_1750064383" => $formData['age'] ?? 0,
                  "UF_CRM_1750408226422" => ($formData['ns-sport'] ?? 'Нет') . ", " . ( $formData['sport-level'] ?? '-' ) . ", " . ( $formData['ns-additional-fld'] ?? '-' ),
                  "UF_CRM_1750408336845" => $formData['insurance-period'] ?? 0,
                  "UF_CRM_1750408424570" => $formData['insurance-amount'] ?? 0,
                                 
                  "COMMENTS" => "Все данные с сайта\n" .
                     "Город: " . $formData['city'] . "\n".
                     "Возраст: " . ( $formData['age'] ?? 0 ) . "\n" .
                     "Занятие спортом: " . ($formData['ns-sport'] ?? 'Нет') . "\n" .
                     "Уровень занятия спортом: " . ($formData['sport-level'] ?? '-') . "\n" .
                     "Вид спорта: " . ( $formData['ns-additional-fld'] ?? '-' ) . "\n" .
                     "Срок страхования в днях: " . ( $formData['insurance-period'] ?? 0 ) . "\n" .
                     "Страховая сумма: " . ( $formData['insurance-amount'] ?? 0 ) . "\n"
               ]
            ];

            break;
         case 'kv-form':
            $mail->Subject = 'Заявка из формы Страхование квартиры';
            $module = 'flat';

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',
               'owner_type' => $formData['forma-собstvennosti'] ?? '',
               'existDisasters' => isset($formData['risks']['existDisasters']) ? 1 : 0,
               'existsFire' => isset($formData['risks']['existsFire']) ? 1 : 0,
               'existRobbery' => isset($formData['risks']['existRobbery']) ? 1 : 0,
               'existIllegalActs' => isset($formData['risks']['existIllegalActs']) ? 1 : 0,
               'existInundation' => isset($formData['risks']['existInundation']) ? 1 : 0,
               'existVehicles' => isset($formData['risks']['existVehicles']) ? 1 : 0,
               'existsTerrorism' => isset($formData['risks']['existsTerrorism']) ? 1 : 0,
               'iSumFlat' => ($formData['insurance-objects']['iSumFlat'] ?? '') . ($formData['obj-insurance-amount']['iSumFlat'] ?? ''),
               'iSumDecoration' => ($formData['insurance-objects']['iSumDecoration'] ?? '') . ($formData['obj-insurance-amount']['iSumDecoration'] ?? ''),
               'iSumEquipment' => ($formData['insurance-objects']['iSumEquipment'] ?? '') . ($formData['obj-insurance-amount']['iSumEquipment'] ?? ''),
               'iSumFurniture' => ($formData['insurance-objects']['iSumFurniture'] ?? '') . ($formData['obj-insurance-amount']['iSumFurniture'] ?? ''),
               'mess' => "Город: " . $formData['city'] . "\n",
               'oper' => 'add',
            ];

            $riskPackets = [
               "1561" => "existsFire",
               "1562" => "existDisasters",
               "1563" => "existRobbery",
               "1564" => "existIllegalActs",
               "1565" => "existInundation",
               "1566" => "existVehicles",
               "1567" => "existsTerrorism"
            ];

            $amountType = [
               "iSumFlat" => "Конструкция квартиры",
               "iSumDecoration" => "Отделка",
               "iSumEquipment" => "Техническое оборудование",
               "iSumFurniture" => "Движимое имущество"
            ];

            $risks = [];
            foreach($formData['risks'] as $key => $val){
               $risks[] = array_search( trim(  $key  ), $riskPackets );
            }

            $insurancesBitrix = [];
            foreach($formData['insurance-objects'] as $key => $val){
               $amountTypeKey = array_search( trim($val), $amountType );
               if( $amountTypeKey ) {
                  $insuranceAmount = $formData['obj-insurance-amount'][$amountTypeKey] ?? 0;
                  $isSet = "Да";

                  $insuranceBitrix = "{$val}: {$isSet} {$insuranceAmount}";
                  $insurancesBitrix[] = $insuranceBitrix;
               }
            }

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы Страхование квартиры",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744632756" => 5400, //Недвижимость
                  "UF_CRM_1751622893" => 413, //Имущество
                  "UF_CRM_1744814721142" => $config['landing_href'],
                  "UF_CRM_1748342798407" => $formData['city'] ?? '',
                  "UF_CRM_1750408668" => $risks,
                  "UF_CRM_1750066952" => $insurancesBitrix,
                                 
                  "COMMENTS" => "Все данные с сайта\n" .
                     "Город: " . $formData['city'] . "\n".
                     "РИСКИ " . "\n" .
                     "Пожар, взрыв газа: " . yesNo($formData['risks'], 'existsFire') . "\n" .
                     "Стихийные бедствия: "  . yesNo($formData['risks'], 'existDisasters') . "\n" .
                     "Кража со взломом, грабеж: " . yesNo($formData['risks'], 'existRobbery') . "\n" .
                     "Противоправные действия третьих лиц: " . yesNo($formData['risks'], 'existIllegalActs') . "\n" .
                     "Залив, повреждение водой: " . yesNo($formData['risks'], 'existInundation') . "\n" .
                     "Падение деревьев, летательных аппаратов, наезд транспортных средств: " . yesNo($formData['risks'], 'existVehicles') . "\n" .
                     "Терроризм, диверсия: " . yesNo($formData['risks'], 'existsTerrorism') . "\n \n" .
                     "ОБЪЕКТЫ СТРАХОВАНИЯ\n".
                     "Конструкция квартиры: " . yesNo($formData['insurance-objects'], 'iSumFlat') . " " . ($formData['obj-insurance-amount']['iSumFlat'] ?? '') . "\n" .
                     "Отделка: " . yesNo($formData['insurance-objects'], 'iSumDecoration') . " " .($formData['obj-insurance-amount']['iSumDecoration'] ?? '') . "\n" .
                     "Техническое оборудование: " . yesNo($formData['insurance-objects'], 'iSumEquipment') . " " . ($formData['obj-insurance-amount']['iSumEquipment'] ?? '') . "\n" .
                     "Движимое имущество: " . yesNo($formData['insurance-objects'], 'iSumFurniture')  . " " . ($formData['obj-insurance-amount']['iSumFurniture'] ?? '') . "\n"
               ]
            ];

            break;
         case 'dom-form':
            $mail->Subject = 'Заявка из формы Страхование дома';
            $module = 'homes';

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',
               'owner_type' => $formData['forma-собstvennosti'] ?? '',
               'risk' => $formData['risk-pakets'] ?? '',
               'iSumHouse' => (int) preg_replace('/\D/', '', $formData['obj-insurance-amount']['iSumHouse'] ?? '0'),
               'iSumHouseholdBuilding' => (int) preg_replace('/\D/', '', $formData['obj-insurance-amount']['iSumHouseholdBuilding'] ?? '0'),
               'iSumFurniture' => (int) preg_replace('/\D/', '', $formData['obj-insurance-amount']['iSumFurniture'] ?? '0'),

               'existsStoneWall' => isset($formData['obj-features']['existsStoneWall']) ? 1 : 0, // Каменное/кирпичное строение
               'existsFireSource' => isset($formData['obj-features']['existsFireSource']) ? 1 : 0, // Источник открытого огня: печь, камин
               'existInProgress' => isset($formData['obj-features']['existInProgress']) ? 1 : 0, // Незавершенное строительство
               'existsAbsent40' => isset($formData['obj-features']['existsAbsent40']) ? 1 : 0, // Временное проживание
               'existRental' => isset($formData['obj-features']['existRental']) ? 1 : 0, // Сдача в аренду
               'existsSecurity' => isset($formData['obj-features']['existsSecurity']) ? 1 : 0, // Охрана строения (с несением ответственности охраной)
               'existNeighboringBuildings' => isset($formData['obj-features']['existNeighboringBuildings']) ? 1 : 0, // Примыкание соседних строений или части здания
               'existBarsOn' => isset($formData['obj-features']['existBarsOn']) ? 1 : 0, // Отсутствуют металлические двери или решетки на окнах первого этажа
               'mess' => "Город: " . $formData['city'] . "\n",
               'oper' => 'add',
            ];

            $risk_packets = [
               "1529" => "Пакет 1",
               "1530" => "Пакет 2",
               "1531" => "Пакет 3"
            ];

            $amountType = [
               "iSumHouse" => "Основное строение",
               "iSumHouseholdBuilding" => "Хозстроение",
               "iSumFurniture" => "Движимое имущество"
            ];

            $houseFeaturesBitrix = [];
            $houseFeatures = [
               "existsStoneWall" => "1532",
               "existsFireSource" => "1533", 
               "existInProgress" => "1534", 
               "existsAbsent40" => "1535",
               "existRental" => "1536",
               "existsSecurity" => "1537", 
               "existNeighboringBuildings" => "1538", 
               "existBarsOn" => "1539"
            ];

            $insurancesBitrix = [];
            foreach($formData['insurance-objects'] as $key => $val){
               $amountTypeKey = array_search( trim($val), $amountType );
               if( $amountTypeKey ) {
                  $insuranceAmount = $formData['obj-insurance-amount'][$amountTypeKey] ?? 0;
                  $isSet = "Да";

                  $insuranceBitrix = "{$val}: {$isSet} {$insuranceAmount}";
                  $insurancesBitrix[] = $insuranceBitrix;
               }
            }          

            foreach($formData['obj-features'] as $key => $val){
               $houseFeaturesBitrix[] = $houseFeatures[$key];
            }

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы Страхование дома",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744632756" => 5400, //Недвижимость
                  "UF_CRM_1751622893" => 413, //Имущество
                  "UF_CRM_1744814721142" => $config['landing_href'],
                  "UF_CRM_1748342798407" => $formData['city'] ?? '',
                  "UF_CRM_1750066808" => array_search( trim( implode( $formData['risk-pakets'] ) ), $risk_packets ),
                  "UF_CRM_1750066952" => $insurancesBitrix,
                  "UF_CRM_1750067160" => $houseFeaturesBitrix,
                                 
                  "COMMENTS" => "Все данные с сайта\n" .
                     "Город: " . $formData['city'] . "\n".
                     "ПАКЕТ РИСКОВ: " . ( isset( $formData['risk-pakets'] ) ? implode( ",\n", $formData['risk-pakets'] ) : '' ) . "\n\n" .
                     "ОБЪЕКТЫ И СТРАХОВАЯ СУММА \n" .
                     "Основное строение: " . yesNo($formData['insurance-objects'], '0') . " " . ($formData['obj-insurance-amount']['iSumHouse'] ?? '0') . "\n" .
                     "Хозстроение: " . yesNo($formData['insurance-objects'], '1') . " " . ($formData['obj-insurance-amount']['iSumHouseholdBuilding'] ?? '0') . "\n" .
                     "Движимое имущество: " . yesNo($formData['insurance-objects'], '2') . " " . ($formData['obj-insurance-amount']['iSumFurniture'] ?? '0') . "\n\n" .
                     "ОСОБЕННОСТИ ДОМА \n".
                     "Каменное/кирпичное строение: " . yesNo($formData['obj-features'], 'existsStoneWall') . "\n \n" .
                     "Источник открытого огня: печь, камин: " . yesNo($formData['obj-features'], 'existsFireSource') . "\n" .
                     "Незавершенное строительство: " . yesNo($formData['obj-features'], 'existInProgress') . "\n" .
                     "Временное проживание: " . yesNo($formData['obj-features'], 'existsAbsent40') . "\n" .
                     "Сдача в аренду: " . yesNo($formData['obj-features'], 'existRental') . "\n" .
                     "Охрана строения (с несением ответственности охраной): " . yesNo($formData['obj-features'], 'existsSecurity') . "\n" .
                     "Примыкание соседних строений или части здания: " . yesNo($formData['obj-features'], 'existNeighboringBuildings') . "\n" .
                     "Отсутствуют металлические двери или решетки на окнах первого этажа: " . yesNo($formData['obj-features'], 'existBarsOn') . "\n"
               ]
            ];

            break;
         case 'zelenaya-carta-form':
            $mail->Subject = 'Заявка из формы Зеленая карта';
            $module = 'greenCard';

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',
               'owner_type' => $formData['forma-собstvennosti'] ?? '',
               'shipping' => $formData['get-policy-method'] ? 1 : 0,
               'ship_address' => $formData['delivery-address'] ?? '',
               'ship_date' => date('Y:m:d', strtotime($formData['delivery-date'])) ?? '', // Дата доставки (формат "Y:m:d")
               'ship_time' => date('H:i:s', strtotime($formData['delivery-time'])) ?? '', // Время доставки (формат "H:i:s")
               'mess' => "Город: " . $formData['city'] . "\n",
               'oper' => 'add',
            ];

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы Зеленая карта",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744814721142" => $config['landing_href'],                                    
                  "UF_CRM_1748342798407" => $formData['city'] ?? '',
                  "UF_CRM_1744632756" => 921, //Транспортное средство
                  "UF_CRM_1751622893" => 404, //Синяя карта
                  "COMMENTS" => "Все данные с сайта\n" .
                     "Город: " . $formData['city'] . "\n"
               ]
            ];

            break;
         case 'puteshestvie-form':
            $mail->Subject = 'Заявка из формы Выезжающих за рубеж';
            $module = 'abroad';
            $countries = [];
            if (isset($formData['ride-country'])) {
               array_push($countries, $formData['ride-country']);
            }

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',
               'owner_type' => $formData['forma-собstvennosti'] ?? '',
               'countries' => json_encode($countries, JSON_UNESCAPED_UNICODE), // Страны (json-string)
               'start_date' => isset($formData['p-date']) ? date('Y.m.d', strtotime($formData['p-date'])) : '', // Дата начала (формат "Y.m.d")
               'period' => isset($formData['p-days']) ? (int) $formData['p-days'] : 0, // Количество дней (int)
               'type_of_rest' => $formData['rest-type'] ?? '', // Вид отдыха (string)
               'price' => isset($formData['coverage']) ? (int) str_replace('$', '', $formData['coverage']) : 0, // Размер страховой защиты (int)
               'more_option' => isset($formData['p-additional-services']) ? json_encode($formData['p-additional-services']) : '', // Дополнительные опции (json-string)
               'mess' => "Город: " . $formData['city'] . "\n",
               'oper' => 'add',
            ];

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы Выезжающих за рубеж",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744814721142" => $config['landing_href'],
                  "UF_CRM_1744632756" => 1526, //Путешествия
                  "UF_CRM_1751622893" => 405, //Выезжающие за рубеж
                  "UF_CRM_1748342798407" => $formData['city'],
                  "UF_CRM_1750066209" => $formData['ride-country'],
                  "UF_CRM_1750066227" => $formData['rest-type'],
                  "UF_CRM_1750066180" => isset( $formData['p-date']) ? date( 'd.m.Y', strtotime($formData['p-date'] ) ) : '',
                  "UF_CRM_1750066333" => $formData['p-days'],
                  "UF_CRM_1750066355" => isset( $formData['coverage']) ? (int) str_replace('$', '', $formData['coverage']) : 0,
                  "UF_CRM_1750066387" => isset( $formData['p-additional-services'] ) ? implode( ",\n", $formData['p-additional-services'] ) : '',
                                    
                  "COMMENTS" => "Все данные с сайта\n" .
                     "Город: " . $formData['city'] . "\n".
                     "Страна поездки: " . $formData['ride-country'] . "\n" .
                     "Вид отдыха: " . $formData['rest-type'] . "\n" .                     
                     "Дата: " . ( isset($formData['p-date']) ? date( 'Y.m.d', strtotime($formData['p-date'] ) ) : '' ) . "\n" .
                     "Количество дней: " . $formData['p-days'] . "\n" .
                     "Размер страховой защиты: " . (isset( $formData['coverage']) ? (int) str_replace('$', '', $formData['coverage']) : 0) . "\n" .
                     "ДОПОЛНИТЕЛЬНЫЕ ОПЦИИ \n" . ( isset( $formData['p-additional-services'] ) ? implode( ",\n", $formData['p-additional-services'] ) : '' ) . "\n"                     
               ]
            ];

            break;
         case 'gruz-form':
            $mail->Subject = 'Заявка из формы Страхование груза';
            $module = 'call';
            $mail->addAddress('a.gorbatyuk@sddbk.ru', '');

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',
               'mess' => "Все данные с сайта\n" .
                  "Город: " . $formData['city'] . "\n".
                  "Вид транспорта: " . ( $formData['transport-type'] ?? '' ) . "\n" .
                  "Общая стоимость груза: " . ( $formData['total-cargo-price'] ?? '' ) . "\n" .                     
                  "Пункт отправления: " . ( $formData['departure-point'] ?? '' )  . "\n" .
                  "Пункт назначения: " . ( $formData['destination-point'] ?? '' ) . "\n" .
                  "ИНН организации: " . ($formData['inn'] ?? '') . "\n",
               'oper' => 'add',
            ];

            $transportType = [
               "1555" => "Автомобильный транспорт",
               "1556" => "Железнодорожный транспорт",
               "1557" => "Воздушный транспорт",
               "1558" => "Речной транспорт",
               "1559" => "Морской транспорт",
               "1560" => "Смешанные перевозки",
            ];

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы Страхование груза",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744814721142" => $config['landing_href'],
                  "UF_CRM_1744632756" => 1552, //Грузоперевозки
                  "UF_CRM_1751622893" => 409, //Грузы
                  "UF_CRM_1748342798407" => $formData['city'] ?? '',
                  "UF_CRM_1748342715974" => $formData['inn'] ?? '',
                  "UF_CRM_1750407407102" => $formData['total-cargo-price'] ?? 0,
                  "UF_CRM_1750407427288" => $formData['departure-point'] ?? '',
                  "UF_CRM_1750407436944" => $formData['destination-point'] ?? '',
                  "UF_CRM_1750407214" => array_search( trim(  $formData['transport-type']  ), $transportType ),
                                    
                  "COMMENTS" => "Все данные с сайта\n" .
                     "Город: " . $formData['city'] . "\n".
                     "Вид транспорта: " . ( $formData['transport-type'] ?? '' ) . "\n" .
                     "Общая стоимость груза: " . ( $formData['total-cargo-price'] ?? '' ) . "\n" .                     
                     "Пункт отправления: " . ( $formData['departure-point'] ?? '' )  . "\n" .
                     "Пункт назначения: " . ( $formData['destination-point'] ?? '' ) . "\n" .
                     "ИНН организации: " . ($formData['inn'] ?? '') . "\n" 
               ]
            ];

            break;
         case 'opo-form':
            $mail->addAddress('a.gorbatyuk@sddbk.ru', '');
            $mail->Subject = 'Заявка из формы ОПО';

            $module = 'call';

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',

               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',
               'mess' => "Все данные с сайта\n" .
                  "Вид опасного объекта: " . ( $formData['dangerous-object'] ?? '' ) . "\n" .
                  "Город нахождения опасного объекта: " . ( $formData['dangerous-object-location'] ?? '' ) . "\n" .
                  "ИНН организации: " . ($formData['inn'] ?? '') . "\n" ,
               'oper' => 'add',
            ];

            $dangerousObjectType = [
               "1545" => "АЗС (Автозаправочная станция жидкого моторного топлива)",
               "1546" => "ГТС",
               "1547" => "Лифт",
               "1548" => "Опасный производственный объект",
               "1549" => "Эскалатор",
               "1550" => "Подъемная платформа для инвалидов",
               "1551" => "Пассажирские конвейеры"
            ];

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы ОПО",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744814721142" => $config['landing_href'],
                  "UF_CRM_1744632756" => 5398, //ОПО
                  "UF_CRM_1751622893" => 416, //ОПО
                  "UF_CRM_1748342715974" => $formData['inn'] ?? '',
                  "UF_CRM_1748342798407" => $formData['dangerous-object-location'] ?? '',
                  "UF_CRM_1750406820" => array_search( trim(  $formData['dangerous-object']  ), $dangerousObjectType ),
                                    
                  "COMMENTS" => "Все данные с сайта\n" .
                     "Вид опасного объекта: " . ( $formData['dangerous-object'] ?? '' ) . "\n" .
                     "Город нахождения опасного объекта: " . ( $formData['dangerous-object-location'] ?? '' ) . "\n" .
                     "ИНН организации: " . ($formData['inn'] ?? '') . "\n" 
               ]
            ];

            break;
         case 'kn-form':
            $mail->addAddress('a.gorbatyuk@sddbk.ru', '');
            $mail->Subject = 'Заявка из формы Страхование коммерческой недвижимости';

            $module = 'call';

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',

               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',
               'mess' => "Все данные с сайта\n" .
                  "Город: " . $formData['city'] . "\n".
                  "Площадь помещения, м2: " . ( $formData['room-square'] ?? '' ) . "\n" .
                  "Этаж: " . ( $formData['kn-floor'] ?? '' ) . "\n" .
                  "Назначение объекта страхования: " . ( $formData['object-purpose'] ?? '' ) . "\n" .
                  "ИНН организации: " . ($formData['inn'] ?? '') . "\n",
               'oper' => 'add',
            ];

            $objectPurposeTypes = [
               "1540" => "Складное",
               "1541" => "Офисное",
               "1542" => "Производственное",
               "1543" => "Торговое/Общепит",
               "1544" => "Другое"
            ];

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы Страхование коммерческой недвижимости",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744814721142" => $config['landing_href'],
                  "UF_CRM_1744632756" => 893, //Недвижимость
                  "UF_CRM_1751622893" => 522, //Коммерческая недвижимость
                  "UF_CRM_1748342798407" => $formData['dangerous-object-location'] ?? '',
                  "UF_CRM_1748342715974" => $formData['inn'] ?? '',
                  "UF_CRM_1750406261062" => $formData['room-square'] ?? '',
                  "UF_CRM_1750406507" => $formData['kn-floor'] ?? '',
                  "UF_CRM_1750406573" => array_search( trim( $formData['object-purpose'] ), $objectPurposeTypes ),
                                    
                  "COMMENTS" => "Все данные с сайта\n" .
                     "Город: " . $formData['city'] . "\n".
                     "Площадь помещения, м2: " . ( $formData['room-square'] ?? '' ) . "\n" .
                     "Этаж: " . ( $formData['kn-floor'] ?? '' ) . "\n" .
                     "Назначение объекта страхования: " . ( $formData['object-purpose'] ?? '' ) . "\n" .
                     "ИНН организации: " . ($formData['inn'] ?? '') . "\n" 
               ]
            ];

            break;
         case 'osagop-texi-form':
            $mail->addAddress('a.gorbatyuk@sddbk.ru', '');
            $mail->Subject = 'Заявка из формы ОСГОП';

            $module = 'call';

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',

               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',
               'mess' => "Все данные с сайта\n" .
                     "Город: " . $formData['city'] . "\n".
                     "Страхователь: " . ( $formData['ost-forma-sobstvennosti'] ?? '' ) . "\n" .                     
                     "Гос. номер автомобиля: " . ( $formData['ost-avto-number'] ?? '' ) . "\n" .
                     "ИНН перевозчика: " . ($formData['ost-inn'] ?? '') . "\n" .
                     "Комментарий: " . ( $formData['ost-inn-message'] ?? '' ) . "\n",
               'oper' => 'add',
            ];

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы ОСГОП",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744632756" => 921, //Транспорт средство
                  "UF_CRM_1751622893" => 521, //ОСГОП
                  "UF_CRM_1744814721142" => $config['landing_href'],
                  "UF_CRM_1748342798407" => $formData['city'] ?? '',
                  "UF_CRM_1744632396" => $formData['ost-avto-number'] ?? '',
                  "UF_CRM_1748342715974" => $formData['ost-inn'] ?? '',

                  "COMMENTS" => "Все данные с сайта\n" .
                     "Город: " . $formData['city'] . "\n".
                     "Страхователь: " . ( $formData['ost-forma-sobstvennosti'] ?? '' ) . "\n" .                     
                     "Гос. номер автомобиля: " . ( $formData['ost-avto-number'] ?? '' ) . "\n" .
                     "ИНН перевозчика: " . ($formData['ost-inn'] ?? '') . "\n" .
                     "Комментарий: " . ( $formData['ost-inn-message'] ?? '' ) . "\n"
               ]
            ];

            break;
         case 'fast-casco-form':            
            $title = 'Заявка из формы Расчет КАСКО для физических лиц без заполнения форм';

            if( $formData['forma-sobstvennosti'] == 'Юридическое лицо' ){
               $title = 'Заявка из формы Расчет КАСКО для юридических лиц без заполнения форм';
               $mail->addAddress('a.gorbatyuk@sddbk.ru', '');
            }
            
            $mail->Subject = $title;
            $module = 'kasko';

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',
               'mess' => 'Пользователь прикрепил фото',
               'comment' => 'Пользователь прикрепил фото',
               'oper' => 'add',
            ];

            $bitrixParams = [
               "fields" => [
                  "TITLE" => $title,
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744632756" => 921, //Транспортное средство
                  "UF_CRM_1751622893" => 411, //КАСКО
                  "UF_CRM_1744814721142" => $config['landing_href'],
               
                  "COMMENTS" => "Пользователь прикрепил фото",
               ]
            ];

            break;
         case 'fast-osago-form':
            $mail->Subject = 'Заявка из формы Расчет ОСАГО без заполнения форм';

            $module = 'osago';

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'email' => $formData['email'] ?? '',
               'mess' => 'Пользователь прикрепил фото',
               'comment' => 'Пользователь прикрепил фото',
               'oper' => 'add',
            ];

            $bitrixParams = [
               "fields" => [
                  "TITLE" => "Заявка из формы Расчет ОСАГО без заполнения форм",
                  "LAST_NAME" => "",
                  "NAME" => $formData['name'] ?? '',
                  "SECOND_NAME" => "",
                  "SOURCE_ID" => $config['landing_source'],
                  "PHONE" => [[ 
                     "VALUE_TYPE" => "MOBILE", 
                     "VALUE" => $formData['phone'] ?? ''
                  ]],
                  "EMAIL" => [[
                     "VALUE" => $formData['email'] ?? ''
                  ]],
                  "UF_CRM_1744632756" => 921, //Транспортное средство
                  "UF_CRM_1751622893" => 402, //ОСАГО
                  "UF_CRM_1744814721142" => $config['landing_href'],
                  "COMMENTS" => "Пользователь прикрепил фото",
               ]
            ];

            break;

        case 'personal-offer-form':
            $mail->Subject = 'Заявка: Персональное предложение на новый автомобиль';
            $module = 'call';

            $agreementInfo = "Согласие на ОПД: " . ($formData['agreement'] ?? 'Нет') . "\n" .
                             "Дата и время согласия: " . ($formData['agreement_date'] ?? '') . "\n" .
                             "Страница отправки: " . ($formData['page_url'] ?? '');

            $param = [
                'user' => $config['user'],
                'from' => $config['from'],
                'from_landing' => $config['from_landing'] ?? '',
                'name' => $formData['name'] ?? '',
                'phone' => $formData['phone'] ?? '',
                'email' => $formData['email'] ?? '',
                'city' => $formData['city'] ?? '',
                'oper' => 'add',
                'mess' => $agreementInfo,
            ];

            $bitrixParams = [
                "fields" => [
                    "TITLE" => "Заявка: Персональное предложение на новый автомобиль",
                    "LAST_NAME" => "",
                    "NAME" => $formData['name'] ?? '',
                    "SECOND_NAME" => "",
                    "SOURCE_ID" => $config['landing_source'],
                    "PHONE" => [[
                        "VALUE_TYPE" => "MOBILE",
                        "VALUE" => $formData['phone'] ?? ''
                    ]],
                    "EMAIL" => [[
                        "VALUE" => $formData['email'] ?? ''
                    ]],
                    "UF_CRM_1744632756" => 921, // Транспортное средство
                    "UF_CRM_1744814721142" => $config['landing_href'],
                    "UF_CRM_1748342798407" => $formData['city'] ?? '',
                    "UF_CRM_1771395881625" => $formData['city'] ?? '',
                    "COMMENTS" => "Город: " . ($formData['city'] ?? ''),
                ]
            ];

            break;

         default:
            throw new Exception("Неизвестный тип формы: $formType");
      }

      

      $fieldLabels = [
         // Модалки
         'selected_date' => 'Выбранная дата',
         'selected_time' => 'Выбарнное время',

         // Калькуляторы:
         // КАСКО:
         'car-year' => 'Год производства автомобиля',
         'car-brand' => 'Марка автомобиля',
         'car-model' => 'Модель автомобиля',
         'object-price' => 'Стоимость',

         // ОСАГО
         'car-engine-power' => 'Мощность двигателя',

         // КАСКО
         'avtomobil-v-kredit' => 'Авто в кредит?',
         'bank-name' => 'Название банка',
         'mesto-reg-sobst' => 'Место регистрации собственника',
         'citi' => 'Город',
         'forma-sobstvennosti' => 'Форма собственности',
         'drivers' => 'Количество водителей',
         'driver-age' => 'Возраст, лет',
         'driver-experience' => 'Стаж, лет',
         'gender' => 'Пол',
         'married' => 'Состоит ли в браке?',
         'kids' => 'Дети',

         'driver-age-1' => 'Возраст 1-го водителя, лет',
         'driver-age-2' => 'Возраст 2-го водителя, лет',
         'driver-age-3' => 'Возраст 3-го водителя, лет',
         'driver-age-4' => 'Возраст 4-го водителя, лет',
         'driver-age-5' => 'Возраст 5-го водителя, лет',

         'driver-experience-1' => 'Опыт 1-го водителя, лет',
         'driver-experience-2' => 'Опыт 2-го водителя, лет',
         'driver-experience-3' => 'Опыт 3-го водителя, лет',
         'driver-experience-4' => 'Опыт 4-го водителя, лет',
         'driver-experience-5' => 'Опыт 5-го водителя, лет',
         'min-driver-age' => 'Минимальный возраст водителя',
         'min-driver-experience' => 'Минимальный опыт водителя',

         'driver-gender-1' => 'Пол 1-го водителя',
         'driver-gender-2' => 'Пол 2-го водителя',
         'driver-gender-3' => 'Пол 3-го водителя',
         'driver-gender-4' => 'Пол 4-го водителя',
         'driver-gender-5' => 'Пол 5-го водителя',

         'driver-married-1' => 'Состоит ли в браке 1-й водитель?',
         'driver-married-2' => 'Состоит ли в браке 2-й водитель?',
         'driver-married-3' => 'Состоит ли в браке 3-й водитель?',
         'driver-married-4' => 'Состоит ли в браке 4-й водитель?',
         'driver-married-5' => 'Состоит ли в браке 5-й водитель?',

         'kids-1' => 'Дети 1-го водителя',
         'kids-2' => 'Дети 2-го водителя',
         'kids-3' => 'Дети 3-го водителя',
         'kids-4' => 'Дети 4-го водителя',
         'kids-5' => 'Дети 5-го водителя',

         'insurance-policy-img' => 'Фотографии полиса',
         // Ипотека
         'ipoteka-check-group' => 'Выбранные варианты',
         'ipoteka-check-group-child' => 'Выбранный варианты имущества',
         'age' => 'Полных лет',
         'summa-kredita' => 'Остаток по кредиту',

         // ДМС для физических лиц
         'additional-dms-services' => 'Дополнительные услуги к ДМС',
         'dms-additional-fld' => 'Пожелания по интересующим клиникам',

         // ДМС для юридических лиц
         'employee-quantity' => 'Количество сотрудников',

         //  Несчастный случай
         'ns-sport' => 'Занятие спортом',
         'sport-level' => 'Уровень занятия спортом',
         'ns-additional-fld' => 'Вид спорта',
         'insurance-period' => 'Срок страхования в днях',
         'insurance-amount' => 'Сумма страхования',

         // Страхование квартиры
         'risks' => 'Риски',
         'insurance-objects' => 'Объекты страхования',
         'obj-insurance-amount' => 'Сумма страхования',

         // Страховане дома
         'obj-features' => 'Особенности дома',
         'risk-pakets' => 'Пакет рисков',

         // Синяя (Зеленая карта) Беларусь
         'get-policy-method' => 'Способ получения полиса',
         'delivery-address' => 'Адрес доставки',
         'delivery-date' => 'Дата доставки',
         'delivery-time' => 'Время доставки',

         // Выезжающим за рубеж
         'ride-country' => 'Страна поездки',
         'rest-type' => 'Вид отдыха',
         'p-additional-services' => 'Дополнительные опции',
         'p-date' => 'Дата',
         'p-days' => 'Количество дней',
         'coverage' => 'Размер страховой защиты',

         // Страхование груза
         'transport-type' => 'Вид транспорта',
         'total-cargo-price' => 'Общая стоимость груза',
         'departure-point' => 'Пункт отправления',
         'destination-point' => 'Пункт назначения',
         'inn' => 'ИНН',

         // Страхование ОПО
         'dangerous-object' => 'Вид опасного объекта',
         'dangerous-object-location' => 'Город нахождения опасного объекта',

         // Страхование коммерческой недвижимости
         'room-square' => 'Площадь помещения, м2',
         'kn-floor' => 'Этаж',
         'object-purpose' => 'Назначение объекта страхования',

         // Страхование ОСГОП
         'ost-forma-sobstvennosti' => 'Страхователь',
         'ost-avto-number' => 'Гос. номер автомобиля',
         'ost-inn' => 'ИНН перевозчика',
         'ost-inn-message' => 'Комментарий',

         // Страхование ГО Юрлиц
         'go-object-type' => 'Вид гражданской ответственности',

         // Страхование Имущества Юрлиц
         'property-object-type' => 'Вид имущества',

         // Общие элементы
         'name' => 'Имя',
         'phone' => 'Телефон',
         'email' => 'Почта',
         'message' => 'Комментарий',

         'city' => 'Город',

         'agreement' => 'Согласие на обработку ПД',
         'agreement_date' => 'Дата и время согласия',
         'page_url' => 'Страница заявки',
      ];

      $bodyContent = "";

      foreach ($formData as $key => $value) {
         if (!empty($value) && $key !== 'insurance-policy-img') {
            if (is_array($value)) {
               $label = $fieldLabels[$key] ?? $key;
               $bodyContent .= $label . ":\n";
               foreach ($value as $item) {
                  $bodyContent .= "   " . $item . "\n";
               }
            } else {
               $label = $fieldLabels[$key] ?? $key;
               $bodyContent .= "$label: $value\n";
            }
         }
      }

      if (!empty($utmValues)) {
        $bodyContent .= "\n--- UTM ---\n";
        foreach ($utmValues as $key => $val) {
            $bodyContent .= "$key: $val\n";
            $bitrixParams['fields'][strtoupper($key)] = $val;
        }
        }

      if (!empty($formData['insurance-policy-img']['name'])) {
         foreach ($formData['insurance-policy-img']['tmp_name'] as $index => $tmpName) {
            if ($formData['insurance-policy-img']['error'][$index] === UPLOAD_ERR_OK) {
               $mail->addAttachment($tmpName, $formData['insurance-policy-img']['name'][$index]);
            }
         }
      }

      $bitrixFiles = [];
      if (!empty($_FILES['insurance-policy-img']['name'])) {
         foreach ($_FILES['insurance-policy-img']['tmp_name'] as $index => $tmpName) {
             if ($_FILES['insurance-policy-img']['error'][$index] === UPLOAD_ERR_OK) {   
               $bitrixFiles[] = [
                  "fileData" => [    
                     $_FILES['insurance-policy-img']['name'][$index],
                     base64_encode(file_get_contents($tmpName))
                  ]
               ];  
            }
         }
      }
      
      $mail->Body = $bodyContent;
      $mail->isHTML(false);
      $mail->send();

        require_once $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';
        global $wpdb;

        session_start();

        $ip = $_SERVER['REMOTE_ADDR'];
        $table_name = $wpdb->prefix . "spam_protection";
        $time_limit = 300; // 5 минут
        $request_limit = 3;

        $wpdb->query("CREATE TABLE IF NOT EXISTS $table_name (
            id INT AUTO_INCREMENT PRIMARY KEY,
            ip VARCHAR(45),
            request_time INT
        )");

        $wpdb->query("DELETE FROM $table_name WHERE request_time < UNIX_TIMESTAMP() - $time_limit");

        $request_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE ip = '$ip'");

        if ($request_count >= $request_limit) {
            $remaining_time = $time_limit - (time() - $wpdb->get_var("SELECT MIN(request_time) FROM $table_name WHERE ip = '$ip'"));
            echo json_encode(['banned' => true, 'time_left' => $remaining_time]);
            exit;
        }

        $wpdb->insert($table_name, ['ip' => $ip, 'request_time' => time()]);

        echo json_encode(['success' => true]);
}
catch (Exception $e) {
    error_log("Ошибка при отправке письма: {$mail->ErrorInfo}");
    echo json_encode(['success' => false, 'error' => 'Ошибка отправки письма']);
}
}