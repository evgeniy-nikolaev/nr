<h1>PARSING</h1>
<?

// Путь к access.log файлу
$logFilePath = '111111111.txt';

// Чтение файла
$logFile = file($logFilePath, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
echo 'Всего вызовов: ' . (count($logFile));echo ('<br>');echo ('<br>');
// Инициализация счетчиков
$ipCount = [];
$ipCount1 = [];
$botCount = [];
foreach ($logFile as $line) {
    $parts = explode(' ', $line);
    $ip = $parts[0];
    $responseCode = $parts[8];
//echo '<pre>';var_dump($parts);echo '</pre>';
    // Подсчет количества запросов по IP
    if (isset($ipCount[$ip])) {
        $ipCount[$ip]++;
    } else {
        $ipCount[$ip] = 1;
    }
    if (isset($ipCount1[$responseCode])) {
        $ipCount1[$responseCode]++;
    } else {
        $ipCount1[$responseCode] = 1;
    }

    // Подсчет количества запросов с определенными response code'ами
    if (isset($responseCodesCount[$responseCode])) {
        $responseCodesCount[$responseCode]++;
    }

    // Проверка на бота и подсчет количества запросов по User Agent'у
    for ($i = 10; $i <= 100; $i++) {
        $userAgent = isset($parts[$i]) ? $parts[$i] : '';
        if (preg_match('/(YandexRCA|YandexAccessibilityBot|YandexImages|2ip bot|AdsBot-Google-Mobile|keys-so-bot|Googlebot|AdsBot-Google|YandexRenderResourcesBot|YandexMetrika|YandexBot|bot|crawler|spider|SemrushBot|SolomonoBot|MJ12bot|Ezooms|AhrefsBot|DataForSeoBot|DotBot|Purebot|PetalBot|LinkpadBot|WebDataStats|Jooblebot|BackupLand|NetcraftSurveyAgent|netEstate|rogerbot|exabot|gigabot|sitebot|bingbot)/i', $userAgent)) {
            if (isset($botCount[$userAgent])) {
                $botCount[$userAgent]++;
            } else {
                $botCount[$userAgent] = 1;
            }
        }
    }
}

echo '<h1> Вывод информации </h1>';
echo "IP с количеством запросов:";echo '<br>';
arsort($ipCount);
foreach ($ipCount as $ip => $count) {
    echo $ip . ": " . $count;echo '<br>';
}
echo "responce с количеством запросов:";echo '<br>';
arsort($ipCount1);
foreach ($ipCount1 as $responseCode => $count) {
    echo $responseCode . ": " . $count;echo '<br>';
}

echo "Название бота с количеством запросов:";echo '<br>';
arsort($botCount);
foreach ($botCount as $bot => $count) {
    echo $bot . ": " . $count;echo '<br>';
}

?>