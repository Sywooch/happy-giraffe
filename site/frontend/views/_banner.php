<?php
    $banners = array(
        'http://www.happy-giraffe.ru/names/',
        'http://www.happy-giraffe.ru/cook/',
        'http://www.happy-giraffe.ru/babySex/',
        'http://www.happy-giraffe.ru/cook/spices/',
        'http://www.happy-giraffe.ru/contest/2/',
    );
    $n = rand(0, count($banners) - 1);
?>
<?//=CHtml::link(CHtml::image('/images/banners/' . $n . '.jpg'), $banners[$n])?>

<?php
//<!--/* OpenX Local Mode Tag v2.8.10 */-->

// The MAX_PATH below should point to the base of your OpenX installation
define('MAX_PATH', '/var/www/happy-giraffe.ru/openx');
if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
    if (!isset($phpAds_context)) {
        $phpAds_context = array();
    }
    // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
    $phpAds_raw = view_local('', 1, 0, 0, '_top', '', '0', $phpAds_context, '');
}
echo $phpAds_raw['html'];
?>