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

   // Общие элементы
   'name' => $_POST['name'] ?? null,
   'phone' => $_POST['phone'] ?? null,
   'message' => $_POST['message'] ?? null,

   'agreement' => isset($_POST['agreement']) ? 'Да' : 'Нет',
   'agreement_date' => date('d.m.Y H:i:s'),
   'page_url' => $_POST['page_url'] ?? 'не указано',
];

$formType = $_POST['form_type'] ?? 'unknown-form';

sendMail($formData, $formType);

function sendMail($formData, $formType)
{
   $mail = new PHPMailer(true);

   try {

    header('Content-Type: application/json');

      $mail->isSMTP();
      $mail->Host = 'smtp.jino.ru';
      $mail->SMTPAuth = true;
      $mail->Username = '*******';
      $mail->Password = '*******';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      $mail->Port = 465;

      $mail->CharSet = 'UTF-8';
      $mail->setFrom('*******', "Новая заявка с сайта Сравним Онлайн");
    //   $mail->addAddress('r.serov@sddbk.ru', 'Руслану');
      $mail->addAddress('anushervon73419@gmail.com', 'Руслану');
    


      //   Водители КАСКО
      $drivers = [];
      for ($i = 1; $i <= 5; $i++) {
         $age = $formData["driver-age-$i"] ?? null;
         $experience = $formData["driver-experience-$i"] ?? null;
         $gender = $formData["driver-gender-$i"] ?? null;
         $married = $formData["driver-married-$i"] ?? null;
         $kids = $formData["kids-$i"] ?? null;

         if ($age || $experience || $gender || $married || $kids) {
            $driver = implode(':', [$gender, $age]) . ';' . implode(';', [$experience, $kids, $married]);
            $drivers[] = $driver;
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


    // Константы
    $config = [
        'user' => 26,
        'from' => 210,
        'from_landing' => 'Сравним Онлайн',
    ];

    

      switch ($formType) {
         // Форма обратной связи
         case 'default-callme-form':
            $mail->Subject = 'Заявка из формы обратной связи';
            $module = 'question';

            $agreementInfo = "Согласие на ОПД: " . ($formData['agreement'] ?? 'Нет') . "\n" .
                             "Дата и время согласия: " . ($formData['agreement_date'] ?? '') . "\n" .
                             "Страница отправки: " . ($formData['page_url'] ?? '');

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
            break;

         // Модалки
         case 'default-modal-form':
            $mail->Subject = 'Заявка из основной формы';
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
               'mess' => trim(($formData['selected_date'] ?? '') . ' ' . ($formData['selected_time'] ?? '')),
               'oper' => 'add',
            ];
            break;
            
         // Калькуляторы
         case 'casco-form':
            $mail->Subject = 'Заявка из формы КАСКО';
            $module = 'kasko';

            $agreementInfo = "Согласие на ОПД: " . ($formData['agreement'] ?? 'Нет') . "\n" .
                             "Дата и время согласия: " . ($formData['agreement_date'] ?? '') . "\n" .
                             "Страница отправки: " . ($formData['page_url'] ?? '');

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
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
            break;
         case 'osago-form':
            $mail->Subject = 'Заявка из формы ОСАГО';
            $module = 'osago';

            $agreementInfo = "Согласие на ОПД: " . ($formData['agreement'] ?? 'Нет') . "\n" .
                             "Дата и время согласия: " . ($formData['agreement_date'] ?? '') . "\n" .
                             "Страница отправки: " . ($formData['page_url'] ?? '');

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
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

            break;
         case 'ipoteka-form':
            $mail->Subject = 'Заявка из формы Ипотечного страхования';
            $module = 'mortgage';

            $agreementInfo = "Согласие на ОПД: " . ($formData['agreement'] ?? 'Нет') . "\n" .
                             "Дата и время согласия: " . ($formData['agreement_date'] ?? '') . "\n" .
                             "Страница отправки: " . ($formData['page_url'] ?? '');

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
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
               'oper' => 'add',
            ];

            break;
         case 'dms-fizlic-form':
            $mail->Subject = 'Заявка из формы ДМС для физических лиц';
            $module = 'life';

            $agreementInfo = "Согласие на ОПД: " . ($formData['agreement'] ?? 'Нет') . "\n" .
                             "Дата и время согласия: " . ($formData['agreement_date'] ?? '') . "\n" .
                             "Страница отправки: " . ($formData['page_url'] ?? '');

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'sex' => $formData['gender'] ?? 0,
               'more_info' => $formData['additional-dms-services'] ?? '',
               'oper' => 'add',
            ];

            break;
         case 'dms-yurlic-form':
            $mail->Subject = 'Заявка из формы ДМС для юридических лиц';
            $module = 'urpolis';
            $mail->addAddress('a.gorbatyuk@sddbk.ru', '');

            $agreementInfo = "Согласие на ОПД: " . ($formData['agreement'] ?? 'Нет') . "\n" .
                             "Дата и время согласия: " . ($formData['agreement_date'] ?? '') . "\n" .
                             "Страница отправки: " . ($formData['page_url'] ?? '');

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'employees_count' => $formData['employee-quantity'] ?? '',
               'more_info' => $formData['additional-dms-services'] ?? '',
               'oper' => 'add',
            ];
            break;
         case 'dms-nsl-form':
            $mail->Subject = 'Заявка из формы Несчастный случай';
            $module = 'accident';

            $agreementInfo = "Согласие на ОПД: " . ($formData['agreement'] ?? 'Нет') . "\n" .
                             "Дата и время согласия: " . ($formData['agreement_date'] ?? '') . "\n" .
                             "Страница отправки: " . ($formData['page_url'] ?? '');

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'age' => $formData['age'] ?? 0,
               'in_sport' => $formData['ns-sport'] ?? '',
               'in_sport_level' => $formData['sport-level'] ?? '',
               'in_sport_kind' => $formData['ns-additional-fld'] ?? '',
               'more_info' => $formData['insurance-period'] . ' ' . $formData['insurance-amount'] ?? '',
               'oper' => 'add',
            ];
            break;
         case 'kv-form':
            $mail->Subject = 'Заявка из формы Страхование квартиры';
            $module = 'flat';

            $agreementInfo = "Согласие на ОПД: " . ($formData['agreement'] ?? 'Нет') . "\n" .
                             "Дата и время согласия: " . ($formData['agreement_date'] ?? '') . "\n" .
                             "Страница отправки: " . ($formData['page_url'] ?? '');

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
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
               'oper' => 'add',
            ];

            break;
         case 'dom-form':
            $mail->Subject = 'Заявка из формы Страхование дома';
            $module = 'homes';

            $agreementInfo = "Согласие на ОПД: " . ($formData['agreement'] ?? 'Нет') . "\n" .
                             "Дата и время согласия: " . ($formData['agreement_date'] ?? '') . "\n" .
                             "Страница отправки: " . ($formData['page_url'] ?? '');

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
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

               'oper' => 'add',
            ];

            break;
         case 'zelenaya-carta-form':
            $mail->Subject = 'Заявка из формы Зеленая карта';
            $module = 'greenCard';

            $agreementInfo = "Согласие на ОПД: " . ($formData['agreement'] ?? 'Нет') . "\n" .
                             "Дата и время согласия: " . ($formData['agreement_date'] ?? '') . "\n" .
                             "Страница отправки: " . ($formData['page_url'] ?? '');

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'owner_type' => $formData['forma-собstvennosti'] ?? '',
               'shipping' => $formData['get-policy-method'] ? 1 : 0,
               'ship_address' => $formData['delivery-address'] ?? '',
               'ship_date' => date('Y:m:d', strtotime($formData['delivery-date'])) ?? '', // Дата доставки (формат "Y:m:d")
               'ship_time' => date('H:i:s', strtotime($formData['delivery-time'])) ?? '', // Время доставки (формат "H:i:s")

               'oper' => 'add',
            ];

            break;
         case 'puteshestvie-form':
            $mail->Subject = 'Заявка из формы Выезжающих за рубеж';
            $module = 'abroad';
            $countries = [];
            if (isset($formData['ride-country'])) {
               array_push($countries, $formData['ride-country']);
            }

            $agreementInfo = "Согласие на ОПД: " . ($formData['agreement'] ?? 'Нет') . "\n" .
                             "Дата и время согласия: " . ($formData['agreement_date'] ?? '') . "\n" .
                             "Страница отправки: " . ($formData['page_url'] ?? '');

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'owner_type' => $formData['forma-собstvennosti'] ?? '',
               'countries' => json_encode($countries, JSON_UNESCAPED_UNICODE), // Страны (json-string)
               'start_date' => isset($formData['p-date']) ? date('Y.m.d', strtotime($formData['p-date'])) : '', // Дата начала (формат "Y.m.d")
               'period' => isset($formData['p-days']) ? (int) $formData['p-days'] : 0, // Количество дней (int)
               'type_of_rest' => $formData['rest-type'] ?? '', // Вид отдыха (string)
               'price' => isset($formData['coverage']) ? (int) str_replace('$', '', $formData['coverage']) : 0, // Размер страховой защиты (int)
               'more_option' => isset($formData['p-additional-services']) ? json_encode($formData['p-additional-services']) : '', // Дополнительные опции (json-string)
               'oper' => 'add',
            ];

            break;
         case 'gruz-form':
            $mail->addAddress('a.gorbatyuk@sddbk.ru', '');
            $mail->Subject = 'Заявка из формы Страхование груза';
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
               'mess' => ($formData['transport-type'] ?? '') . ($formData['total-cargo-price'] ?? '') . ($formData['departure-point'] ?? '') . ($formData['destination-point'] ?? '') . ($formData['inn'] ?? ''),
               'oper' => 'add',
            ];
            break;
         case 'opo-form':
            $mail->Subject = 'Заявка из формы ОПО';
            $mail->addAddress('a.gorbatyuk@sddbk.ru', '');

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
               'mess' => ($formData['dangerous-object'] ?? '') . ($formData['dangerous-object-location'] ?? '') . ($formData['inn'] ?? ''),
               'oper' => 'add',
            ];

            break;
         case 'kn-form':
            $mail->Subject = 'Заявка из формы Страхование коммерческой недвижимости';
            $mail->addAddress('a.gorbatyuk@sddbk.ru', '');

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
               'mess' => ($formData['room-square'] ?? '') . ($formData['kn-floor'] ?? '') . ($formData['dangerous-object-location'] ?? '') . ($formData['inn'] ?? '') . ($formData['object-purpose'] ?? ''),
               'oper' => 'add',
            ];
            break;
         case 'osagop-texi-form':
            $mail->Subject = 'Заявка из формы ОСГОП';
            $mail->addAddress('a.gorbatyuk@sddbk.ru', '');

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
               'mess' => ($formData['ost-forma-sobstvennosti'] ?? '') . ($formData['ost-inn'] ?? '') . ($formData['ost-avto-number'] ?? '') . ($formData['ost-inn-message'] ?? ''),
               'oper' => 'add',
            ];
            break;
         case 'fast-casco-form':
            $mail->Subject = 'Заявка из формы Расчет КАСКО без заполнения форм';
            $module = 'kasko';

            $agreementInfo = "Согласие на ОПД: " . ($formData['agreement'] ?? 'Нет') . "\n" .
                             "Дата и время согласия: " . ($formData['agreement_date'] ?? '') . "\n" .
                             "Страница отправки: " . ($formData['page_url'] ?? '');

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'mess' => 'Пользователь прикрепил фото',
               'comment' => 'Пользователь прикрепил фото',
               'oper' => 'add',
            ];

            break;
         case 'fast-osago-form':
            $mail->Subject = 'Заявка из формы Расчет ОСАГО без заполнения форм';

            $module = 'osago';

            $agreementInfo = "Согласие на ОПД: " . ($formData['agreement'] ?? 'Нет') . "\n" .
                             "Дата и время согласия: " . ($formData['agreement_date'] ?? '') . "\n" .
                             "Страница отправки: " . ($formData['page_url'] ?? '');

            $agreementInfo = "Согласие на ОПД: " . ($formData['agreement'] ?? 'Нет') . "\n" .
                             "Дата и время согласия: " . ($formData['agreement_date'] ?? '') . "\n" .
                             "Страница отправки: " . ($formData['page_url'] ?? '');

            $param = [
               'user' => $config['user'],
               'from' => $config['from'],
               'from_landing' => $config['from_landing'] ?? '',
               'name' => $formData['name'] ?? '',
               'phone' => $formData['phone'] ?? '',
               'mess' => 'Пользователь прикрепил фото',
               'comment' => 'Пользователь прикрепил фото',
               'oper' => 'add',
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
         'city' => 'Город',
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

         // Общие элементы
         'name' => 'Имя',
         'phone' => 'Телефон',
         'message' => 'Комментарий',

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

      if (!empty($formData['insurance-policy-img']['name'])) {
         foreach ($formData['insurance-policy-img']['tmp_name'] as $index => $tmpName) {
            if ($formData['insurance-policy-img']['error'][$index] === UPLOAD_ERR_OK) {
               $mail->addAttachment($tmpName, $formData['insurance-policy-img']['name'][$index]);
            }
         }
      }

      $mail->Body = $bodyContent;
      $mail->isHTML(false);
      $mail->send();

      require_once $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';
      global $wpdb;
      
      if (session_status() === PHP_SESSION_NONE) {
          session_start();
      }
      
      $ip = $_SERVER['REMOTE_ADDR'];
      $table_name = $wpdb->prefix . "spam_protection";
      $time_limit = 300;
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

   } catch (Exception $e) {
      error_log("Ошибка при отправке письма: {$mail->ErrorInfo}");
      echo json_encode([
         'success' => false,
         'error' => $mail->ErrorInfo ?: $e->getMessage()
      ]);
   }
}