<?php
/**
 * Skripsi
 *
 * @package   Rental
 * @author    Valerius Iman Supriyatno
 * @copyright 2021 Multi Mutiara Rental.
 */

namespace App\Http\Controllers;


use App\Frame\Exceptions\Message;
use App\Frame\Formatter\Trans;
use App\Frame\Mvc\AbstractDetailModel;
use App\Frame\Mvc\AbstractListingModel;
use App\Frame\Mvc\AbstractViewerModel;
use App\Models\Dao\System\SystemSettingDao;
use Exception;

/**
 *
 *
 * @package    app
 * @subpackage Http\Controllers
 * @author     Valerius Iman Supriyatno
 * @copyright  2021 Multi Mutiara Rental.
 */
class PageController extends Controller
{
    /**
     * Property to store the static allowed page category inside the system.
     *
     * @var array $AllowedPageCategory
     * */
    private $AllowedPageCategory = [
        'listing' => 'Listing',
        'detail' => 'Detail',
        'view' => 'Viewer',
    ];

    /**
     * Property to the object of model.
     *
     * @var mixed $Model
     * */
    private $Model;

    /**
     * Property to the url for fall back when there is an exception catch.
     *
     * @var string $FallBackUrl
     * */
    private $FallBackUrl = '';

    /**
     * Function to control page system.
     *
     * @param string $pageCategory To store the category of page
     *                             listing => for page listing
     *                             detail => for page detail
     *                             view => for page view
     *                             ajax => for ajax call
     * @param string $nameSpace To store the Name Space of the page.
     *
     * @return mixed
     */
    public function doControl(string $pageCategory, string $nameSpace)
    {

        $pageCategory = mb_strtolower($pageCategory);
        try {
            # Check if page category is registered inside AllowedPageCategory
            if (array_key_exists($pageCategory, $this->AllowedPageCategory) === false) {
                Message::throwMessage(Trans::getWord('pageNotFound', 'message'), 'ERROR');
            }

            # Load Model Object
            $this->loadModel($this->AllowedPageCategory[$pageCategory], $nameSpace, request()->all());

            # do control page
            return $this->doControlPage($pageCategory);

        } catch (Exception $e) {
            return view('error.error', ['error_message' => $e->getMessage(), 'back_url' => $this->FallBackUrl]);
        }
    }

    /**
     * Function to control page system.
     *
     * @param string $pageCategory To store the category of page
     *
     * @return mixed
     */
    private function doControlPage(string $pageCategory)
    {
        if ($this->Model === null) {
            Message::throwMessage(Trans::getWord('pageNotFound', 'message'), 'ERROR');
        }
        if ($pageCategory === 'listing') {
            return $this->doControlListing($this->Model);
        }
        if ($pageCategory === 'detail') {
            return $this->doControlDetail($this->Model);
        }
        if ($pageCategory === 'view') {
            return $this->doControlViewer($this->Model);
        }
        return view('errors.404');
    }

    /**
     * Function to load object model
     *
     * @param string $category To store the page path.
     * @param string $nameSpace To store the page path.
     * @param array $parameters To store the page category.
     *
     * @return void
     */
    private function loadModel(string $category, string $nameSpace, array $parameters = []): void
    {
        if (empty($nameSpace) === true) {
            Message::throwMessage('Not allowed empty name_space for ' . $category . ' page.', 'ERROR');
        }
        $pagePath = $category . '\\' . str_replace('/', '\\', $nameSpace);
        # Check custom class
        $modelPath = $this->getCustomPath($pagePath);

        if ($this->validateModelClass($modelPath) === false) {
            $modelPath = 'App\\Models\\' . $pagePath;
            if ($this->validateModelClass($modelPath) === false) {
                Message::throwMessage('Not found name_space for ' . $category . ' page.', 'ERROR');
            }
        }
        # load Class
        $this->Model = new $modelPath($parameters);
    }

    /**
     * Function to control listing screen
     *
     * @param AbstractListingModel $model
     *
     * @return mixed
     */
    protected function doControlListing(AbstractListingModel $model)
    {
        # load page setting model.
        $model->loadResultTable();
        $title = $model->Title;
        $body = $model->createViewTable();
        $script = $model->scriptTable();

        $session = session('user');

        $menu = SystemSettingDao::loadMenu();

        $data = [
            'session' => $session,
            'title' => $title,
            'menu' => $menu,
            'body' => $body,
            'script' => $script
        ];

        return view('listing', $data);
    }

        /**
     * Function to control detail screen
     *
     * @param AbstractDetailModel $model
     *
     * @return mixed
     */
    protected function doControlDetail(AbstractDetailModel $model)
    {
        $model->loadForm();
        $model->loadValidation();

        if ($this->isTokenFormValid() === true) {
            $model->doTransaction();
        }

        if ($model->isUpdate() === true) {
            $detailData = $model->loadData();
            if (empty($detailData) === false) {
                $model->setParameters($detailData);
                $model->loadForm();
            } else {
                Message::throwMessage(Trans::getWord('noDataFound', 'message'), 'ERROR');

            }
        }

        $session = session('user');
        $menu = SystemSettingDao::loadMenu();
        $title = $model->Title;
        $row = $model->createView();
        $script = $model->scriptValidation();
        $data = [
            'session' => $session,
            'title' => $title,
            'menu' => $menu,
            'row' => $row,
            'script' => $script,
        ];
        return view('detail', $data);

    }


    /**
     * Function to control view screen
     *
     * @param AbstractViewerModel $model
     *
     * @return mixed
     */
    protected function doControlViewer(AbstractViewerModel $model)
    {
        $model->loadValidation();

        if ($this->isTokenFormValid() === true) {
            $model->doTransaction();
        }
        if ($model->isUpdate() === true) {
            $detailData = $model->loadData();
            if (empty($detailData) === false) {
                $model->setParameters($detailData);
                $model->loadForm();
            } else {
                Message::throwMessage(Trans::getWord('noDataFound', 'message'), 'ERROR');

            }
        }

        $session = session('user');
        $menu = SystemSettingDao::loadMenu();
        $title = $model->Title;
        $row = $model->createView();
        $script = $model->scriptValidation();

        $data = [
            'session' => $session,
            'title' => $title,
            'menu' => $menu,
            'row' => $row,
            'script' => $script,
        ];
        return view('viewer', $data);

    }


//    protected function doControlViewer(AbstractViewerModel $model)
//    {
//        $model->loadForm();
//        $model->loadValidation();
//        if ($this->isTokenFormValid() === true) {
//            $model->doUpdate();
//        }
//        if ($model->isUpdate() === true) {
//            $detailData = $model->loadData();
//            if (empty($detailData) === false) {
//                $model->setParameters($detailData);
//                $model->loadForm();
//            } else {
//                echo 'No Data Found';
//            }
//        }
//
//        $session = session('user');
//        $title = $model->Title;
//        $row = $model->createView();
//        $script = $model->scriptValidation();
//        $data = [
//            'session' => $session,
//            'title' => $title,
//            'row' => $row,
//            'script' => ''
//        ];
//        return view('viewer', $data);
//    }
}
