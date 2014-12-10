<?php
/**
 * This example creates a new template creative for a given advertiser. To
 * determine which companies are advertisers, run
 * GetCompaniesByStatementExample.php. To determine which creatives already
 * exist, run GetAllCreativesExample.php. To determine which creative templates
 * exist, run GetAllCreativeTemplatesExample.php
 *
 * Tags: CreativeService.createCreatives
 *
 * PHP version 5
 *
 * Copyright 2013, Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package    GoogleApiAdsDfp
 * @subpackage v201405
 * @category   WebServices
 * @copyright  2013, Google Inc. All Rights Reserved.
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License,
 *             Version 2.0
 * @author     Eric Koleda
 */
error_reporting(E_STRICT | E_ALL);

// You can set the include path to src directory or reference
// DfpUser.php directly via require_once.
// $path = '/path/to/dfp_api_php_lib/src';
$path = dirname(__FILE__) . '/../../../../lib';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

require_once 'Google/Api/Ads/Dfp/Lib/DfpUser.php';
require_once dirname(__FILE__) . '/../../../Common/ExampleUtils.php';
require_once 'Google/Api/Ads/Common/Util/MediaUtils.php';

try {
    // Get DfpUser from credentials in "../auth.ini"
    // relative to the DfpUser.php file's directory.
    $user = new DfpUser();

    // Log SOAP XML request and response.
    $user->LogDefaults();

    // Get the CreativeService.
    $creativeService = $user->GetService('CreativeService', 'v201405');

    // Set the ID of the advertiser (company) that all creatives will be
    // assigned to.
    $advertiserId = '52506489';

    // Use the image banner with optional third party tracking template.
    $creativeTemplateId = 10050249;

    // Create the local custom creative object.
    $templateCreative = new TemplateCreative();
    $templateCreative->name = 'Как сделать символ 2015 года своими руками';
    $templateCreative->advertiserId = $advertiserId;
    $templateCreative->creativeTemplateId = $creativeTemplateId;

    // Set the creative size.
    $templateCreative->size = new Size(240, 400, FALSE);


    // Create the URL variable value.
    $urlVariableValue = new UrlCreativeTemplateVariableValue();
    $urlVariableValue->uniqueName = 'imageURL';
    $urlVariableValue->value = 'http://img.happy-giraffe.ru/thumbs/240x/415089/66fe52b6c625baafec73b2cdbbb47866.jpg';
    $templateCreative->creativeTemplateVariableValues[] = $urlVariableValue;

    // Create the URL variable value.
    $urlVariableValue = new UrlCreativeTemplateVariableValue();
    $urlVariableValue->uniqueName = 'URLlink';
    $urlVariableValue->value = 'http://www.happy-giraffe.ru/user/415089/blog/post222749/';
    $templateCreative->creativeTemplateVariableValues[] = $urlVariableValue;

    // Create the URL variable value.
    $urlVariableValue = new StringCreativeTemplateVariableValue();
    $urlVariableValue->uniqueName = 'title';
    $urlVariableValue->value = 'Как сделать символ 2015 года своими руками';
    $templateCreative->creativeTemplateVariableValues[] = $urlVariableValue;

    // Create the template creative on the server.
    $templateCreatives =
        $creativeService->createCreatives(array($templateCreative));

    foreach ($templateCreatives as $templateCreative) {
        printf("A template creative with ID '%s', name '%s', and type '%s' was "
            . "created and can be previewed at: %s\n", $templateCreative->id,
            $templateCreative->name, $templateCreative->CreativeType,
            $templateCreative->previewUrl);
    }
} catch (OAuth2Exception $e) {
    ExampleUtils::CheckForOAuth2Errors($e);
} catch (ValidationException $e) {
    ExampleUtils::CheckForOAuth2Errors($e);
} catch (Exception $e) {
    printf("%s\n", $e->getMessage());
}

