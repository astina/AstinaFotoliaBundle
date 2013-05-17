<?php

namespace Astina\Bundle\FotoliaBundle\Client;

class CacheClient implements ClientInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $cacheDir;

    /**
     * @var int seconds timeout
     */
    private $lifetime;

    /**
     * @param ClientInterface $client
     * @param $cacheDir
     * @param $lifetime
     * @throws \Exception
     */
    public function __construct(ClientInterface $client, $cacheDir, $lifetime)
    {
        $this->client = $client;
        $this->cacheDir = $cacheDir;
        $this->lifetime = $lifetime;

        if (!file_exists($cacheDir) && !mkdir($cacheDir, 0755, true)) {
            throw new \Exception('Cache dir does not exist and could not be created: ' . $cacheDir);
        }
    }

    /**
     * Tries to find a cached result for the givenapi call.
     * Executes the api call if no cached result is found.
     *
     * @param $method
     * @param $args
     * @return mixed|null
     */
    private function callCached($method, $args)
    {
        if ($data = $this->findCachedData($method, $args)) {
            return $data;
        }

        $data = call_user_func_array(array($this->client, $method), $args);

        $this->writeCachedData($method, $args, $data);

        return $data;
    }

    /**
     * @param $method
     * @param array $params
     * @return mixed|null
     */
    private function findCachedData($method, array $params)
    {
        $cacheFile = $this->getCacheFile($method, $params);

        if (!file_exists($cacheFile) || filemtime($cacheFile) < (time() - $this->lifetime)) {
            return null;
        }

        $contents = file_get_contents($cacheFile);

        return unserialize($contents);
    }

    /**
     * @param $method
     * @param array $params
     * @param $data
     */
    private function writeCachedData($method, array $params, $data)
    {
        $cacheFile = $this->getCacheFile($method, $params);

        file_put_contents($cacheFile, serialize($data));
    }

    /**
     * @param $method
     * @param array $params
     * @return string
     */
    private function getCacheFile($method, array $params)
    {
        $key = sprintf('%s#%s', $method, crc32(var_export($params, true)));

        return sprintf('%s/%s', $this->cacheDir, $key);
    }

    /**
     * @param array $search_params
     * @param array $result_columns
     * @return array|mixed|null
     */
    public function getSearchResults(array $search_params, array $result_columns = NULL)
    {
        return $this->callCached(__FUNCTION__, func_get_args());
    }

    /**
     * @param int $id
     * @param int $thumbnail_size
     * @param int $language_id
     * @return array|mixed|null
     */
    public function getMediaData($id, $thumbnail_size = 110, $language_id = Client::LANGUAGE_ID_EN_US)
    {
        return $this->callCached(__FUNCTION__, func_get_args());
    }

    /**
     * @param int $id
     * @param string $license_name
     * @param null $subaccount_id
     * @return array|mixed|null
     */
    public function getMedia($id, $license_name, $subaccount_id = NULL)
    {
        return $this->callCached(__FUNCTION__, func_get_args());
    }

    /**
     * @param int $id
     * @return array|mixed|null
     */
    public function getMediaComp($id)
    {
        return $this->callCached(__FUNCTION__, func_get_args());
    }

    /** The following calls are not cached  */

    public function getApiKey() { return $this->client->getApiKey(); }
    public function setHttpsMode($flag) { return $this->client->setHttpsMode($flag); }
    public function getData() { return $this->client->getData(); }
    public function getCategories1($language_id = Client::LANGUAGE_ID_EN_US, $id = 0) { return $this->client->getCategories1($language_id, $id); }
    public function getCategories2($language_id = Client::LANGUAGE_ID_EN_US, $id = 0) { return $this->client->getCategories2($language_id, $id); }
    public function getTags($language_id = Client::LANGUAGE_ID_EN_US, $type = 'Used') { return $this->client->getTags($language_id, $type); }
    public function getGalleries($language_id = Client::LANGUAGE_ID_EN_US) { return $this->client->getGalleries($language_id); }
    public function getCountries($language_id = Client::LANGUAGE_ID_EN_US) { return $this->client->getCountries($language_id); }
    public function test() { return $this->client->test(); }
    public function getBulkMediaData(array $ids, $thumbnail_size = 110, $language_id = Client::LANGUAGE_ID_EN_US) { return $this->client->getBulkMediaData($ids, $thumbnail_size, $language_id); }
    public function getMediaGalleries($id, $language_id = Client::LANGUAGE_ID_EN_US, $thumbnail_size = 110) { return $this->client->getMediaGalleries($id, $language_id, $thumbnail_size); }
    public function downloadMedia($download_url, $output_file = NULL) { return $this->client->downloadMedia($download_url, $output_file); }
    public function loginUser($login, $pass) { $this->client->loginUser($login, $pass); }
    public function logoutUser() { $this->client->logoutUser(); }
    public function createUser(array $properties) { return $this->client->createUser($properties); }
    public function getUserData() { return $this->client->getUserData(); }
    public function getSalesData($sales_type = 'all', $offset = 0, $limit = 50, $id = NULL, $sales_day = NULL) { return $this->client->getSalesData($sales_type, $offset, $limit, $id, $sales_day); }
    public function getUserAdvancedStats($type, $time_range, $easy_date_period = NULL, $start_date = NULL, $end_date = NULL) { return $this->client->getUserAdvancedStats($type, $time_range, $easy_date_period, $start_date, $end_date); }
    public function getUserStats() { return $this->client->getUserStats(); }
    public function deleteUserGallery($id) { $this->client->deleteUserGallery($id); }
    public function createUserGallery($name) { return $this->client->createUserGallery($name); }
    public function addToUserGallery($content_id, $id = '') { return $this->client->addToUserGallery($content_id, $id); }
    public function removeFromUserGallery($content_id, $id = '') { return $this->client->removeFromUserGallery($content_id, $id); }
    public function getUserGalleryMedias($page = 0, $per_page = 32, $thumbnail_size = 110, $id = '') { return $this->client->getUserGalleryMedias($page, $per_page, $thumbnail_size, $id); }
    public function getUserGalleries() { return $this->client->getUserGalleries(); }
    public function moveUpMediaInUserGallery($content_id, $id = '') { $this->client->moveUpMediaInUserGallery($content_id, $id); }
    public function moveDownMediaInUserGallery($content_id, $id = '') { $this->client->moveDownMediaInUserGallery($content_id, $id); }
    public function moveMediaToTopInUserGallery($content_id, $id = '') { $this->client->moveMediaToTopInUserGallery($content_id, $id); }
    public function subaccountCreate($subaccount_data) { return $this->client->subaccountCreate($subaccount_data); }
    public function subaccountEdit($subaccount_id, $subaccount_data) { $this->client->subaccountEdit($subaccount_id, $subaccount_data); }
    public function subaccountDelete($subaccount_id) { $this->client->subaccountDelete($subaccount_id); }
    public function subaccountGetIds() { return $this->client->subaccountGetIds(); }
    public function subaccountGet($subaccount_id) { return $this->client->subaccountGet($subaccount_id); }
    public function subaccountgetPurchasedContents($subaccount_id, $page = 1, $nb_per_page = 10) { return $this->client->subaccountgetPurchasedContents($subaccount_id, $page, $nb_per_page); }
    public function shoppingcartGetList() { return $this->client->shoppingcartGetList(); }
    public function shoppingcartClear() { return $this->client->shoppingcartClear(); }
    public function shoppingtransferToLightbox($id) { return $this->client->shoppingtransferToLightbox($id); }
    public function shoppingcartAdd($id, $license_name) { return $this->client->shoppingcartAdd($id, $license_name); }
    public function shoppingcartUpdate($id, $license_name = NULL) { return $this->client->shoppingcartUpdate($id, $license_name); }
    public function shoppingcartRemove($id) { return $this->client->shoppingcartRemove($id); }
}
