<?php

namespace Astina\Bundle\FotoliaBundle\Client;

/**
 * API Exception
 */
class Fotolia_Api_Exception extends \Exception {}

interface ClientInterface
{
    /**
     * Fotolia REST uri
     */
    const FOTOLIA_REST_URI = 'api.fotolia.com/Rest';
    /**
     * Fotolia REST API version
     */
    const FOTOLIA_REST_VERSION = '1';
    /**
     * Refresh authentication token every 20 minutes
     */
    const TOKEN_TIMEOUT = 1200;
    /**
     * Time outs settings
     */
    const API_CONNECT_TIMEOUT = 30;
    const API_PROCESS_TIMEOUT = 120;
    /**
     * Language constants
     */
    const LANGUAGE_ID_FR_FR = 1;
    const LANGUAGE_ID_EN_US = 2;
    const LANGUAGE_ID_EN_GB = 3;
    const LANGUAGE_ID_DE_DE = 4;
    const LANGUAGE_ID_ES_ES = 5;
    const LANGUAGE_ID_IT_IT = 6;
    const LANGUAGE_ID_PT_PT = 7;
    const LANGUAGE_ID_PT_BR = 8;
    const LANGUAGE_ID_JA_JP = 9;
    const LANGUAGE_ID_PL_PL = 11;
    const LANGUAGE_ID_RU_RU = 12;
    const LANGUAGE_ID_ZH_CN = 13;
    const LANGUAGE_ID_TR_TR = 14;
    const LANGUAGE_ID_KO_KR = 15;

    /**
     * Returns current api key
     *
     * return string
     */
    public function getApiKey();

    /**
     * Toggle HTTPS
     */
    public function setHttpsMode($flag);

    /**
     * This method makes possible to search media in fotolia image bank.
     * Full search capabilities are available through the API
     *
     * @param  array  $search_params
     * @param  array  $result_columns if specified, a list a columns you want in the resultset
     * @return array
     */
    public function getSearchResults(array $search_params, array $result_columns = NULL);

    /**
     * This method returns childs of a parent category in fotolia representative category system.
     * This method could be used to display a part of the category system or the all tree.
     * Fotolia categories system counts three levels.
     *
     * @param  int    $language_id
     * @param  int    $id
     * @param  int    $category_type_id
     * @return array
     */
    public function getCategories1($language_id = Client::LANGUAGE_ID_EN_US, $id = 0);

    /**
     * This method returns childs of a parent category in fotolia conceptual category system.
     * This method could be used to display a part of the category system or the all tree.
     * Fotolia categories system counts three levels.
     *
     * @param  int    $language_id
     * @param  int    $id
     * @return array
     */
    public function getCategories2($language_id = Client::LANGUAGE_ID_EN_US, $id = 0);

    /**
     * This method returns most searched tag and most used tag on fotolia website.
     * This method may help you to create a tags cloud.
     *
     * @param  int    $language_id
     * @param  string $type
     * @return array
     */
    public function getTags($language_id = Client::LANGUAGE_ID_EN_US, $type = 'Used');

    /**
     * This method returns public galleries for a defined language
     *
     * @param  int    $language_id
     * @return array
     */
    public function getGalleries($language_id = Client::LANGUAGE_ID_EN_US);

    /**
     * This method returns Fotolia list of countries.
     *
     * @param  int    $language_id
     * @return array
     */
    public function getCountries($language_id = Client::LANGUAGE_ID_EN_US);

    /**
     * This method returns fotolia data
     *
     * @return array
     */
    public function getData();

    /**
     * This method is a test method which returns success if connexion is valid
     *
     * @return array
     */
    public function test();

    /**
     * This method return all information about a media
     *
     * @param  int    $id
     * @param  int    $thumbnail_size
     * @param  int    $language_id
     * @return array
     */
    public function getMediaData($id, $thumbnail_size = 110, $language_id = Client::LANGUAGE_ID_EN_US);

    /**
     * This method return all information about a series of media
     *
     * @param  array  $ids
     * @param  int    $thumbnail_size
     * @param  int    $language_id
     * @return array
     */
    public function getBulkMediaData(array $ids, $thumbnail_size = 110, $language_id = Client::LANGUAGE_ID_EN_US);

    /**
     * This method return private galleries for logged user
     *
     * @param  int    $id
     * @param  int    $language_id
     * @param  int    $thumbnail_size
     * @return array
     */
    public function getMediaGalleries($id, $language_id = Client::LANGUAGE_ID_EN_US, $thumbnail_size = 110);

    /**
     * This method allows to purchase a media and returns url to the purchased file
     *
     * @param  int    $id
     * @param  string $license_name
     * @param  int    $subaccount_id
     * @return array
     */
    public function getMedia($id, $license_name, $subaccount_id = NULL);

    /**
     * Download a media and write it to a file if necessary
     *
     * @param  string $download_url URL as returned by getMedia()
     * @param  string $output_file if null the downloaded file will be echoed on standard output
     */
    public function downloadMedia($download_url, $output_file = NULL);

    /**
     * This method returns comp images. Comp images can ONLY be used to evaluate the image
     * as to suitability for a project, obtain client or internal company approvals,
     * or experiment with layout alternatives.
     *
     * @param  int    $id
     * @return array
     */
    public function getMediaComp($id);

    /**
     * Authenticate an user
     *
     * @param  string $login User login
     * @param  string $pass User password
     */
    public function loginUser($login, $pass);

    /**
     * Log out an user
     */
    public function logoutUser();

    /**
     * Create a new Fotolia Member
     *
     * @param  array $properties
     * @return int
     */
    public function createUser(array $properties);

    /**
     * This method returns data for logged user.
     *
     * @return array
     */
    public function getUserData();

    /**
     * This method returns sales data for logged user.
     *
     * @param  string $sales_type
     * @param  int    $offset
     * @param  int    $limit
     * @param  int    $id
     * @param  string $sales_day
     * @return array
     */
    public function getSalesData($sales_type = 'all', $offset = 0, $limit = 50, $id = NULL, $sales_day = NULL);

    /**
     * This method allows you to get sales/views/income statistics from your account.
     *
     * @param  string $type
     * @param  string $time_range
     * @param  string $easy_date_period
     * @param  string $start_date
     * @param  string $end_date
     * @return array
     */
    public function getUserAdvancedStats($type, $time_range, $easy_date_period = NULL, $start_date = NULL, $end_date = NULL);

    /**
     * This methods returns statistics for logged user
     *
     * @return array
     */
    public function getUserStats();

    /**
     * Delete a user's gallery
     *
     * @param  string $id
     */
    public function deleteUserGallery($id);

    /**
     * This method allows you to create a new gallery in your account.
     *
     * @param  string $name
     * @return array
     */
    public function createUserGallery($name);

    /**
     * This method allows you to add a content to your default lightbox or any of your existing galleries
     *
     * @param  int    $content_id
     * @param  string $id
     * @return array
     */
    public function addToUserGallery($content_id, $id = '');

    /**
     * This method allows you to remove a content from your default lightbox or any of your existing galleries
     *
     * @param  int    $content_id
     * @param  string $id
     * @return array
     */
    public function removeFromUserGallery($content_id, $id = '');

    /**
     * This method allows to search media in logged user galleries or lightbox.
     *
     * @param  int    $page
     * @param  int    $per_page
     * @param  int    $thumbnail_size
     * @param  string $id
     * @return array
     */
    public function getUserGalleryMedias($page = 0, $per_page = 32, $thumbnail_size = 110, $id = '');

    /**
     * This method returns private galleries for logged user.
     *
     * @return array
     */
    public function getUserGalleries();

    /**
     * This method allows move up media in logged user galleries or lightbox.
     *
     * @param  int    $content_id
     * @param  string $id
     * @throws Fotolia_Services_Exception
     */
    public function moveUpMediaInUserGallery($content_id, $id = '');

    /**
     * This method allows move down media in logged user galleries or lightbox.
     *
     * @param  int    $content_id
     * @param  string $id
     * @throws Fotolia_Services_Exception
     */
    public function moveDownMediaInUserGallery($content_id, $id = '');

    /**
     * This method allows move a media to top position in logged user galleries or lightbox.
     *
     * @param  int    $content_id
     * @param  string $id
     * @throws Fotolia_Services_Exception
     */
    public function moveMediaToTopInUserGallery($content_id, $id = '');

    /**
     * Create a new subaccount for the given api key
     *
     * @param  array $subaccount_data
     * @return int
     */
    public function subaccountCreate($subaccount_data);

    /**
     * Edit a subaccount of the given api key
     *
     * @param  int   $subaccount_id
     * @param  array $subaccount_data
     */
    public function subaccountEdit($subaccount_id, $subaccount_data);

    /**
     * Delete a subaccount of the given api key
     *
     * @param  int   $subaccount_id
     */
    public function subaccountDelete($subaccount_id);

    /**
     * Returns the ids of all subaccounts of the api key
     *
     * @return array
     */
    public function subaccountGetIds();

    /**
     * Returns details of a given subaccount
     *
     * @param  int   $subaccount_id
     * @return array
     */
    public function subaccountGet($subaccount_id);

    /**
     * Returns the purchased contents of a given subaccount
     *
     * @param  int    $subaccount_id
     * @param  int    $page current page number
     * @param  int    $nb_per_page number of downloads per page
     * @return array
     */
    public function subaccountgetPurchasedContents($subaccount_id, $page = 1, $nb_per_page = 10);

    /**
     * Retrieve the content of the shopping cart
     * @return array
     */
    public function shoppingcartGetList();

    /**
     * Clear the content of the shopping cart
     * @return array
     */
    public function shoppingcartClear();

    /**
     * Transfer one or more files from the shopping cart to a lightbox
     *
     * @param  int|array $id
     * @return array
     */
    public function shoppingtransferToLightbox($id);

    /**
     * Add a content to the shopping cart
     *
     * @param  int $id
     * @param  string $license_name
     * @return array
     */
    public function shoppingcartAdd($id, $license_name);

    /**
     * Update a content to the shopping cart
     *
     * @param  int $id
     * @param  string $license_name
     * @return array
     */
    public function shoppingcartUpdate($id, $license_name = NULL);

    /**
     * Delete a content from the shopping cart
     *
     * @param  int $id
     * @return array
     */
    public function shoppingcartRemove($id);
}
