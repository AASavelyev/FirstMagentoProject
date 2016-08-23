<?php
/**
 * Oggetto Web extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Oggetto Shipping module to newer versions in the future.
 * If you wish to customize the Oggetto Shipping module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Oggetto
 * @package    Oggetto_Shipping
 * @copyright  Copyright (C) 2016 Oggetto Web ltd (http://oggettoweb.com/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Question collection model
 *
 * @category   Oggetto
 * @package    Oggetto_Shipping
 * @subpackage Model
 * @author     Alexander Savelyev <asavelyev@oggettoweb.com>
 */

try {
    $installer = $this;
    $installer->startSetup();


    $installer->getConnection()->insertMultiple(
        $installer->getTable('directory_country_region'),
        array(
            array('country_id' => 'RU', 'code' => 'RU-AD', 'default_name' => 'Республика Адыгея (Адыгея)'),
            array('country_id' => 'RU', 'code' => 'RU-BA', 'default_name' => 'Республика Башкортостан'),
            array('country_id' => 'RU', 'code' => 'RU-BU', 'default_name' => 'Республика Бурятия'),
            array('country_id' => 'RU', 'code' => 'RU-AL', 'default_name' => 'Республика Алтай'),
            array('country_id' => 'RU', 'code' => 'RU-DA', 'default_name' => 'Республика Дагестан'),
            array('country_id' => 'RU', 'code' => 'RU-IN', 'default_name' => 'Республика Ингушетия'),
            array('country_id' => 'RU', 'code' => 'RU-KB', 'default_name' => 'Кабардино-Балкарская Республика'),
            array('country_id' => 'RU', 'code' => 'RU-KL', 'default_name' => 'Республика Калмыкия'),
            array('country_id' => 'RU', 'code' => 'RU-KC', 'default_name' => 'Карачаево-Черкесская Республика'),
            array('country_id' => 'RU', 'code' => 'RU-KR', 'default_name' => 'Республика Карелия'),
            array('country_id' => 'RU', 'code' => 'RU-KO', 'default_name' => 'Республика Коми'),
            array('country_id' => 'RU', 'code' => 'RU-ME', 'default_name' => 'Республика Марий Эл'),
            array('country_id' => 'RU', 'code' => 'RU-MO', 'default_name' => 'Республика Мордовия'),
            array('country_id' => 'RU', 'code' => 'RU-SA', 'default_name' => 'Республика Саха (Якутия)'),
            array('country_id' => 'RU', 'code' => 'RU-SE', 'default_name' => 'Республика Северная Осетия - Алания'),
            array('country_id' => 'RU', 'code' => 'RU-TA', 'default_name' => 'Республика Татарстан (Татарстан)'),
            array('country_id' => 'RU', 'code' => 'RU-TY', 'default_name' => 'Республика Тыва'),
            array('country_id' => 'RU', 'code' => 'RU-UD', 'default_name' => 'Удмуртская Республика'),
            array('country_id' => 'RU', 'code' => 'RU-KK', 'default_name' => 'Республика Хакасия'),
            array('country_id' => 'RU', 'code' => 'RU-CE', 'default_name' => 'Чеченская Республика'),
            array('country_id' => 'RU', 'code' => 'RU-CU', 'default_name' => 'Чувашская Республика - Чувашия'),
            array('country_id' => 'RU', 'code' => 'RU-ALT', 'default_name' => 'Алтайский край'),
            array('country_id' => 'RU', 'code' => 'RU-KDA', 'default_name' => 'Краснодарский край'),
            array('country_id' => 'RU', 'code' => 'RU-KYA', 'default_name' => 'Красноярский край'),
            array('country_id' => 'RU', 'code' => 'RU-STA', 'default_name' => 'Ставропольский край'),
            array('country_id' => 'RU', 'code' => 'RU-KHA', 'default_name' => 'Хабаровский край'),
            array('country_id' => 'RU', 'code' => 'RU-AMU', 'default_name' => 'Амурская область'),
            array('country_id' => 'RU', 'code' => 'RU-ARK', 'default_name' => 'Архангельская область'),
            array('country_id' => 'RU', 'code' => 'RU-AST', 'default_name' => 'Астраханская область'),
            array('country_id' => 'RU', 'code' => 'RU-BEL', 'default_name' => 'Белгородская область'),
            array('country_id' => 'RU', 'code' => 'RU-BRY', 'default_name' => 'Брянская область'),
            array('country_id' => 'RU', 'code' => 'RU-VLA', 'default_name' => 'Владимирская область'),
            array('country_id' => 'RU', 'code' => 'RU-VGG', 'default_name' => 'Волгоградская область'),
            array('country_id' => 'RU', 'code' => 'RU-VLG', 'default_name' => 'Вологодская область'),
            array('country_id' => 'RU', 'code' => 'RU-VOR', 'default_name' => 'Воронежская область'),
            array('country_id' => 'RU', 'code' => 'RU-IVA', 'default_name' => 'Ивановская область'),
            array('country_id' => 'RU', 'code' => 'RU-IRK', 'default_name' => 'Иркутская область'),
            array('country_id' => 'RU', 'code' => 'RU-KGD', 'default_name' => 'Калининградская область'),
            array('country_id' => 'RU', 'code' => 'RU-KLU', 'default_name' => 'Калужская область'),
            array('country_id' => 'RU', 'code' => 'RU-KAM', 'default_name' => 'Камчатский край'),
            array('country_id' => 'RU', 'code' => 'RU-KEM', 'default_name' => 'Кемеровская область'),
            array('country_id' => 'RU', 'code' => 'RU-KIR', 'default_name' => 'Кировская область'),
            array('country_id' => 'RU', 'code' => 'RU-KOS', 'default_name' => 'Костромская область'),
            array('country_id' => 'RU', 'code' => 'RU-KGN', 'default_name' => 'Курганская область'),
            array('country_id' => 'RU', 'code' => 'RU-KRS', 'default_name' => 'Курская область'),
            array('country_id' => 'RU', 'code' => 'RU-LEN', 'default_name' => 'Ленинградская область'),
            array('country_id' => 'RU', 'code' => 'RU-LIP', 'default_name' => 'Липецкая область'),
            array('country_id' => 'RU', 'code' => 'RU-MAG', 'default_name' => 'Магаданская область'),
            array('country_id' => 'RU', 'code' => 'RU-MOS', 'default_name' => 'Московская область'),
            array('country_id' => 'RU', 'code' => 'RU-MUR', 'default_name' => 'Мурманская область'),
            array('country_id' => 'RU', 'code' => 'RU-NIZ', 'default_name' => 'Нижегородская область'),
            array('country_id' => 'RU', 'code' => 'RU-NGR', 'default_name' => 'Новгородская область'),
            array('country_id' => 'RU', 'code' => 'RU-NVS', 'default_name' => 'Новосибирская область'),
            array('country_id' => 'RU', 'code' => 'RU-OMS', 'default_name' => 'Омская область'),
            array('country_id' => 'RU', 'code' => 'RU-ORE', 'default_name' => 'Оренбургская область'),
            array('country_id' => 'RU', 'code' => 'RU-ORL', 'default_name' => 'Орловская область'),
            array('country_id' => 'RU', 'code' => 'RU-PNZ', 'default_name' => 'Пензенская область'),
            array('country_id' => 'RU', 'code' => 'RU-PER', 'default_name' => 'Пермский край'),
            array('country_id' => 'RU', 'code' => 'RU-PSK', 'default_name' => 'Псковская область'),
            array('country_id' => 'RU', 'code' => 'RU-ROS', 'default_name' => 'Ростовская область'),
            array('country_id' => 'RU', 'code' => 'RU-RYA', 'default_name' => 'Рязанская область'),
            array('country_id' => 'RU', 'code' => 'RU-SAM', 'default_name' => 'Самарская область'),
            array('country_id' => 'RU', 'code' => 'RU-SAR', 'default_name' => 'Саратовская область'),
            array('country_id' => 'RU', 'code' => 'RU-SAK', 'default_name' => 'Сахалинская область'),
            array('country_id' => 'RU', 'code' => 'RU-SVE', 'default_name' => 'Свердловская область'),
            array('country_id' => 'RU', 'code' => 'RU-SMO', 'default_name' => 'Смоленская область'),
            array('country_id' => 'RU', 'code' => 'RU-TAM', 'default_name' => 'Тамбовская область'),
            array('country_id' => 'RU', 'code' => 'RU-TVE', 'default_name' => 'Тверская область'),
            array('country_id' => 'RU', 'code' => 'RU-TOM', 'default_name' => 'Томская область'),
            array('country_id' => 'RU', 'code' => 'RU-TUL', 'default_name' => 'Тульская область'),
            array('country_id' => 'RU', 'code' => 'RU-TYU', 'default_name' => 'Тюменская область'),
            array('country_id' => 'RU', 'code' => 'RU-ULY', 'default_name' => 'Ульяновская область'),
            array('country_id' => 'RU', 'code' => 'RU-CHE', 'default_name' => 'Челябинская область'),
            array('country_id' => 'RU', 'code' => 'RU-ZAB', 'default_name' => 'Забайкальский край'),
            array('country_id' => 'RU', 'code' => 'RU-YAR', 'default_name' => 'Ярославская область'),
            array('country_id' => 'RU', 'code' => 'RU-MOW', 'default_name' => 'Москва'),
            array('country_id' => 'RU', 'code' => 'RU-SPE', 'default_name' => 'Санкт-Петербург'),
            array('country_id' => 'RU', 'code' => 'RU-YEV', 'default_name' => 'Еврейская автономная область'),
            array('country_id' => 'RU', 'code' => 'RU-NEN', 'default_name' => 'Ненецкий автономный округ'),
            array('country_id' => 'RU', 'code' => 'RU-KHM', 'default_name' => 'Ханты-Мансийский автономный округ - Югра'
            ),
            array('country_id' => 'RU', 'code' => 'RU-CHU', 'default_name' => 'Чукотский автономный округ'),
            array('country_id' => 'RU', 'code' => 'RU-YAN', 'default_name' => 'Ямало-Ненецкий автономный округ')
        )
    );

    $installer->getConnection()->insertMultiple(
        $installer->getTable('directory_country_region_name'),
        array(
            array('locale' => 'ru_RU', 'region_id' => '485', 'name' => 'Республика Адыгея (Адыгея)'),
            array('locale' => 'ru_RU', 'region_id' => '486', 'name' => 'Республика Башкортостан'),
            array('locale' => 'ru_RU', 'region_id' => '487', 'name' => 'Республика Бурятия'),
            array('locale' => 'ru_RU', 'region_id' => '488', 'name' => 'Республика Алтай'),
            array('locale' => 'ru_RU', 'region_id' => '489', 'name' => 'Республика Дагестан'),
            array('locale' => 'ru_RU', 'region_id' => '490', 'name' => 'Республика Ингушетия'),
            array('locale' => 'ru_RU', 'region_id' => '491', 'name' => 'Кабардино-Балкарская Республика'),
            array('locale' => 'ru_RU', 'region_id' => '492', 'name' => 'Республика Калмыкия'),
            array('locale' => 'ru_RU', 'region_id' => '493', 'name' => 'Карачаево-Черкесская Республика'),
            array('locale' => 'ru_RU', 'region_id' => '494', 'name' => 'Республика Карелия'),
            array('locale' => 'ru_RU', 'region_id' => '495', 'name' => 'Республика Коми'),
            array('locale' => 'ru_RU', 'region_id' => '496', 'name' => 'Республика Марий Эл'),
            array('locale' => 'ru_RU', 'region_id' => '497', 'name' => 'Республика Мордовия'),
            array('locale' => 'ru_RU', 'region_id' => '498', 'name' => 'Республика Саха (Якутия)'),
            array('locale' => 'ru_RU', 'region_id' => '499', 'name' => 'Республика Северная Осетия - Алания'),
            array('locale' => 'ru_RU', 'region_id' => '500', 'name' => 'Республика Татарстан (Татарстан)'),
            array('locale' => 'ru_RU', 'region_id' => '501', 'name' => 'Республика Тыва'),
            array('locale' => 'ru_RU', 'region_id' => '502', 'name' => 'Удмуртская Республика'),
            array('locale' => 'ru_RU', 'region_id' => '503', 'name' => 'Республика Хакасия'),
            array('locale' => 'ru_RU', 'region_id' => '504', 'name' => 'Чеченская Республика'),
            array('locale' => 'ru_RU', 'region_id' => '505', 'name' => 'Чувашская Республика - Чувашия'),
            array('locale' => 'ru_RU', 'region_id' => '506', 'name' => 'Алтайский край'),
            array('locale' => 'ru_RU', 'region_id' => '507', 'name' => 'Краснодарский край'),
            array('locale' => 'ru_RU', 'region_id' => '508', 'name' => 'Красноярский край'),
            array('locale' => 'ru_RU', 'region_id' => '509', 'name' => 'Ставропольский край'),
            array('locale' => 'ru_RU', 'region_id' => '510', 'name' => 'Хабаровский край'),
            array('locale' => 'ru_RU', 'region_id' => '511', 'name' => 'Амурская область'),
            array('locale' => 'ru_RU', 'region_id' => '512', 'name' => 'Архангельская область'),
            array('locale' => 'ru_RU', 'region_id' => '513', 'name' => 'Астраханская область'),
            array('locale' => 'ru_RU', 'region_id' => '514', 'name' => 'Белгородская область'),
            array('locale' => 'ru_RU', 'region_id' => '515', 'name' => 'Брянская область'),
            array('locale' => 'ru_RU', 'region_id' => '516', 'name' => 'Владимирская область'),
            array('locale' => 'ru_RU', 'region_id' => '517', 'name' => 'Волгоградская область'),
            array('locale' => 'ru_RU', 'region_id' => '518', 'name' => 'Вологодская область'),
            array('locale' => 'ru_RU', 'region_id' => '519', 'name' => 'Воронежская область'),
            array('locale' => 'ru_RU', 'region_id' => '520', 'name' => 'Ивановская область'),
            array('locale' => 'ru_RU', 'region_id' => '521', 'name' => 'Иркутская область'),
            array('locale' => 'ru_RU', 'region_id' => '522', 'name' => 'Калининградская область'),
            array('locale' => 'ru_RU', 'region_id' => '523', 'name' => 'Калужская область'),
            array('locale' => 'ru_RU', 'region_id' => '524', 'name' => 'Камчатский край'),
            array('locale' => 'ru_RU', 'region_id' => '525', 'name' => 'Кемеровская область'),
            array('locale' => 'ru_RU', 'region_id' => '526', 'name' => 'Кировская область'),
            array('locale' => 'ru_RU', 'region_id' => '527', 'name' => 'Костромская область'),
            array('locale' => 'ru_RU', 'region_id' => '528', 'name' => 'Курганская область'),
            array('locale' => 'ru_RU', 'region_id' => '529', 'name' => 'Курская область'),
            array('locale' => 'ru_RU', 'region_id' => '530', 'name' => 'Ленинградская область'),
            array('locale' => 'ru_RU', 'region_id' => '531', 'name' => 'Липецкая область'),
            array('locale' => 'ru_RU', 'region_id' => '532', 'name' => 'Магаданская область'),
            array('locale' => 'ru_RU', 'region_id' => '533', 'name' => 'Московская область'),
            array('locale' => 'ru_RU', 'region_id' => '534', 'name' => 'Мурманская область'),
            array('locale' => 'ru_RU', 'region_id' => '535', 'name' => 'Нижегородская область'),
            array('locale' => 'ru_RU', 'region_id' => '536', 'name' => 'Новгородская область'),
            array('locale' => 'ru_RU', 'region_id' => '537', 'name' => 'Новосибирская область'),
            array('locale' => 'ru_RU', 'region_id' => '538', 'name' => 'Омская область'),
            array('locale' => 'ru_RU', 'region_id' => '539', 'name' => 'Оренбургская область'),
            array('locale' => 'ru_RU', 'region_id' => '540', 'name' => 'Орловская область'),
            array('locale' => 'ru_RU', 'region_id' => '541', 'name' => 'Пензенская область'),
            array('locale' => 'ru_RU', 'region_id' => '542', 'name' => 'Пермский край'),
            array('locale' => 'ru_RU', 'region_id' => '543', 'name' => 'Псковская область'),
            array('locale' => 'ru_RU', 'region_id' => '544', 'name' => 'Ростовская область'),
            array('locale' => 'ru_RU', 'region_id' => '545', 'name' => 'Рязанская область'),
            array('locale' => 'ru_RU', 'region_id' => '546', 'name' => 'Самарская область'),
            array('locale' => 'ru_RU', 'region_id' => '547', 'name' => 'Саратовская область'),
            array('locale' => 'ru_RU', 'region_id' => '548', 'name' => 'Сахалинская область'),
            array('locale' => 'ru_RU', 'region_id' => '549', 'name' => 'Свердловская область'),
            array('locale' => 'ru_RU', 'region_id' => '550', 'name' => 'Смоленская область'),
            array('locale' => 'ru_RU', 'region_id' => '551', 'name' => 'Тамбовская область'),
            array('locale' => 'ru_RU', 'region_id' => '552', 'name' => 'Тверская область'),
            array('locale' => 'ru_RU', 'region_id' => '553', 'name' => 'Томская область'),
            array('locale' => 'ru_RU', 'region_id' => '554', 'name' => 'Тульская область'),
            array('locale' => 'ru_RU', 'region_id' => '555', 'name' => 'Тюменская область'),
            array('locale' => 'ru_RU', 'region_id' => '556', 'name' => 'Ульяновская область'),
            array('locale' => 'ru_RU', 'region_id' => '557', 'name' => 'Челябинская область'),
            array('locale' => 'ru_RU', 'region_id' => '558', 'name' => 'Забайкальский край'),
            array('locale' => 'ru_RU', 'region_id' => '559', 'name' => 'Ярославская область'),
            array('locale' => 'ru_RU', 'region_id' => '560', 'name' => 'г. Москва'),
            array('locale' => 'ru_RU', 'region_id' => '561', 'name' => 'Санкт-Петербург'),
            array('locale' => 'ru_RU', 'region_id' => '562', 'name' => 'Еврейская автономная область'),
            array('locale' => 'ru_RU', 'region_id' => '563', 'name' => 'Ненецкий автономный округ'),
            array('locale' => 'ru_RU', 'region_id' => '564', 'name' => 'Ханты-Мансийский автономный округ - Югра'),
            array('locale' => 'ru_RU', 'region_id' => '565', 'name' => 'Чукотский автономный округ'),
            array('locale' => 'ru_RU', 'region_id' => '566', 'name' => 'Ямало-Ненецкий автономный округ')
        )
    );
    $installer->endSetup();
} catch (Exception $e) {
    Mage::logException($e);
}
